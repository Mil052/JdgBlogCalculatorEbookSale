<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;

new class extends Component {
    #[Modelable]
    public $lumpSumRate;

    private $lumpSumRates=[17, 15, 14, 12, 10, 8.5, 5.5, 3, 2];
}; ?>

<div x-data="{open: false}" class="relative">
    <label class="text-lg">
            <span class="mr-1">Stawka</span>
            <span x-text="$wire.lumpSumRate"></span>
            <span>(%)</span>
            <button type="button" @click="open = !open" class="ml-2" :class="open && 'rotate-180'">
                <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L10 9L19 1" stroke="#785f5f" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                </svg>
            </button>
    </label>
    <div x-cloak x-show="open" class="absolute z-20 bg-light-grey p-4 w-full top-12 rounded-sm">
        @foreach($this->lumpSumRates as $rate)
            <div wire:key="{{ $loop->index }}" @click="open = false" class="my-1">
                <input type="radio" id="lump-rate-{{ $rate }}" value="{{ $rate }}" wire:model="lumpSumRate">
                <label for="lump-rate-{{ $rate }}" class="ml-2">{{ $rate }} %</label>
            </div>
        @endforeach
    </div>
</div>
