<?php

use Livewire\Volt\Component;

new class extends Component {
    // http://localhost:8000/shop/order/completed?id=3&error=501
    public function mount()
    {
 
    }
    
}; ?>

<section class="bg-light-grey px-4 sm:px-8 py-12 min-h-full flex flex-col justify-center items-center font-paragraph ">
    <h3 class="text-lg my-4 font-semibold">
        Hura! Zamówienie zostało przyjęte do realizacji.
    </h3>
    <p>
        Status zamówienia możesz sprawdzić w
        <a href="/user/dashboard" class="text-sea-dark">
            panelu użytownika
        </a>
        .
    </p>
</section>
