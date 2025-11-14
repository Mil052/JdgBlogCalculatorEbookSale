<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;

new class extends Component {
    #[Modelable]
    public $orderStatus;

    public $statusTypes;

    public function mount($statusTypes)
    {
        $this->statusTypes = $statusTypes;
    }
}; ?>

<form class="relative bg-white flex justify-between min-w-3xs px-4 py-1" x-data="{open: false}">
    <h3>{{ $statusTypes[$orderStatus] }}</h3>
    <button type="button" @click="open = !open">
        <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{ 'rotate-180': open }">
            <path d="M1 1L10 9L19 1" stroke="#785f5f" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
        </svg>
    </button>
    <div class="bg-white absolute w-full p-4 border-t top-8 left-0" x-cloak x-show="open">
        <div class="my-2">
            <input type="radio" id="status-awaiting" value="awaiting" wire:model="orderStatus" class="invisible">
            <label for="status-awaiting" class="cursor-pointer" @click="open = false">
                {{ $statusTypes['awaiting'] }}
            </label>
        </div>
        <div class="my-2">
            <input type="radio" id="status-accepted" value="accepted" wire:model="orderStatus" class="invisible">
            <label for="status-accepted" class="cursor-pointer" @click="open = false">
                {{ $statusTypes['accepted'] }}
            </label>
        </div>
        <div class="my-2">
            <input type="radio" id="status-completed" value="completed" wire:model="orderStatus" class="invisible">
            <label for="status-completed" class="cursor-pointer" @click="open = false">
                {{ $statusTypes['completed'] }}
            </label>
        </div>
        <hr class="my-4">
        <div class="my-2">
            <input type="radio" id="status-all" value="all" wire:model="orderStatus" class="invisible">
            <label for="status-all" class="cursor-pointer" @click="open = false">
                {{ $statusTypes['all'] }}
            </label>
        </div>
    </div>
</form>
