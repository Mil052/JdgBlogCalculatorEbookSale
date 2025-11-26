<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate; 

new class extends Component {

    public $monthlyRevenue = 1000;
    public $monthlyExpense = 0;
    #[Validate('in:start-relief,reduced,full')]
    public $zus = 'start-relief';
    // https://www.biznes.gov.pl/pl/portal/00263#7
    public $lumpSumRate = 17; // in percent

    #[Computed]
    public function yearlyRevenue()
    {
        return $this->monthlyRevenue * 12;
    }

    #[Computed]
    public function yearlyExpenses()
    {
        return $this->monthlyExpense * 12;
    }

    #[Computed]
    public function taxes()
    {
        return calculateTaxes(
            monthlyRevenue: $this->monthlyRevenue,
            monthlyExpense: $this->monthlyExpense,
            zus: $this->zus,
            lumpSumRate: $this->lumpSumRate,
        );
    }
}; ?>

<div class="grid md:grid-cols-[2fr_3fr] gap-12 md:gap-4 lg:gap-12">
    <div>
        <div class="text-coffee text-center my-8 md:my-16">
            <h2 class="heading-base">Kalkulator zarobków</h2>
            <h3 class="heading-sm">w zależności od formy opodatkowania</h3>
        </div>
        <form x-on:submit.prevent="$wire.$refresh(); $dispatch('updatediagram')" class="@container font-technic">
            <div class="flex flex-col my-3 sm:my-6">
                <label for="monthly-revenue" class="text-coffee text-lg xs:text-xl sm:text-2xl pb-2 sm:pb-4 border-b-2">Miesięczne przychody</label>
                <input type="text" id="monthly-revenue" name="monthly-revenue" class="bg-light-grey px-4 py-2 text-coffee xs:text-xl my-3 sm:my-6 rounded-sm" wire:model="monthlyRevenue">
            </div>
            <div class="flex flex-col my-3 sm:my-6">
                <label for="monthly-expense" class="text-coffee text-lg xs:text-xl sm:text-2xl pb-2 sm:pb-4 border-b-2">Miesięczne koszty</label>
                <input type="text" id="monthly-expense" name="monthly-expense" class="bg-light-grey px-4 py-2 text-coffee xs:text-xl my-3 sm:my-6 rounded-sm" wire:model="monthlyExpense">
            </div>
            <div class="my-3 sm:my-6">
                <label class="block text-coffee text-lg xs:text-xl sm:text-2xl pb-2 sm:pb-4 border-b-2">ZUS</label>
                <div class="text-coffee xs:text-lg flex flex-col @md:flex-row gap-x-4 gap-y-2 justify-between my-3 sm:my-6">
                    <div>
                        <input type="radio" id="zus-start-relief" name="zus" value="start-relief" wire:model="zus">
                        <label for="zus-start-relief" class="ml-2">Ulga na start</label>
                    </div>
                    <div>
                        <input type="radio" id="zus-reduced" name="zus" value="reduced" wire:model="zus">
                        <label for="zus-reduced" class="ml-2">ZUS obniżony</label>
                    </div>
                    <div>
                        <input type="radio" id="zus-full" name="zus" value="full" wire:model="zus">
                        <label for="zus-full" class="ml-2">Pełny ZUS</label>
                    </div>
                </div>
            </div>
            <div class="my-8 sm:my-12 flex justify-between items-end text-coffee pb-2 sm:pb-4 border-b-2">
                <label class="text-lg xs:text-xl sm:text-2xl">Ryczałt</label>
                <livewire:tax-calculator.lump-sum-select wire:model="lumpSumRate"/>
            </div>
            <button type="submit" class="btn-primary">OBLICZ DOCHÓD</button>
        </form>
    </div>
    <div class="bg-coffee rounded-sm">
        <div class="m-6 md:m-8">
            <x-taxation-summary
                id="scale"
                :yearlyRevenue="$this->yearlyRevenue"
                :yearlyExpenses="$this->yearlyExpenses"
                taxation="Skala podatkowa" 
                :zus="$this->taxes['scale']['zus']"
                :healthInsurance="$this->taxes['scale']['healthInsurance']"
                :tax="$this->taxes['scale']['tax']"
                :income="$this->taxes['scale']['income']"
            />
        </div>
        <hr class="mx-12">
        <div class="m-6 md:m-8">
            <x-taxation-summary
                id="flat"
                :yearlyRevenue="$this->yearlyRevenue"
                :yearlyExpenses="$this->yearlyExpenses"
                taxation="Podatek liniowy"
                :zus="$this->taxes['flat']['zus']"
                :healthInsurance="$this->taxes['flat']['healthInsurance']"
                :tax="$this->taxes['flat']['tax']"
                :income="$this->taxes['flat']['income']"
            />
        </div>
        <hr class="mx-12">
        <div class="m-6 md:m-8">
            <x-taxation-summary
                id="lumpSum"
                :yearlyRevenue="$this->yearlyRevenue"
                :yearlyExpenses="$this->yearlyExpenses"
                taxation="Ryczałt"
                :zus="$this->taxes['lump-sum']['zus']"
                :healthInsurance="$this->taxes['lump-sum']['healthInsurance']"
                :tax="$this->taxes['lump-sum']['tax']"
                :income="$this->taxes['lump-sum']['income']"
            />
        </div>
    </div>
</div>