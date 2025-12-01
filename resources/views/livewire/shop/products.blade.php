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
    <h1 class="bg-white page-title px-35 py-20">Nasze produkty</h1>
    <ul class="bg-light-grey grid grid-cols-[repeat(auto-fill,_24rem)] gap-8 py-12 px-4 mb-16 justify-center">
        @foreach ($products as $product)
            <li wire:key="{{ $product->id }}" class="w-sm">
                <div class="py-6 px-4 bg-white rounded-sm flex flex-col gap-6 shadow-[6px_6px_6px_#00000040]">
                    <div class="flex gap-6 items-center">
                        <div class="min-w-16 h-16 bg-red-brick"></div>
                        <h2 class="heading-sm">{{ $product->name }}</h2>
                    </div>
                    <hr class="border-coffee">
                    <img src="{{'/storage/products_assets/' . $product->image }}" alt="książka" class="max-h-96 object-contain">
                    <div>
                        <h3 class="info-sm text-coffee">{{ $product->type }}</h3>
                        <p class="paragraph my-1 h-36">{{ $product->excerpt }}</p>
                        <a href="{{ '/shop/product/' . $product->id }}" class="flex gap-3 items-end justify-end">
                            <span class="text-sea-dark info-sm">zobacz szczegóły</span>
                            <x-icon.sqr-arrow-down class="h-6 w-6"/>
                        </a>
                    </div>
                    <div class="border-t border-coffee">
                        <div class="flex justify-between items-center mt-4">
                            <div class="paragraph">{{ $product->price }} <span>zł</span></div>  
                            <livewire:shop.add-to-cart-btn :product-id="$product->id"/>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>
