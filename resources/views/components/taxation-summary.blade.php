@props(['id', 'yearlyRevenue', 'yearlyExpenses', 'taxation', 'zus', 'healthInsurance', 'tax', 'income'])

<div class="@container text-white font-paragraph">
    <h4 class="flex justify-between text-lg @xs:text-xl @md:text-2xl">
        <span>{{ $taxation }}</span>
        <span class="font-semibold">{{ $income }} PLN</span>
    </h4>
    <div class="my-4 md:my-6">
        <x-home.income-diagram
            :id=" $id . 'Diagram'"
            :total="100"
            :checked="(int) ($income / ($yearlyRevenue - $yearlyExpenses) * 100)"
        />
    </div>
    <dl class="grid @xl:grid-cols-2 gap-x-12 @xl:gap-y-1 font-light text-sm sm:text-base">
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