<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;

new
#[Layout('components.layouts.app')]
#[Title('JDG Sklep - lista produktów')]
class extends Component {
    public $products;

    public function mount ()
    {
        $this->products = Product::all();
    }
}; ?>

<section>
    <h1 class="bg-white page-title px-8 xs:px-16 lg:px-32 py-20">Nasze produkty</h1>
    <ul class="bg-light-grey grid grid-cols-[repeat(auto-fill,_20rem)] lg:grid-cols-[repeat(auto-fill,_24rem)] gap-8 py-12 px-4 mb-16 justify-center">
        @foreach ($products as $product)
            <li wire:key="{{ $product->id }}" class="w-full">
                <div class="py-6 px-4 bg-white rounded-sm flex flex-col gap-6 shadow-[6px_6px_6px_#00000040]">
                    <div class="flex gap-4 lg:gap-6 items-center">
                        <div class="min-w-12 h-12 bg-red-brick"></div>
                        <h2 class="font-title text-xl/6">{{ $product->name }}</h2>
                    </div>
                    <hr class="border-coffee">
                    <img src="{{'/storage/products_assets/' . $product->image }}" alt="książka" class="max-h-80 object-contain">
                    <div>
                        <p class="font-paragraph text-sm h-30">
                            {{ $product->excerpt }}
                        </p>
                        <div class="flex justify-between font-technic text-sm/4 mt-2">
                            <h3 class="text-coffee">{{ $product->type }}</h3>
                            <a href="{{ '/shop/product/' . $product->id }}" class="text-sea-dark">
                                <span>zobacz szczegóły</span>
                                <span class="text-base/4">&#8594;</span>
                            </a>
                        </div>
                    </div>
                    <div class="border-t border-coffee">
                        <div class="flex justify-between items-center mt-4">
                            <div class="paragraph">
                                {{ $product->price }} <span>zł</span>
                            </div>  
                            <livewire:shop.add-to-cart-btn :product-id="$product->id"/>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>
