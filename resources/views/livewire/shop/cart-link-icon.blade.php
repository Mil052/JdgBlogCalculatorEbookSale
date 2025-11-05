<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{ On, Computed };
use App\Models\Cart;

new class extends Component {
    #[Computed]
    public function numberOfProducts () {
        $cartId = request()->cookie('cartId');
        if (!isset($cartId)) return null;

        $cart = Cart::find($cartId);
        if (!isset($cart) || !isset($cart->cart)) return null;
        
        $products = json_decode($cart->cart, true);
        return array_reduce($products, fn($carry, $item) => $carry + $item);
    }
}; ?>

<div class="relative" @cart-change="$wire.$refresh()">
    <a href="/shop/cart">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.86073 9.8356C4.9411 9.35341 5.35829 9 5.84713 9H18.1529C18.6417 9 19.0589 9.35341 19.1393 9.8356L20.8059 19.8356C20.9075 20.4451 20.4375 21 19.8195 21H4.18046C3.56252 21 3.09248 20.4451 3.19407 19.8356L4.86073 9.8356Z" stroke="#785f5f" stroke-width="1.5"/>
            <path d="M16 12V7C16 4.79086 14.2091 3 12 3V3C9.79086 3 8 4.79086 8 7V12" stroke="#785f5f" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </a>
    <div class="absolute -top-2 -left-2 text-red-brick">{{ $this->numberOfProducts }}</div>
</div>
