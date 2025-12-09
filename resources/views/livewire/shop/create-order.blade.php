<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Cart;
use App\Models\Product;

new
#[Layout('components.layouts.app')]
#[Title('JDG Sklep - formularz zamówienia')]
class extends Component {
    public $shoppingCart;
    public $products;
    public $total;

    public function mount () {
        $cartId = request()->cookie('cartId');
        if (!isset($cartId)) return;
        $this->shoppingCart = Cart::find($cartId);
        if (!isset($this->shoppingCart) || !isset($this->shoppingCart->cart)) return;

        $cart_products = json_decode($this->shoppingCart->cart, true);

        // Get products from DB
        $products = Product::whereIn('id', array_keys($cart_products))->get();
        
        // add quantity property to every product based on cart data
        $this->products = $products->map(function ($product) use ($cart_products) {
            $product->quantity = $cart_products[$product->id];
            return $product;
        })->toArray();

        $this->total = $products->reduce(fn($sum, $product) => $sum += $product->price * $product->quantity);
    }
}; ?>

<div>
    <div class="bg-white px-8 xs:px-16 lg:px-32 py-20 flex justify-between items-end">
        <h1 class="page-title">Twoje zamówienie</h1>
        <a href="/shop" class="flex gap-4 items-end text-sea-dark sm:mb-1">
            <span class="hidden sm:inline">kontynuuj zakupy</span>
            <x-icon.sqr-arrow-up class="w-7 h-7 mb-1"/>
        </a>
    </div>
    @if(!empty($products))
        <div class="bg-light-grey px-4 lg:px-8 py-8 flex flex-col-reverse md:flex-row gap-12 mb-16">
            <section class="md:w-3/5">
                <livewire:shop.order-form :products="$products" :total="$total" :shoppingCart="$shoppingCart" />
            </section>
            <section class="min-w-xs md:w-2/5">
                <x-shop.order-summary :products="$products" :total-price="$total"/>
            </section>
        </div>
    @else
        <div class="bg-light-grey mb-16">
            <p>Brak produków. Sprawdź naszą <a href="/shop">ofertę</a>.</p>
        </div>
    @endif
</div>
