<?php

namespace App\Http\Controllers;

use App\Enums\EnumGateway;
use App\Enums\EnumPaymentMethods;
use App\Enums\EnumPaymentStatus;
use App\Models\Order;
use App\Models\Transaction;
use App\Traits\CartTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as ShetaBitPayment;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

class PaymentController extends Controller
{
    use CartTrait;

    public function payment(Request $request)
    {
        $order = Order::find($request->order_id);
        try {
            $this->validate($request, [
                'order_id' => 'required|exists:orders,id',
                'gateway' => 'required|in:' . EnumGateway::asStringValues(),
                'payment_method' => 'required|in:' . EnumPaymentMethods::asStringValues(),
            ],[],[
                'order_id' => 'شماره سفارش',
                'gateway' => 'روش پرداخت',
                'payment_method' => 'درگاه پرداخت',
            ]);
            $price = $order->order_amount;
            $gateway = strtolower($request->gateway);
            $invoice = (new Invoice)->amount($price);
            $paymentMethod = $request->payment_method;

            // $config = $this->getPaymentConfig($gateway);
            $config = [
                'merchantId' => env('ZARINPAL_MERCHANT_ID'),
                'currency' => env('ZARINPAL_CURRENCY'),
                'mode' => env('ZARINPAL_MODE'),
                'description' => "payment using zarinpal",
            ];
                // dd($gateway, $config, $price, $order, route("payment.verify"));
            try {
                $res = ShetaBitPayment::via($gateway)->config($config)->callbackUrl(route("payment.verify"))->purchase(
                    $invoice,
                    function ($driver, $transactionId) use ($price, $order, $gateway, $paymentMethod) {
                        $order->transctions()->create([
                            'transaction_id' => (string)$transactionId,
                            'amount' => $price,
                            'gateway' => $gateway,
                            'payment_method' => $paymentMethod,
                            'user_id' => Auth::id()
                        ])->setStatus(EnumPaymentStatus::CREATED, 'created payments');
                    }
                )->pay()->render();
                return $res;
            } catch (\Exception $exception) {
                return view('panels.payments.failed')->with(['error' => $exception->getMessage(), 'order' => $order]);
            }
        } catch (ValidationException $exception) {
            return view('panels.payments.failed')->with(['error' => $exception->getMessage(), 'order' => $order]);
        } catch (InvalidPaymentException $exception) {
            return view('panels.payments.failed')->with(['error' => $exception->getMessage(), 'order' => $order]);
        }
    }

    public function verify(Request $request)
    {
        // dd($request->all());
        // $paymentDetails = $this->getPaymentDetails($request);
        $paymentDetails = [
            'payment' => Transaction::where('transaction_id', $request->Authority)->first(),
            'responseCode' => $request->Status,
            'transactionId' => $request->Authority
        ];
        $payment = $paymentDetails['payment'];
        $order = $payment->order;
        if (!$payment) {
            return view('panels.payments.failed', compact('order'))->with('error' , 'اطلاعات کافی برای درگاه پرداخت وجود ندارد. با پشتیبانی تماس بگیرد. تشکر از صبوری شما');
        }
        try {
            if($paymentDetails['responseCode'] == "OK"){
                DB::beginTransaction();
                $receipt = ShetaBitPayment::amount((int)$payment->amount)->transactionId($paymentDetails['transactionId'])->verify();
                // $payment->status_id = Status::where('name', 'complete')->payment()->first()?->id ?: 6;
                $payment->setStatus(EnumPaymentStatus::COMPLETED, 'payment completed');
                $payment->load('order.orderItems');
                $order = $payment->order;

                if($order){
                    // $statusId = Status::where('name', 'processing')->payment()->first()?->id ?: 2;
                    $order->setStatus(EnumPaymentStatus::COMPLETED, 'Payment Completed');
                    // foreach($order->orderItems as $orderItem){
                        // $orderItem->update(['status_id' => $statusId]);
                        // $orderItem->variantProduct ? $orderItem->variantProduct->decrement('inventory', $orderItem->quantity) : $orderItem->product?->decrement('inventory', $orderItem->quantity);
                    // }
                }
                $this->emptyCart();

                // $discountCode = session()->get('discount');
                // if(isset($discountCode['discount_code_id'])){
                //     UsedDiscount::create([
                //         'discount_code_id' => $discountCode['discount_code_id'],
                //         'used_at' => now(),
                //         'used_by' => Auth::id()
                //     ]);
                //     session()->forget('discount');
                //     session()->forget('paymentDetails');
                // }
                DB::commit();
                return view('panels.payments.success', compact('payment', 'order'))->with('success', 'پرداخت با موفقیت انجام شد.');
            }else{
                // $payment->update(['status_id' => Status::where('name', 'failed')->payment()->first()?->id ?: 7]);
                $payment->setStatus(EnumPaymentStatus::FAILED, 'Response code has not found');
                return view('panels.payments.failed', compact('order'))->with('error' , 'پرداخت موفقیت آمیز نبود.');
            }
        } catch (InvalidPaymentException $exception) {
            $payment->setStatus(EnumPaymentStatus::FAILED, $exception->getMessage());
            return view('panels.payments.failed', compact('order'))->with('error' , $exception->getMessage());
        }
    }

    protected function getPaymentDetails(Request $request)
    {
        $paymentDetails = session()->get('paymentDetails');
        switch ($paymentDetails['gateway']) {
            case 'zarinpal':
                $transactionId = $request->Authority;
                $responseCode = $request->Status == "OK";
                break;
            case 'behpardakht':
                $transactionId = $request->RefId;
                $responseCode = $request->ResCode == 0;
                break;
            case 'zibal':
                $transactionId = $request->trackId;
                $responseCode = $request->success == 1;
                break;

            default:
                $transactionId = $request->trackId;
                $responseCode = $request->success == 1;
                break;
        }

        return [
            'payment' => Transaction::where('transaction_id', $transactionId)->first(),
            'responseCode' => $responseCode,
            'transactionId' => $transactionId
        ];
    }
}
