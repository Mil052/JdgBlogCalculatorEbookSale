@props(['products', 'totalPrice'])

<div class="@container">
    <h1 class="heading-sm m-12">Twoje produkty</h1>
    @if (!empty($products))
        <div class="bg-white px-3 @sm:px-6 py-6 rounded-sm shadow-[6px_6px_6px_#00000040]">
            <table class="w-full">
                <thead>
                    <tr class="font-paragraph text-xs">
                        <th scope="col" class="w-70 text-left font-normal pb-3">produkt</th>
                        <th scope="col" class="w-20 text-center font-normal pb-3">wartość</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-coffee">
                            {{-- product --}}
                            <td>
                                <div class="flex justify-between gap-4 py-4">
                                    <div class="hidden @md:block min-w-6 h-20 bg-red-brick"></div>
                                    <img src="{{ '/storage/products_assets/' . $product['image'] }}" alt="książka" class="h-20 min-w-15 object-cover object-center">
                                    <div class="grow-1">
                                        <h4 class="font-technic text-xs font-light">{{ $product['type'] }}</h4>
                                        <h3 class="font-title text-base/5 h-10">{{ $product['name'] }}</h3>
                                        <div class="flex gap-4 font-paragraph text-base/5 mt-1">
                                            <div>
                                                {{ $product['price'] }} <span class="text-xs">zł/szt</span>
                                            </div>
                                            <div>
                                                <span class="text-xs mr-2">ilość:</span>{{ $product['quantity'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- total --}}
                            <td class="font-paragraph text-lg text-center">
                                {{ $product['price'] * $product['quantity'] }} <span class="text-xs">zł</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-coffee">
                        <td colspan="2" class="font-paragraph text-xl">
                            <div class="flex justify-between pt-4">
                                <span>Razem</span>
                                <span class="font-medium">{{ $totalPrice }} zł</span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <h2>Brak produktów w koszyku. Sprawdź naszą <a href="/shop">ofertę</a>.</h2>
    @endif
</div>