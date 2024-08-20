<?php

namespace App\Livewire\Dashboard\Payments;

use App\Enums\EnumContractTypes;
use App\Enums\EnumGateway;
use App\Enums\EnumOrderPaymentStatus;
use App\Enums\EnumOrderStatus;
use App\Enums\EnumOrderType;
use App\Enums\EnumPaymentMethods;
use App\Enums\EnumPaymentTypes;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\AlertLiveComponent;
use App\Traits\CartTrait;
use App\Traits\OrderTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LiveCheckout extends Component
{
    use CartTrait, AlertLiveComponent, OrderTrait;

    protected $listeners = ['destroy'];

    public $paymentMethod;
    public $gateway;
    public $type; // tuition, book
    public $data = [];
    public $carts = [];
    public $title;

    public function checkoutValidation()
    {
        $this->validate([
            'paymentMethod' => 'required|in:' . EnumPaymentMethods::asStringValues(),
            'gateway' => 'required|in:' . EnumGateway::asStringValues(),
        ],[],[
            'paymentMethod' => 'روش پرداخت',
            'gateway' => 'درگاه پرداخت',
        ]);
    }

    public function userInfoValidation()
    {
        $this->validate([
            'data.first_name' => 'required|string|max:255',
            'data.last_name' => 'required|string|max:255',
            'data.email' => 'nullable|email|max:255',
            'data.address' => 'required|string|max:2550',
        ],[],[
            'data.first_name' => 'نام',
            'data.last_name' => 'نام خانوادگی',
            'data.email' => 'پست الکترونیکی',
            'data.address' => 'آدرس منزل',
        ]);
    }

    public function mount()
    {
        $this->title = 'صورتحساب';
        Config::set('app.name', $this->title);
        $user = Auth::user();
        $this->data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'address' => $user->userInfo?->address,
        ];
        
        $this->paymentMethod = EnumPaymentMethods::CREDIT_CARD;
        $this->gateway = EnumGateway::Zarinpal;
        $this->type = EnumOrderType::TUITION;
    }

    public function loadData()
    {
        $carts = Auth::user()->carts;
        foreach($carts as $cart){
            $this->carts[] = [
                'id' => $cart->id,
                'price' => $cart->total_price,
                'title' => $cart->cartable?->title,
                'description' => ''
            ];
        }
    }

    public function destroy($id)
    {
        $this->deleteCart($id);
        $this->alert('آیتم حذف شد')->success();
        $this->loadPrices();
        if(count($this->carts) === 0){
            return redirect()->to(route('profile.classes.index'));
        }
    }

    protected function createOrder()
    {
        $contractNumber = $this->type === EnumOrderType::TUITION ? $this->generateContractNumber(Auth::user()->userInfo?->gender, $this->orderItem) : $this->generateBookContractNumber($book);
        $orderNumber = $this->orderNumber ?: $this->getOrderNumber(Auth::id());
        $order = Order::create([
            'orderable_id' => $this->orderItem->id,
            'orderable_type' => get_class($this->orderItem),
            'type' => $this->type,
            'user_id' => Auth::id(),
            'contract_number' => $contractNumber,
            'contract_type' => EnumContractTypes::NEW_TERM, // new_term, new_course
            'payment_type' => EnumPaymentTypes::FULL,
            'payment_method' => $this->paymentMethod,
            'payment_status' => EnumOrderPaymentStatus::DEBT,
            'gateway' => $this->gateway,
            'tax' => $this->tax,
            'discount_amount' => $this->discountPrice,
            'order_amount' => $this->payablePrice,
            'paid_amount' => 0,
            'register_date' => Carbon::now(),
            'description' => 'Order Created',
            'renewal_number' => $this->generateRenewalNumber(Auth::user()),
            'order_number' => $orderNumber,
            'age_range' => $this->ageRange ?? null,
        ]);
        $this->createOrderItem($order);
        $order->setStatus(EnumOrderStatus::CREATED, 'سفارش توسط کاربر ایجاد شد.');
        return $order;
    }

    protected function createOrderItem($order)
    {
        $carts = Auth::user()->carts;
        foreach($carts as $cart){
            $orederItem = OrderItem::create([
                'order_id' => $order->id,
                'orderable_id' => $cart->cartable_id,
                'orderable_type' => $cart->cartable_type,
                'type' => $this->type,
                'tax' => $cart->tax,
                'discount_amount' => $cart->total_discount,
                'quantity' => $cart->quantity,
                'item_amount' => $cart->cartable->price,
                'total_amount' => $cart->total_price,
            ]);
        }
    }

    public function submitUserInfo()
    {
        $this->userInfoValidation();
        try {
            $user = Auth::user();
            $user->update([
                'first_name' => $this->data['first_name'],
                'last_name' => $this->data['last_name'],
            ]);
            $user->userInfo()->update([
                'email' => $this->data['email'] ?? $user->userInfo?->email,
                'address' => $this->data['address'],
            ]);
            $this->alert('اطلاعات با موفقیت ویرایش شد.')->success();
        } catch (Exception $e) {
            return $this->alert($e->getMessage())->error();
        }
    }

    public function pay()
    {
        try {
            $this->checkoutValidation();
            if(!$this->orderItem){
                return $this->alert('محصول مورد نظر پیدا نشد.')->error();
            }
            $order = $this->createOrder();
            // dd($order);
            return redirect()->to(route('payment.create', [
                'order_id' => $order,
                'gateway' => $this->gateway,
                'payment_method' => $this->paymentMethod
            ]));
        } catch (ValidationException $e){
            return $this->alert($e->getMessage())->error();
        } catch (Exception $e) {
            return $this->alert($e->getMessage())->error();
        }
    }

    public function render()
    {
        $settings = [
            'payment_methods' => [
                'credit_card',
                'wallet',
            ],
            'gateway' => [
                'zarinpal'
            ],
        ];
        $gateways = Arr::where(EnumGateway::All(), function ($value, $key) use ($settings) {
            // return in_array($value, setting('gateway'));
            return in_array($value, $settings['gateway']);
        });
        return view('livewire.dashboard.payments.live-checkout', compact('gateways'))
            ->extends('layouts.panel')->section('content');
    }
}
