<?php

use Livewire\Volt\Component;

new class extends Component {
    public $productId;

    public function mount ($productId)
    {
        $this->productId = $productId;
    }

    public function addToCart ()
    {
        
    }
}; ?>

<button type="button">
    dodaj do koszyka
</button>
