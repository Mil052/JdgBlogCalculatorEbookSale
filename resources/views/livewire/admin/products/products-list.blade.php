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
            <span class="hidden xs:inline">Nowy Produkt</span>
        </a>
    </div>
    <hr class="my-8">
    <ul>
        @foreach ($this->products as $product)
            <li wire:key="{{ $product->id }}" class="group flex flex-col sm:flex-row my-4 sm:my-8 gap-3 sm:gap-16" x-data="{showDetails: false}">
                <div class="grow flex gap-3 xs:gap-4 sm:gap-6">
                    <div class="sm:min-w-7">
                        <div class="w-3 h-full sm:group-hover:w-7 transition-[width] duration-300 bg-coffee"></div>
                    </div>
                    <div class="h-15 min-w-10">
                        <img src="{{ '/storage/products_assets/' . $product->image }}" alt="product preview" class="h-full">
                    </div>
                    <div class="grow flex flex-col justify-between">
                        <h3 class="font-paragraph text-base/5 md:text-lg/6 font-normal">
                            {{ $product->name }}
                        </h3>
                        {{-- Product description --}}
                        <dl x-cloak x-show="showDetails" class="text-sm">
                            <div class="my-2">
                                <dt class="text-coffee">skrócony opis</dt>
                                <dd class="ml-3">
                                    {{ !empty($product->excerpt) ? $product->excerpt : '-'  }}
                                </dd>
                            </div>
                            <div class="my-2">
                                <dt class="text-coffee">opis</dt>
                                <dd class="ml-3">
                                    {{ !empty($product->description) ? $product->description : '-' }}
                                </dd>
                            </div>
                        </dl>
                        <div class="flex gap-2 text-sm">
                            <a href="{{ '/shop/product/' . $product->id }}" class="text-sea-dark flex">
                                <span class="hidden lg:inline">strona produktu</span>
                                <span class=" inline lg:hidden">
                                    <x-icon.go-to-page />
                                </span>
                            </a>
                            <span>|</span>
                            <dl class="flex">
                                <dt><span class="hidden lg:inline">produkt </span>id:</dt>
                                <dd class="ml-1">{{ $product->id }}</dd>
                            </dl>
                            <span>|</span>
                            <dl class="flex">
                                <dt class="hidden xs:block">typ:</dt>
                                <dd class="ml-1">{{ $product->type }}</dd>
                            </dl>
                            <span>|</span>
                            <dl class="flex">
                                <dt class="hidden xs:block">cena:</dt>
                                <dd class="ml-1">{{ $product->price }} zł</dd>
                            </dl>
                            <span>|</span>
                            <button type="button" x-on:click="showDetails = !showDetails">
                                <div class="hidden md:flex gap-2 items-center text-sea-dark">
                                    <span x-text="showDetails ? 'ukryj szczegóły' : 'pokaż szczegóły'"></span>
                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg" :class="showDetails && 'rotate-180'">
                                        <path d="M1 2L3.5 4L6 6L11 2" stroke="#4F7982" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="md:hidden" :class="showDetails && 'rotate-180'">
                                    <rect x="1" y="3" width="18" height="4" stroke="#4F7982" stroke-linejoin="round"/>
                                    <path d="M1 11L10 17L19 11" stroke="#4F7982" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Edit and Delete Product buttons --}}
                <div class="sm:h-15 flex gap-6 items-center justify-end py-2 border-t sm:border-none">
                    <a href="/admin/products/product/{{ $product->id }}/edit">
                        <x-icon.pen />
                    </a>
                    <x-confirm-delete-btn :title="$product->name" type="produkt" :id="$product->id" @delete="$wire.deleteProduct({{ $product->id }})"/>
                </div>
            </li>
        @endforeach
    </ul>
</section>