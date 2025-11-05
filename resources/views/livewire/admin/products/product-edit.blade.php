<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;
use App\Livewire\Forms\ProductForm;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Route;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    use WithFileUploads;

    public $pageTitle;

    public Product $product;
    public ProductForm $form;

    #[Validate('image|max:1024')]
    public $image;

    public function mount($id = null)
    {
        $routeName = Route::currentRouteName();
        if ($routeName === "admin.product-create") {
            $this->pageTitle = "Nowy Produkt";
        } elseif ($routeName === "admin.product-update") {
            $this->pageTitle = "Edytuj Produkt";
        }

        if ($id) {
            $this->product = Product::findOrFail($id);
        } else {
            $this->product = new Product();
        }

        $this->form->setProductForm($this->product);
    }

    public function save()
    {
        // Save without image upload
        if(!isset($this->image)) return $this->form->saveProduct($this->product);

        // Save with image upload
        if(!isset($this->product->id)) $this->form->saveProduct($this->product);
        // Set file name and store a new image
        $fileName = "product-id" . $this->product->id . "-" . $this->image->getClientOriginalName();
        $this->image->storeAs(path: 'products_assets', name: $fileName, options: 'public');
        // Remove previous image if exists
        if (isset($this->product->image)) {
            Storage::disk('public')->delete('products_assets/' . $this->product->image);
        }
        $this->form->setImageFileName($fileName);
        $this->form->saveProduct($this->product);
        $this->image = null;
    }
}; ?>

<section class="h-full">
    <div class="bg-light-grey">
        <div class="area">
            <h1 class="heading-base ml-6 sm:ml-24">{{ $pageTitle }}</h1>
            <hr class="my-8">
            <form class="grid grid-cols-2 gap-4" wire:submit="save">
                <div class="col-span-full flex flex-col gap-2">
                    <label for="product-name" class="label">Nazwa</label>
                    <input type="text" id="product-name" class="input-secondary" wire:model="form.name">
                    @error('form.name')
                        <div class="text-orange-800">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-span-full flex flex-col gap-2">
                    <label for="product-type" class="label">Typ</label>
                    <input type="text" id="product-type" class="input-secondary" wire:model="form.type">
                </div>
                {{-- Description --}}
                <div class="col-span-full flex flex-col gap-2">
                    <label for="product-description" class="label">Opis</label>
                    <textarea id="product-description" class="input-secondary" rows="6" wire:model="form.description"></textarea>
                </div>
                <div class="col-span-full flex flex-col gap-2">
                    <label for="product-excerpt" class="label">Skrócony opis</label>
                    <textarea id="product-excerpt" class="input-secondary" rows="3" wire:model="form.excerpt"></textarea>
                </div>
                {{-- Upload product image --}}
                <div class="row-span-3 flex flex-col gap-2">
                    <label for="upload_image" class="label">Dodaj zdjęcie produktu</label>
                    <div class="relative overflow-hidden border border-coffee rounded-md h-40 sm:h-50 w-40 sm:w-50">
                        <input type="file" id="upload_image" wire:model="image" class="invisible absolute w-full">
                        <label for="upload_image" class="flex cursor-pointer w-full h-full justify-center items-center">
                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="uploaded image file" class="w-full h-full object-cover">
                            @elseif ($product?->image)
                                <img src="{{ '/storage/products_assets/' . $product->image }}" alt="product image preview" class="w-full h-full object-cover">
                            @else
                                <x-icon.add-image/>
                            @endif
                        </label>
                    </div>
                </div>
                {{-- Price --}}
                <div class="h-18 flex flex-col gap-2">
                    <label for="product-price" class="label">Cena</label>
                    <input type="text" id="product-price" class="input-secondary" wire:model="form.price" pattern="[0-9]+\.[0-9]{2}" placeholder="00.00">
                </div>
                {{-- Product avilability --}}
                <div class="h-6 flex items-center gap-3">
                    <input type="checkbox" id="product-available" wire:model="form.available">
                    <label for="product-available" class="label">
                        Produkt dostępny w sprzedaży
                    </label>
                </div>
                {{-- Submit button --}}
                <div class="h-9 mt-17">
                    <button type="submit" class="block ml-auto btn-primary">Zapisz</button>
                </div>
            </form>
        </div>
    </div>
</section>
