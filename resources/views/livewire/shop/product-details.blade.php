<?php
use Livewire\Attributes\{Layout};
use Livewire\Volt\Component;
use App\Models\Product;
use Illuminate\View\View;
new
#[Layout('components.layouts.app')]
class extends Component {
    public $product;

    public function mount(Product $product) {
        $this->product = $product;
    }

    public function rendering(View $view) {
        $view->title($this->product->type . ' ' .$this->product->name);
    }
}; ?>

<section>
    <div class="bg-white px-8 xs:px-16 lg:px-32 py-20 flex justify-between items-end">
        <h1 class="page-title">Nasze produkty</h1>
        <a href="/shop" class="flex gap-4 items-end text-sea-dark sm:mb-1">
            <span class="hidden sm:inline">zobacz wszystkie</span>
            <x-icon.sqr-arrow-up class="w-7 h-7 mb-1"/>
        </a>
    </div>
    <div class="bg-light-grey px-4 sm:px-8 py-12 mb-16">
        <div class="bg-white px-4 sm:px-8 py-16 rounded-sm shadow-[6px_6px_6px_#00000040]">
            <div class="grid md:grid-cols-[1fr_16rem] grid-rows-[auto_1fr] gap-8 lg:gap-12">
                <div class="col-span-full lg:col-span-1 flex gap-6 items-center">
                    <div class="min-w-16 h-16 bg-red-brick"></div>
                    <h2 class="heading-base">{{ $product->name }}</h2>
                </div>
                <p class="row-start-2 col-start-1 grow font-paragraph text-sm sm:text-base lg:text-lg">{{ $product->description }}</p>
                <img src="{{ '/storage/products_assets/' . $product->image }}" alt="{{ $product->name }}" class="md:col-[2_/_3] lg:row-[1_/_3] justify-self-center w-3xs max-h-100">
            </div>
            <div class="pb-2 border-b border-coffee my-4">
                <h3 class="info-sm text-coffee">{{ $product->type }}</h3>
            </div>
            <div class="flex justify-between items-center">
                <div class="paragraph">{{ $product->price }} <span>zł</span></div>
                <livewire:shop.add-to-cart-btn :product-id="$product->id"/>
            </div>
        </div>
    </div>
</section>
