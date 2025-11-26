<?php
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use App\Models\Order;
use App\Models\Product;
use App\Models\BlogPost;

new
#[Layout('components.layouts.admin')]
#[Title('JDG Panel Administratora')]
class extends Component {
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

    public $orders;
    public $products;
    public $posts;

    public function mount()
    {
        $this->orders = Order::latest()->limit(6)->get();
        $this->products = Product::limit(3)->get();
        $this->posts = BlogPost::latest()->limit(3)->get();
    }
}; ?>

<section class="h-full">
    <div class="bg-light-grey">
        <div class="area grid lg:grid-cols-2 gap-8">
            {{-- orders --}}
            <div class="@container bg-white py-4 px-2 xs:px-4 rounded-sm min-h-70 shadow-[6px_6px_6px_#00000040]">
                <div class="flex justify-between items-end">
                    <h3 class="heading-sm">ZAMÓWIENIA</h3>
                    <a href="/admin/orders" class="text-sea-dark flex gap-2 items-center">
                        <span>wyświetl wszystkie</span>
                        <x-icon.sqr-arrow-down class="w-5 h-5 mb-1" />
                    </a>
                </div>
                <hr class="my-6">
                @if ($orders->isNotEmpty())
                    <table class="table-fixed w-full" x-data="{openOrderDetails: null}">
                            <thead>
                                <tr class="text-coffee font-normal text-sm">
                                    <th class="w-10 text-left font-normal px-1 py-2">id</th>
                                    <th class="w-23 font-normal px-1 py-2">data</th>
                                    <th class="hidden @md:table-cell w-28 font-normal px-1 py-2">imię</th>
                                    <th class="w-36 font-normal px-1 py-2">nazwisko</th>
                                    <th class="w-14 font-normal px-1 py-2">status</th>
                                </tr>
                            </thead>
                            @foreach ($orders as $order )
                                <tbody class="border-t">
                                    <tr wire:key="{{ $order->id }}" class="text-sm xs:text-base">
                                        <td class="px-1 py-2">{{ $order->id }}</td>
                                        <td class="text-center px-1 py-2">
                                            {{ $order->created_at->toDateString() }}
                                        </td>
                                        <td class="hidden @md:table-cell text-center px-1 py-2">{{ $order->name }}</td>
                                        <td class="text-center px-1 py-2">{{ $order->surname }}</td>
                                        <td class="text-center px-1 py-2 text-xl/5 sm:text-2xl/6">
                                            {!! $statusTypesSymbols[$order->order_status] !!}
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                    </table>
                @else
                    <h2 class="text-center my-28 font-paragraph text-xl">Lista zamówień jest pusta.</h2>
                @endif
            </div>
            {{-- products --}}
            <div class="bg-white py-2 px-2 xs:px-4 rounded-sm min-h-70 shadow-[6px_6px_6px_#00000040]">
                <div class="flex justify-between items-end">
                    <h3 class="heading-sm">PRODUKTY</h3>
                    <a href="/admin/products" class="text-sea-dark flex gap-2 items-center">
                        <span>wyświetl wszystkie</span>
                        <x-icon.sqr-arrow-down class="w-5 h-5 mb-1" />
                    </a>
                </div>
                <hr class="my-6">
                <ul>
                    @foreach ($this->products as $product)
                        <li wire:key="{{ $product->id }}" class="my-8" x-data="{showDetails: false}">
                            <div class="flex gap-4 xs:gap-6">
                                <div class="min-w-3 bg-coffee"></div>
                                <div class="h-15 min-w-10">
                                    <img src="{{ '/storage/products_assets/' . $product->image }}" alt="product preview" class="h-full">
                                </div>
                                <div class="grow flex flex-col justify-between">
                                    <h3 class="font-paragraph text-sm xs:text-base/5 font-normal">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex gap-2 text-xs xs:text-sm">
                                        <dl class="flex">
                                            <dt>
                                                <span class="hidden xs:inline">produkt </span>id:
                                            </dt>
                                            <dd class="ml-1">{{ $product->id }}</dd>
                                        </dl>
                                        <span>|</span>
                                        <dl class="flex">
                                            <dt>typ:</dt>
                                            <dd class="ml-1">{{ $product->type }}</dd>
                                        </dl>
                                        <span>|</span>
                                        <dl class="flex">
                                            <dt>cena:</dt>
                                            <dd class="ml-1">{{ $product->price }} zł</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{-- posts --}}
            <div class="col-span-full bg-white p-4 rounded-sm min-h-70 shadow-[6px_6px_6px_#00000040]">
                <div class="flex justify-between items-end">
                    <h3 class="heading-sm">BLOG</h3>
                    <a href="/admin/blog" class="text-sea-dark flex gap-2 items-center">
                        <span>wyświetl wszystkie</span>
                        <x-icon.sqr-arrow-down class="w-5 h-5 mb-1" />
                    </a>
                </div>
                <hr class="my-6">
                <ul>
                    @foreach ($posts as $post)
                        <li class="my-6">
                            <div class="flex gap-4">
                                <div class="bg-coffee min-w-7"></div>
                                <h3 class="font-title text-lg xs:text-xl">{{ $post->title }}</h3>
                            </div>
                            <p class="my-2 text-sm xs:text-base">{{ $post->excerpt }}</p>
                            <address class="author text-right text-sm xs:text-base">
                                {{ $post->author }}
                            </address>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>