<?php

namespace App\Traits;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Semester;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait CartTrait
{
    protected $cartService;
    public $carts = [];
    public $totalPrice;
    public $discountPrice = 0;
    public $payablePrice;
    public $tax = 0;
    public $orderItem;

    public function mountCartTrait()
    {
        $cartService = new CartService();
        $carts = $cartService->getCartItems();
        foreach($carts as $cart){
            $this->carts[] = [
                'id' => $cart->id,
                'price' => $cart->total_price,
                'title' => $cart->cartable?->title,
                'cartable_id' => $cart->cartable_id,
                'cartable_type' => $cart->cartable_type,
                'description' => ''
            ];
        }
        $this->loadPrices();
        $this->getOrderItem();
    }

    public function loadPrices()
    {
        $this->totalPrice = collect($this->carts)->sum('price');
        $this->payablePrice = $this->getTaxAmount($this->tax, $this->totalPrice) + $this->totalPrice - $this->discountPrice;
    }

    protected function getOrderItem()
    {
        $cart = collect($this->carts)->first();
        if($cart){
            if($cart['cartable_type'] === "App\Models\Semester"){
                $this->orderItem = Semester::find($cart['cartable_id']);
            }
            if($cart['cartable_type'] === "App\Models\Book"){
                $this->orderItem = Book::find($cart['cartable_id']);
            }
        }
    }

    public function addSemesterToCart(Semester $semester)
    {
        $cartService = new CartService();
        $cart = $cartService->addToCart(
            $semester,
            1,
            0,
            0,
            $semester->tuition_fee
        );
    }

    public function deleteCart($cartId)
    {
        $cartService = new CartService();
        $cartService->removeFromCart($cartId);
        $this->carts = array_filter($this->carts, function ($item) use ($cartId) {
            return $item['id'] !== $cartId;
        });
    }

    public function emptyCart()
    {
        $cartService = new CartService();
        $cartService->removeAllItems( Auth::id() );
    }

    public function getTaxAmount($tax, $price)
    {
        return ($tax * $price) / 100;
    }

    protected function calculatePrices()
    {
        $this->calculateTotalPrice();
        $this->calculateTotalSalesPrice();
        $this->calculateTotalDiscountPrice();
        $this->calculateRealDiscount();
    }

    protected function calculateTotalPrice()
    {
        $this->totalPrice = collect($this->carts)->pluck('sub_total_price')->sum();
    }

    protected function calculateTotalSalesPrice()
    {
        $this->totalSalesPrice = collect($this->carts)->pluck('sub_total_sales_price')->sum();
    }

    protected function calculateTotalDiscountPrice()
    {
        $this->totalDiscount = collect($this->carts)->pluck('sub_total_discount')->sum();
    }

    protected function calculateRealDiscount()
    {
        $this->realDiscount = $this->totalSalesPrice - $this->totalPrice;
    }
}
