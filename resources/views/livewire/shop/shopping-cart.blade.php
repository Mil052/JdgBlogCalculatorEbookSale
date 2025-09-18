<?php

use Livewire\Volt\Component;

new class extends Component {
    public $cartId;
    public $cart;

    public function mount ()
    {
        $this->cartId = request()->cookie('cartId');
    }
}; ?>

<div>
    <h1>Shopping Cart</h1>
</div>
