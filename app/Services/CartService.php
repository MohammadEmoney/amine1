<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartService
{
    public function addToCart($item, $quantity, $tax, $total_discount, $total_price)
    {
        $cart = Cart::updateOrCreate(
            [
                'cartable_type' => get_class($item),
                'cartable_id' => $item->id,
                'user_id' => Auth::id(),
            ],
            [
                'uuid' => Str::uuid(),
                'quantity' => $quantity,
                'tax' => $tax,
                'total_discount' => $total_discount,
                'total_price' => $total_price,
            ]
        );

        return $cart;
    }

    public function updateCart($cartId, $quantity, $tax, $discount)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->update([
                'quantity' => $quantity,
                'tax' => $tax,
                'total_discount' => $discount,
                'total_price' => ($cart->cartable->price * $quantity) + $tax - $discount,
            ]);
        }

        return $cart;
    }

    public function removeFromCart($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->delete();
        }

        return $cart;
    }

    public function removeAllItems($userId)
    {
        return Cart::where('user_id', $userId)->delete();
    }

    public function getCartItems()
    {
        return Cart::where('user_id', Auth::id())->with('cartable')->get();
    }
}