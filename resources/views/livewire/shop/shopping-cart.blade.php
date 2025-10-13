<?php

use Livewire\Volt\Component;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Computed;

new class extends Component {
    public $shopping_cart;
    public $cart_products;
    public $products;

    public function mount ()
    {
        $cartId = request()->cookie('cartId');
        if (!isset($cartId)) return;

        $this->shopping_cart = Cart::find($cartId);
        if (!isset($this->shopping_cart)) return;

        $this->cart_products = json_decode($this->shopping_cart->cart, true);

        $this->products = Product::whereIn('id', array_keys($this->cart_products))->get();
    }


    #[Computed]
    public function total () {
        if (!isset($this->products)) return null;
        return $this->products->reduce(function($sum, $item) {
            return $sum + ($item->price * $this->cart_products[$item->id]);
        });
    }

    public function increaseProductQuantity (string $productId) {
        $this->cart_products[$productId] += 1;
        $this->shopping_cart->cart = json_encode($this->cart_products);
        $this->shopping_cart->save();
        // notify cart-link-icon
        $this->dispatch('cart-change')->to('shop.cart-link-icon');
    }

    public function decreaseProductQuantity (string $productId) {
        if ($this->cart_products[$productId] > 1) {
            $this->cart_products[$productId] -= 1;
            $this->shopping_cart->cart = json_encode($this->cart_products);
            $this->shopping_cart->save();
            // notify cart-link-icon
            $this->dispatch('cart-change')->to('shop.cart-link-icon');
        }
    }

    public function deleteFromCart (string $productId) {
        // remove product from shopping cart
        unset($this->cart_products[$productId]);
        $this->shopping_cart->cart = json_encode($this->cart_products);
        $this->shopping_cart->save();
        // remove product from products collection
        $this->products = $this->products->reject(fn (Product $prod) => $prod->id == $productId);
        // notify cart-link-icon
        $this->dispatch('cart-change')->to('shop.cart-link-icon');
    }
}; ?>

<section class="flex flex-col h-full">
    <div class="bg-white pl-35 pr-8 py-20 flex justify-between items-end">
        <h1 class="page-title">Twoje zakupy</h1>
        <a href="/shop" class="flex gap-6 items-end">
            <span>kontynuuj zakupy</span>
            <x-icon.sqr-arrow-up class="w-8 h-8"/>
        </a>
    </div>
    <div class="bg-light-grey p-12 grow-1 mb-16 flex justify-center items-center">
        @if (!empty($cart_products))
            <div class="bg-white rounded-sm p-16 shadow-[6px_6px_6px_#00000040]">
                <table>
                    <colgroup>
                        <col class="w-12 hidden md:table-column"/>
                        <col class="w-70"/>
                        <col class="w-36 hidden sm:table-column"/>
                        <col class="w-36 md:w-36"/>
                        <col class="w-22 md:w-26"/>
                        <col class="w-8"/>
                    </colgroup>
                    <thead>
                        <tr class="font-paragraph text-xs">
                            <th></th>
                            <th scope="col" class="text-left font-normal pb-6">produkt</th>
                            <th scope="col" class="text-center font-normal pb-6">cena</th>
                            <th scope="col" class="text-center font-normal pb-6">ilość</th>
                            <th scope="col" class="text-center font-normal pb-6">wartość</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-t border-coffee">
                                <td class="h-full">
                                    <div class="w-6 h-20 bg-red-brick"></div>
                                </td>
                                {{-- product --}}
                                <td>
                                    <div class="flex gap-4 py-4">
                                        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="książka" class="h-20 w-15 object-cover object-center">
                                        <div>
                                            <div class="font-technic text-sm font-light">{{ $product->type }}</div>
                                            <div class="font-title text-lg/6">{{ $product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- price --}}
                                <td class="font-paragraph text-xl text-center">
                                    {{ $product->price }} <span class="text-xs">zł</span>
                                </td>
                                {{-- quantity --}}
                                <td>
                                    <div class="flex gap-4 justify-center">
                                        {{-- minus button --}}
                                        <button wire:click="decreaseProductQuantity({{ $product->id }})">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 10L20 10" stroke="black"/>
                                            </svg>
                                        </button>
                                        <div class="font-paragraph text-xl/5 text-center min-w-[38px] py-2 px-1 border border-dark-grey rounded-sm">
                                            {{ $cart_products[$product->id] }}
                                        </div>
                                        {{-- plus button --}}
                                        <button  wire:click="increaseProductQuantity({{ $product->id }})">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 10H20M10 0V20" stroke="black"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                {{-- total --}}
                                <td class="font-paragraph text-xl text-center">
                                    {{ $product->price * $cart_products[$product->id] }} <span class="text-xs">zł</span>
                                </td>
                                <td class="text-right">
                                    <button wire:click="deleteFromCart({{ $product->id }})">
                                        <svg width="24" height="32" viewBox="0 0 24 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 6L3.9232 29.0799C3.9661 30.1526 4.84813 31 5.9216 31H18.0784C19.1519 31 20.0339 30.1526 20.0768 29.0799L21 6" stroke="black" stroke-linecap="round"/>
                                            <path d="M1 3H23" stroke="black" stroke-linecap="round"/>
                                            <path d="M9 3C9 1.89543 9.89543 1 11 1H13C14.1046 1 15 1.89543 15 3" stroke="black"/>
                                            <path d="M12 8V27" stroke="black" stroke-linecap="round"/>
                                            <path d="M16 27V8" stroke="black" stroke-linecap="round"/>
                                            <path d="M8 27C8 25.8 8 13.8333 8 8" stroke="black" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-coffee">
                            <th colspan="4" class="font-paragraph text-xl font-light pt-4 text-left">Razem</th>
                            <td class="font-paragraph text-2xl font-medium pt-4 text-center">
                                {{ $this->total }} <span class="font-normal text-base">zł</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="text-right mt-12">
                    <a href="/shop/order" class="btn-primary">Zamawiam</a>
                </div>
            </div>
        @else
            <h2>Brak produktów w koszyku. Sprawdź naszą <a href="/shop">ofertę</a>.</h2>
        @endif
    </div>
</section>