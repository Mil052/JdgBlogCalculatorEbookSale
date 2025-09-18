<?php

use Livewire\Volt\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

new class extends Component {
    public $productId;

    public function mount ($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart ()
    {   
        $cart = null;
        $cart_products = [];
        // Check if user has a cart
        $cartId = request()->cookie('cartId');
        if ($cartId) {
            $cart = Cart::find($cartId);
        }
        // if user already has a cart - add product to cart
        if (isset($cart)) {
            $cart_products = json_decode($cart->cart, true);
            if (isset($cart_products[$this->productId])) {
                $cart_products[$this->productId] += 1;
            } else {
                $cart_products[$this->productId] = 1;
            }
        // if user does not have a cart - create one
        } else {
            $cart = new Cart;
            $cart_products = array($this->productId => 1);
        }

        $cart->cart = json_encode($cart_products);
        $cart->save();
        // Set cookie with expiration for 7 days
        Cookie::queue('cartId', $cart->id, 10080);
        
        $this->dispatch('added-to-cart')->to('shop.cart-link-icon');
    }
}; ?>

<button type="button" wire:click="addToCart">
    dodaj do koszyka (product id: {{ $productId }})
</button>
