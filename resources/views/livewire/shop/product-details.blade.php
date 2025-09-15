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
    <div class="max-w-40">
        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="{{ $product->name }}">
    </div>
    <div>
        <div>
            <h2>{{ $product->name }}</h2>
            <h3>{{ $product->type }}</h3>
        </div>
        <p>{{ $product->description }}</p>
        <div class="flex justify-between">
            <div>{{ $product->price }}</div>
            <button type="button">dodaj do koszyka</button>
        </div>
    </div>
    <p>sprawdź pozostałe produkty w naszej <a href="/shop">ofercie</a></p>
</section>
