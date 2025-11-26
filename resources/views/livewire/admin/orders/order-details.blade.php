<?php
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Order;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
    public Order $order;

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

    public function mount($id)
    {
        $this->order = Order::findOrFail($id);
    }
}; ?>

<section class="area">
    <div class="flex justify-between items-center">
        <h1 class="heading-base">ZAMÓWIENIE (id: {{ $order->id }})</h1>
        <a href="/admin/orders" class="flex gap-6 items-end text-sea-dark">
            <span class="hidden xs:inline">lista zamówień</span>
            <x-icon.sqr-arrow-up class="w-6 h-6 mb-1"/>
        </a>
    </div>
    <hr class="my-8">
    <div class="my-8 bg-white p-4 rounded-sm">
        <x-order-table-details :order="$order" />
    </div>
    <h3 class="font-pargraph text-xl m-8">Lista produktów</h3>
    <div class="my-8">
         <table class="w-full bg-white rounded-sm overflow-hidden font-paragraph text-sm sm:text-base">
                <thead class="text-coffee">
                    <tr>
                        <th class="w-10 md:w-14 hidden xs:table-cell font-normal p-2 text-left">id</th>
                        <th class="w-18 hidden sm:table-cell font-normal"></th>
                        <th class="font-normal p-2 text-left">nazwa</th>
                        <th class="w-15 sm:w-18 md:w-24 font-normal p-2">cena</th>
                        <th class="w-15 sm:w-18 md:w-24 font-normal p-2">ilość</th>
                        <th class="w-15 sm:w-18 md:w-24 hidden xs:table-cell font-normal p-2">koszt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                        <tr class="border-t">
                            <td class="hidden xs:table-cell p-2">{{ $product->id }}</td>
                            <td class="hidden sm:table-cell py-2 px-4">
                                <img src="{{ '/storage/products_assets/' . $product->image }}" alt="product preview" class="h-15">
                            </td>
                            <td class="p-2">{{ $product->name }}</td>
                            <td class="p-2 text-center">{{ $product->product_data->price }}</td>
                            <td class="p-2 text-center">{{ $product->product_data->quantity }}</td>
                            <td class="hidden xs:table-cell p-2 text-center">
                                {{ $product->product_data->price * $product->product_data->quantity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</section>
