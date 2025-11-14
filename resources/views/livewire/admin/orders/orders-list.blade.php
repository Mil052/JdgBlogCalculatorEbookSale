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
            <div class="mt-8 mb-16 flex justify-end gap-4 items-center">
                <h3 class="text-coffee">status zamówienia:</h3>
                <livewire:admin.orders.status-types-select wire:model.live="orderStatus" :status-types="$statusTypes" />
            </div>
            <div>
                @if ($this->orders->isNotEmpty())
                    <table class="table-fixed w-full" x-data="{openOrderDetails: null}">
                            <colgroup>
                                <col class="w-16"/>
                                <col class="w-32"/>
                                <col class="w-36 hidden md:table-column"/>
                                <col class="w-44 hidden md:table-column"/>
                                <col class="w-64"/>
                                <col class="w-22 md:w-32 hidden sm:table-column"/>
                                <col class="w-22 lg:w-32" />
                            </colgroup>
                            <thead>
                                <tr class="text-coffee font-normal">
                                    <th class="text-left font-normal py-2">id</th>
                                    <th class="font-normal py-2">data</th>
                                    <th class="font-normal py-2">imię</th>
                                    <th class="font-normal py-2">nazwisko</th>
                                    <th class="font-normal py-2">email</th>
                                    <th class="font-normal py-2">płatność</th>
                                    <th class="font-normal py-2">status</th>
                                </tr>
                            </thead>
                            @foreach ($this->orders as $order )
                                <tbody class="border-t">
                                    <tr wire:key="{{ $order->id }}" class="text-base">
                                        <td class="py-2">{{ $order->id }}</td>
                                        <td class="text-center py-2">{{ $order->created_at->toDateString() }}</td>
                                        <td class="text-center py-2">{{ $order->name }}</td>
                                        <td class="text-center py-2">{{ $order->surname }}</td>
                                        <td class="text-center py-2">{{ $order->email }}</td>
                                        <td class="text-center py-2">{{ $paymentTypes[$order->payment_type] }}</td>
                                        <td class="text-center py-2">{{ $statusTypes[$order->order_status] }}</td>
                                    </tr>
                                    {{-- order details --}}
                                    <tr class="text-base">
                                        <td colspan="7">
                                            <div x-cloak x-show="openOrderDetails === {{ $order->id }}" class="bg-white border rounded-sm p-4">
                                                <x-order-table-details :order="$order" />
                                            </div>
                                            <div class="flex justify-end gap-3 text-sm my-2">
                                                <button type="button" class="flex text-sea-dark items-center gap-2" @click="openOrderDetails = (openOrderDetails === {{ $order->id }}) ? null : {{ $order->id }} ">
                                                    <span x-text="openOrderDetails === {{ $order->id }} ? 'ukryj szczegóły' : 'pokaż szczegóły'"></span>
                                                    <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg" :class="(openOrderDetails === {{ $order->id }}) && 'rotate-180'">
                                                        <path d="M1 2L3.5 4L6 6L11 2" stroke="#4F7982" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </button>
                                                <span>|</span>
                                                <a href="{{ '/admin/orders/order/' . $order->id }}" class="text-sea-dark">wyświetl wszystkie informacje</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                    </table>
                     <div class="mt-auto">
                        <h4 class="my-1 text-xs">Oznaczenia statusu:</h4>
                        <div class="flex flex-col @md:flex-row gap-x-2 text-xs">
                            <div class="flex gap-2">
                                <dl class="flex gap-2">
                                    <dt>oczekujące:</dt>
                                    <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['awaiting'] !!}</dd>
                                </dl>
                                <span>|</span>
                                <dl class="flex gap-2">
                                    <dt class="text-xs">zaakceptowane:</dt>
                                    <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['accepted'] !!}</dd>
                                </dl>
                            </div>
                            <span class="hidden @md:inline">|</span>
                            <div class="flex gap-2">
                                <dl class="flex gap-2">
                                    <dt class="text-xs">zrealizowane:</dt>
                                    <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['completed'] !!}</dd>
                                </dl>
                                <span>|</span>
                                <dl class="flex gap-2">
                                    <dt class="text-xs">anulowane:</dt>
                                    <dd class="font-paragraph text-base/4">{!! $statusTypesSymbols['canceled'] !!}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                @else
                    <h2 class="text-center my-28 font-paragraph text-xl">Lista zamówień jest pusta.</h2>
                @endif
            </div>
        </div>
    </div>
</section>