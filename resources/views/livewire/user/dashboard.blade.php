<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Order;

new
#[Layout('components.layouts.user')]
#[Title('JDG Panel Użytkownika')]
class extends Component {
    public User $user;
    public $orders;

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

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->orders = $this->user->orders;
    }
}; ?>

<section class="">
    <div class="mx-8">
        <h1 class="heading-lg my-4">Panel użytkownika</h1>
        <h2 class="font-paragraph text-xl">
            Witaj <span class="font-semibold">{{ $user->name }}</span>.
        </h2>
    </div>
    <hr class="border-light-coffee my-16">
    <h2 class="font-paragraph text-xl">
        Twoje zamówienia
    </h2>
    <div class="@container">
        @if ($orders->isNotEmpty())
            <table class="w-full my-12 rounded-sm overflow-hidden" x-data="{openOrderDetails: null}">
                    <thead class="rounded-lg">
                        <tr class="text-coffee font-normal text-sm sm:text-base bg-cream">
                            <th class="w-12 text-left font-normal p-2">id</th>
                            <th class="w-26 font-normal p-2">data</th>
                            <th class="w-36 font-normal p-2 hidden xs:table-cell">imię</th>
                            <th class="w-40 font-normal p-2">nazwisko</th>
                            <th class="w-48 font-normal p-2 hidden @3xl:table-cell">
                                email
                            </th>
                            <th class="w-32 font-normal p-2 hidden sm:table-cell">płatność</th>
                            <th class="w-16 font-normal p-2">status</th>
                        </tr>
                    </thead>
                    @foreach ( $orders as $order )
                        <tbody class="border-t bg-light-grey">
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
                                <td class="text-center text-nowrap text-ellipsis p-2 hidden @3xl:table-cell">
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
                                    <div x-cloak x-show="openOrderDetails === {{ $order->id }}" class="bg-light-grey p-4">
                                        <x-order-table-details :order="$order" desc-bg-class="bg-white" />
                                    </div>
                                    <div class="flex justify-end gap-3 text-sm m-2">
                                        <button type="button" class="flex text-sea-dark items-center gap-2" @click="openOrderDetails = (openOrderDetails === {{ $order->id }}) ? null : {{ $order->id }} ">
                                            <span x-text="openOrderDetails === {{ $order->id }} ? 'ukryj szczegóły' : 'pokaż szczegóły'"></span>
                                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg" :class="(openOrderDetails === {{ $order->id }}) && 'rotate-180'">
                                                <path d="M1 2L3.5 4L6 6L11 2" stroke="#4F7982" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
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
</section>