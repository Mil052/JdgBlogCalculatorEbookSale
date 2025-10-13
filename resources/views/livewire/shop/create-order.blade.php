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
        if (!isset($this->shoppingCart)) return;

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
    <div class="bg-white pl-35 pr-8 py-20 flex justify-between items-end">
        <h1 class="page-title">Twoje zamówienie</h1>
        <a href="/shop" class="flex gap-6 items-end">
            <span>kontynuuj zakupy</span>
            <x-icon.sqr-arrow-up class="w-8 h-8"/>
        </a>
    </div>
    @if(!empty($products))
        <div class="bg-light-grey flex flex-col md:flex-row gap-8 mb-16">
            <section class="md:w-3/5">
                <livewire:shop.order-form :products="$products" :total="$total" :shoppingCart="$shoppingCart" />
            </section>
            <section>
                <x-shop.order-summary :products="$products" :total-price="$total"/>
            </section>
        </div>
    @else
        <div class="bg-light-grey mb-16">
            <p>Brak produków. Sprawdź naszą <a href="/shop">ofertę</a>.</p>
        </div>
    @endif
</div>
