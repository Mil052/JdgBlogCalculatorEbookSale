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
    <h1>Shop</h1>
    <ul class="grid grid-cols-3 gap-4">
        @foreach ($products as $product)
            <li wire:key="{{ $product->id }}">
                <div>
                    <img src="{{'/storage/products_assets/' . $product->image }}" alt="książka" class="max-w-40">
                    <div>
                        <h2>{{ $product->name }}</h2>
                        <h3>{{ $product->type }}</h3>
                        <p>{{ $product->excerpt }}</p>
                        <a href="{{ '/shop/product/' . $product->id }}">zobacz szczegóły</a>
                        <button type="button">Dodaj do koszyka</button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>
