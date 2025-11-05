<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    #[Computed]
    public function products()
    {
        return Product::all();
    }

    public function deleteProduct(Product $product)
    {
        // Remove product image if exists
        if (isset($product->image)) {
            Storage::disk('public')->delete('products_assets/' . $product->image);
        }
        $product->delete();
    }
}; ?>

<section class="area">
    <div class="flex justify-between items-center">
        <h1 class="heading-base">SKLEP - LISTA PRODUKTÓW</h1>
        <a href="/admin/products/product/create" wire:navigate class="flex gap-3">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1V23" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M1 12H23" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
            </svg>            
            <span>Nowy Produkt</span>
        </a>
    </div>
    <hr class="my-8">
    <ul>
        @foreach ($this->products as $product)
            <li wire:key="{{ $product->id }}" class="group flex my-8 gap-12 justify-between items-center">
                <div class="flex gap-6">
                    <div class="min-w-7">
                        <div class="w-3 h-full group-hover:w-7 transition-[width] duration-300 bg-coffee"></div>
                    </div>
                    <div class="h-15">
                        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="product preview" class="h-full">
                    </div>
                    <div class="flex flex-col justify-between">
                        <a href="{{ '/admin/products/' . $product->id }}">
                            <h3 class="inline font-paragraph text-lg font-normal mr-2">
                                {{ $product->name }}
                            </h3>
                        </a>
                        <div class="text-sm">
                            <span>typ produktu:&nbsp;{{ $product->type }}</span>
                            <span class="mx-3">|</span>
                            <span class="text-sm">produkt&nbsp;id:&nbsp;{{ $product->id }}</span>
                        </div>
                    </div>
                </div>
                <div class="ml-auto flex gap-6">
                    <a href="/admin/products/product/{{ $product->id }}/edit">
                        <x-icon.pen />
                    </a>
                    <x-confirm-delete-btn :title="$product->name" type="produkt" :id="$product->id" @delete="$wire.deleteProduct({{ $product->id }})"/>
                </div>
            </li>
        @endforeach
    </ul>
</section>

