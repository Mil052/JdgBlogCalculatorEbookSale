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

<section class="h-full">
    <div class="bg-white px-8 xs:px-16 lg:px-32 py-20 flex justify-between items-end">
        <h1 class="page-title">Twoje zakupy</h1>
        <a href="/shop" class="flex gap-4 items-end text-sea-dark sm:mb-1">
            <span class="hidden sm:inline">kontynuuj zakupy</span>
            <x-icon.sqr-arrow-up class="w-7 h-7 mb-1"/>
        </a>
    </div>
    <div class="bg-light-grey px-3 xs:px-6 py-12 sm:p-12 grow-1 mb-16 flex justify-center items-center">
        @if (!empty($cart_products))
            <div class="bg-white rounded-sm px-3 xs:px-4 sm:px-8 lg:px-16 py-16 shadow-[6px_6px_6px_#00000040]">
                <table>
                    <thead>
                        <tr class="font-paragraph text-xs border-b border-coffee">
                            <th scope="col" class="w-70 lg:w-78 hidden md:table-cell text-left font-normal pb-6">produkt</th>
                            <th scope="col" class="w-26 text-center font-normal pb-6">cena</th>
                            <th scope="col" class="w-36 text-center font-normal pb-6">ilość</th>
                            <th scope="col" class="w-26 text-center font-normal pb-6">wartość</th>
                            <th class="w-8"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            {{-- Small screen product info --}}
                            <tr class="md:hidden">
                                <td colspan="4" class="pt-4">
                                    <div class="flex gap-4">
                                        <div class="min-w-6 h-20 bg-red-brick"></div>
                                        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="książka" class="h-20 min-w-15 object-cover object-center">
                                        <div>
                                            <div class="font-technic text-sm font-light">{{ $product->type }}</div>
                                            <div class="font-title text-lg/6">{{ $product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-coffee">
                                {{-- product --}}
                                <td class="hidden md:table-cell">
                                    <div class="flex gap-4 py-4">
                                        <div class="hidden lg:block min-w-6 h-20 bg-red-brick"></div>
                                        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="książka" class="h-20 min-w-15 object-cover object-center">
                                        <div>
                                            <div class="font-technic text-sm font-light">{{ $product->type }}</div>
                                            <div class="font-title text-lg/6">{{ $product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                {{-- price --}}
                                <td class="font-paragraph text-base sm:text-xl text-center py-4">
                                    {{ $product->price }} <span class="text-xs">zł</span>
                                </td>
                                {{-- quantity --}}
                                <td>
                                    <div class="flex gap-3 xs:gap-4 justify-center py-4">
                                        {{-- minus button --}}
                                        <button wire:click="decreaseProductQuantity({{ $product->id }})">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 10L20 10" stroke="black"/>
                                            </svg>
                                        </button>
                                        <div class="font-paragraph text-base/5 sm:text-xl/5 text-center min-w-[30px] sm:min-w-[38px] py-1 sm:py-2 px-1 border border-dark-grey rounded-sm">
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
                                <td class="font-paragraph text-base sm:text-xl text-center py-4">
                                    {{ $product->price * $cart_products[$product->id] }} <span class="text-xs">zł</span>
                                </td>
                                <td class="text-right">
                                    <button wire:click="deleteFromCart({{ $product->id }})" class="h-6 sm:h-8">
                                        <svg width="24" height="auto" viewBox="0 0 24 32" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <th colspan="2" class="font-paragraph text-xl font-light pt-4 text-left">Razem</th>
                            <td class="hidden md:table-cell"></td>
                            <td colspan="2" class="font-paragraph text-2xl font-medium pt-4 text-center">
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