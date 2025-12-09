<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {

    public $products;
    public $totalProducts;
    public $sliderIds = [];

    public function mount() 
    {
        $this->products = Product::limit(9)->get();
        if ( $this->products->isNotEmpty()) {
            $this->totalProducts = $this->products->count();
            $this->products = $this->products->toArray();
            $this->sliderIds = [
                0,
                1 % $this->totalProducts,
                2 % $this->totalProducts,
                3 % $this->totalProducts,
                4 % $this->totalProducts,
            ];
        }
    }
}; ?>

<div
    x-data="{
        currentIndex: 1,
        total: {{ $totalProducts }},
        animation: null,
        sliderIds: {{ json_encode($sliderIds) }}
    }"
    x-init="

        animation = $refs.list.getAnimations()[0];
        setInterval(() => {
            currentIndex = (currentIndex + 1) % total;
            {{-- remove first item in array --}}
            sliderIds.shift();
            {{-- add new item to the end of array --}}
            sliderIds[4] = (currentIndex + 3) % total;
            animation.play();
        }, 6000);
    "
    class="overflow-x-hidden"
>
    <ul x-ref="list" class="flex flex-nowrap animate-slide-left">
        <template x-for="(id, index) in sliderIds">
            <li class="w-xs shrink-0">
                <div class="m-2 p-6 rounded-sm bg-white shadow-md">
                    <img :src="'/storage/products_assets/' + $wire.products[id]['image']" alt="products image">
                    <div class="my-2 flex justify-between font-technic text-sm">
                        <span x-text="$wire.products[id]['type']" class="text-coffee"></span>
                        <span x-text="$wire.products[id]['price'] + 'zł'" class="text-red-brick font-semibold"></span>
                    </div>
                    <div class="h-27 my-2">
                        <div class="flex gap-4 mb-2">
                            <div class="min-w-5 min-h-5 bg-red-brick"></div>
                            <h3 x-text="$wire.products[id]['name']" class="text-lg/5 font-title"></h3>
                        </div>
                        <p x-text="$wire.products[id]['excerpt'].substring(0, 90) + '...'" class="text-sm font-paragraph"></p>
                    </div>
                    <a :href="'/shop/product/' + $wire.products[id]['id']" class="block w-fit ml-auto text-sm/5 font-technic text-sea-dark">
                        strona produktu
                        <span class="text-xl/5">&#8594;</span>
                    </a>
                </div>
            </li>
        </template>
    </ul>
</div>
