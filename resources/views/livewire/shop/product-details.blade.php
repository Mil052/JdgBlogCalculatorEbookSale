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
    <div class="bg-white pl-35 pr-8 py-20 flex justify-between items-end">
        <h1 class="page-title">Nasze książki</h1>
        <a href="/shop" class="flex gap-6 items-end text-sea-dark">
            <span>zobacz wszystkie</span>
            <x-icon.sqr-arrow-up class="w-8 h-8"/>
        </a>
    </div>
    <div class="bg-light-grey px-8 py-12 mb-16">
        <div class="bg-white px-8 py-16 rounded-sm shadow-[6px_6px_6px_#00000040]">
            <div class="flex gap-12">
                <div>
                    <div class="flex gap-6 items-center mb-8">
                        <div class="min-w-16 h-16 bg-red-brick"></div>
                        <h2 class="heading-base">{{ $product->name }}</h2>
                    </div>
                    <p>{{ $product->description }}</p>
                </div>
                <img src="{{ '/storage/products_assets/' . $product->image }}" alt="{{ $product->name }}" class="max-h-100">
            </div>
            <div class="pb-2 border-b border-coffee my-4">
                <h3 class="info-sm text-coffee">{{ $product->type }}</h3>
            </div>
            <div class="flex justify-between items-center">
                <div class="paragraph-base">{{ $product->price }} <span>zł</span></div>
                <livewire:shop.add-to-cart-btn :product-id="$product->id"/>
            </div>
        </div>
    </div>
</section>
