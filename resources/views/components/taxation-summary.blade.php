@props(['yearlyRevenueLessExpenses', 'taxation', 'zus', 'healthInsurance', 'tax', 'income'])

<div>
    <h2>
        Forma opodatkowania: <span>{{ $taxation }}</span>
    </h2>
    <div>
        <x-home.income-diagram
            :total="100"
            :checked="(int) ($income / $yearlyRevenueLessExpenses * 100)"
        />
    </div>
    <dl class="grid grid-cols-2 gap-x-8 gap-y-2">
        <div class="flex gap-8 justify-between">
            <dt>Dochód</dt>
            <dd>{{ $income }}</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Podatek</dt>
            <dd>{{ $tax }}</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Składka ZUS</dt>
            <dd>{{ $zus }}</dd>
        </div>
        <div class="flex gap-8 justify-between">
            <dt>Składka zdrowotna</dt>
            <dd>{{ $healthInsurance }}</dd>
        </div>
    </dl>
</div>