<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Modelable;

new class extends Component {
    #[Modelable]
    public $lumpSumRate;

    private $lumpSumRates=[17, 15, 14, 12, 10, 8.5, 5.5, 3, 2];
}; ?>

<div x-data="{open: false}">
    <label class="label">
        <span>Ryczałt - stawka {{ $lumpSumRate }}(%)</span>
        <button type="button" @click="open = !open">
            <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L10 9L19 1" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </label>
    <div x-show="open">
        @foreach($this->lumpSumRates as $rate)
            <div wire:key="{{ $loop->index }}" @click="open = false">
                <input type="radio" id="lump-rate-{{ $rate }}" name="lump-sum-rate" value="{{ $rate }}" wire:model="lumpSumRate">
                <label for="lump-rate-{{ $rate }}">17%</label>
            </div>
        @endforeach
    </div>
</div>
