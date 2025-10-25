@props(['id', 'yearlyRevenue', 'yearlyExpenses', 'taxation', 'zus', 'healthInsurance', 'tax', 'income'])

<div class="text-white font-paragraph">
    <h4 class="flex justify-between text-2xl my-6">
        <span>{{ $taxation }}</span>
        <span class="font-semibold">{{ $income }} PLN</span>
    </h4>
    <div>
        <x-home.income-diagram
            :id=" $id . 'Diagram'"
            :total="100"
            :checked="(int) ($income / ($yearlyRevenue - $yearlyExpenses) * 100)"
        />
    </div>
    <dl class="grid grid-cols-2 gap-x-12 gap-y-1 my-6 font-light">
        <div class="flex gap-8 justify-between">
            <dt>Przychody</dt>
            <dd>{{ $yearlyRevenue }} PLN</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Koszty</dt>
            <dd>{{ $yearlyExpenses }} PLN</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Dochód</dt>
            <dd>{{ $income }} PLN</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Podatek</dt>
            <dd>{{ $tax }} PLN</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Składka ZUS</dt>
            <dd>{{ $zus }} PLN</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Składka zdrowotna</dt>
            <dd>{{ $healthInsurance }} PLN</dd>
        </div>
    </dl>
</div>