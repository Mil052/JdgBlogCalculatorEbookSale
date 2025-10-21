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
    public function yearlyRevenueLessExpenses ()
    {
        return ($this->monthlyRevenue - $this->monthlyExpense) * 12;
    }

    #[Computed]
    public function taxes()
    {
        $taxes = calculateTaxes(
            monthlyRevenue: $this->monthlyRevenue,
            monthlyExpense: $this->monthlyExpense,
            zus: $this->zus,
            lumpSumRate: $this->lumpSumRate,
        );

        return $taxes;
    }

}; ?>

<div>
    <div>
        <form wire:submit.prevent="$refresh">
            <div>
                <label for="monthly-revenue" class="label">Miesięczne przychody</label>
                <input type="text" id="monthly-revenue" name="monthly-revenue" class="input-secondary" wire:model="monthlyRevenue">
            </div>
            <div>
                <label for="monthlyExpense" class="label">Miesięczne koszty</label>
                <input type="text" id="monthly-expense" name="monthly-expense" class="input-secondary" wire:model="monthlyExpense">
            </div>
            <div>
                <label class="label">ZUS</label>
                <div class="flex gap-4">
                    <div>
                        <input type="radio" id="zus-start-relief" name="zus" value="start-relief" wire:model="zus">
                        <label for="zus-start-relief">Ulga na start</label>
                    </div>
                    <div>
                        <input type="radio" id="zus-reduced" name="zus" value="reduced" wire:model="zus">
                        <label for="zus-reduced">ZUS obniżony</label>
                    </div>
                    <div>
                        <input type="radio" id="zus-full" name="zus" value="full" wire:model="zus">
                        <label for="zus-full">Pełny ZUS</label>
                    </div>
                </div>
            </div>
            <div>
                <livewire:home.lump-sum-select wire:model="lumpSumRate"/>
            </div>
            <button type="submit">Oblicz</button>
        </form>
    </div>
    <div>
        <div>
            <x-taxation-summary
                :yearlyRevenueLessExpenses="$this->yearlyRevenueLessExpenses"
                taxation="Skala podatkowa" 
                :zus="$this->taxes['scale']['zus']"
                :healthInsurance="$this->taxes['scale']['healthInsurance']"
                :tax="$this->taxes['scale']['tax']"
                :income="$this->taxes['scale']['income']"
            />
        </div>
        <div>
            <x-taxation-summary
                :yearlyRevenueLessExpenses="$this->yearlyRevenueLessExpenses"
                taxation="Podatek liniowy"
                :zus="$this->taxes['flat']['zus']"
                :healthInsurance="$this->taxes['flat']['healthInsurance']"
                :tax="$this->taxes['flat']['tax']"
                :income="$this->taxes['flat']['income']"
            />
        </div>
        <div>
            <x-taxation-summary
                :yearlyRevenueLessExpenses="$this->yearlyRevenueLessExpenses"
                taxation="Podatek liniowy"
                :zus="$this->taxes['lump-sum']['zus']"
                :healthInsurance="$this->taxes['lump-sum']['healthInsurance']"
                :tax="$this->taxes['lump-sum']['tax']"
                :income="$this->taxes['lump-sum']['income']"
            />
        </div>
    </div>
</div>