<?php

use Livewire\Volt\Component;

new class extends Component {
    public $cartId;

    public function mount ()
    {
        $this->cartId = request()->cookie('discountToken');
    }
}; ?>

<div>
    <h1>Shopping Cart</h1>
</div>
