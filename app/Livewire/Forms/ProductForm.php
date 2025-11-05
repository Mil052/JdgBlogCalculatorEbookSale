<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Form
{
    #[Validate('required|min:6')]
    public ?string $name = null;
    public ?string $type = null;
    public ?string $description = null;
    public ?string $excerpt = null;
    public ?string $image = null;
    public ?float $price = null;
    public bool $available = false;

    public function setProductForm(Product $product)
    {
        if (isset($product->name)) $this->name = $product->name;
        if (isset($product->type)) $this->type = $product->type;
        if (isset($product->description)) $this->description = $product->description;
        if (isset($product->excerpt)) $this->excerpt = $product->excerpt;
        if (isset($product->image)) $this->image = $product->image;
        if (isset($product->price)) $this->price = $product->price;
        if (isset($product->available)) $this->available = $product->available;
    }

    public function saveProduct(Product $product)
    {
        $this->validate();

        $product->name = $this->name;
        $product->type = $this->type;
        $product->description = $this->description;
        $product->excerpt = $this->excerpt;
        $product->image = $this->image;
        $product->price = $this->price;
        $product->available = $this->available;
 
        $product->save();
    }

    public function setImageFileName(string $FileName)
    {
        $this->image = $FileName;
    }
}