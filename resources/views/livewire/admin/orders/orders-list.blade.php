<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\{Layout, Title};
use App\Models\Order;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    public $orderStatus = 'all';

    public $statusTypes = [
        'awaiting' => 'oczekujące',
        'accepted' => 'zaakceptowane',
        'completed' => 'zrealizowane',
        'canceled' => 'anulowane',
        'all' => 'pokaż wszystkie'
    ];

    public $statusTypesSymbols = [
        'awaiting' => '&#11118;',
        'accepted' => '&#10004;',
        'completed' => '&#10045;',
        'canceled' => '&#10006;'
    ];

    public $paymentTypes = [
        'online' => 'online',
        'traditional' => 'tradycyjna',
        'on_delivery' => 'przy odbiorze'
    ];

    #[Computed]
    public function orders()
    {
        if ($this->orderStatus === 'all') return Order::latest()->get();
        // filter orders by status
        return Order::where('order_status', $this->orderStatus)->latest()->get();
    }
}; ?>

<section class="h-full">
    <div class="bg-light-grey">
        <div class="area">
            <header>
                <h1 class="heading-base">ZAMÓWIENIA</h1>
            </header>
            <hr class="my-8">
            {{-- filter order status --}}
            <div class="my-8 flex justify-end gap-4 items-center">
                <h3 class="text-coffee ">
                    status<span class="hidden xs:inline"> zamówienia</span>:
                </h3>
                <livewire:admin.orders.status-types-select wire:model.live="orderStatus" :status-types="$statusTypes" />
            </div>
            <div>
                @if ($this->orders->isNotEmpty())
                    <table class="w-full my-12 rounded-sm overflow-hidden" x-data="{openOrderDetails: null}">
                            <thead class="rounded-lg">
                                <tr class="text-coffee font-normal text-sm sm:text-base bg-cream">
                                    <th class="w-12 text-left font-normal p-2">id</th>
                                    <th class="w-26 font-normal p-2">data</th>
                                    <th class="w-36 font-normal p-2 hidden xs:table-cell">imię</th>
                                    <th class="w-44 font-normal p-2">nazwisko</th>
                                    <th class="w-64 font-normal p-2 hidden lg:table-cell">
                                        email
                                    </th>
                                    <th class="w-32 font-normal p-2 hidden sm:table-cell">płatność</th>
                                    <th class="w-16 font-normal p-2">status</th>
                                </tr>
                            </thead>
                            @foreach ($this->orders as $order )
                                <tbody class="border-t bg-white">
                                    <tr wire:key="{{ $order->id }}" class="text-sm sm:text-base px-4">
                                        <td class="p-2">{{ $order->id }}</td>
                                        <td class="text-center p-2">
                                            {{ $order->created_at->toDateString() }}
                                        </td>
                                        <td class="text-center p-2 hidden xs:table-cell">
                                            {{ $order->name }}
                                        </td>
                                        <td class="text-center p-2">
                                            {{ $order->surname }}
                                        </td>
                                        <td class="text-center p-2 hidden lg:table-cell">
                                            {{ $order->email }}
                                        </td>
                                        <td class="text-center p-2 hidden sm:table-cell">
                                            {{ $paymentTypes[$order->payment_type] }}
                                        </td>
                                        <td class="text-center p-2 text-lg/5 sm:text-xl/6">
                                            {!! $statusTypesSymbols[$order->order_status] !!}
                                        </td>
                                    </tr>
                                    {{-- order details --}}
                                    <tr class="text-base">
                                        <td colspan="7">
                                            <div x-cloak x-show="openOrderDetails === {{ $order->id }}" class="bg-white p-4">
                                                <x-order-table-details :order="$order" />
                                            </div>
                                            <div class="flex justify-end gap-3 text-sm m-2">
                                                <button type="button" class="flex text-sea-dark items-center gap-2" @click="openOrderDetails = (openOrderDetails === {{ $order->id }}) ? null : {{ $order->id }} ">
                                                    <span x-text="openOrderDetails === {{ $order->id }} ? 'ukryj szczegóły' : 'pokaż szczegóły'"></span>
                                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg" :class="(openOrderDetails === {{ $order->id }}) && 'rotate-180'">
                                                        <path d="M1 2L3.5 4L6 6L11 2" stroke="#4F7982" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                                <span>|</span>
                                                <a href="{{ '/admin/orders/order/' . $order->id }}" class="text-sea-dark">
                                                    <span>przejdź do strony</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                    </table>
                     <div class="mt-auto">
                        <h4 class="my-1 text-xs">Oznaczenia statusu:</h4>
                        <div class="flex flex-wrap gap-x-2 text-xs">
                            <dl class="flex gap-2">
                                <dt>oczekujące:</dt>
                                <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['awaiting'] !!}</dd>
                            </dl>
                            <span>|</span>
                            <dl class="flex gap-2">
                                <dt class="text-xs">zaakceptowane:</dt>
                                <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['accepted'] !!}</dd>
                            </dl>
                            <span>|</span>
                            <dl class="flex gap-2">
                                <dt class="text-xs">zrealizowane:</dt>
                                <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['completed'] !!}</dd>
                            </dl>
                            <span>|</span>
                            <dl class="flex gap-2">
                                <dt class="text-xs">anulowane:</dt>
                                <dd class="font-paragraph text-base/4">
                                    {!! $statusTypesSymbols['canceled'] !!}
                                </dd>
                            </dl>
                        </div>
                    </div>
                @else
                    <h2 class="text-center my-28 font-paragraph text-xl">Lista zamówień jest pusta.</h2>
                @endif
            </div>
        </div>
    </div>
</section>