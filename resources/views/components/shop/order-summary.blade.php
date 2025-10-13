@props(['products', 'totalPrice'])

<div class="m-8">
    <h1 class="heading-sm m-12">Twoje produkty</h1>
    @if (!empty($products))
        <div class="bg-white p-6 rounded-sm shadow-[6px_6px_6px_#00000040]">
            <table>
                <colgroup>
                    <col class="w-10 hidden md:table-column"/>
                    <col class="w-72"/>
                    <col class="w-28 md:w-28"/>
                </colgroup>
                <thead>
                    <tr class="font-paragraph text-xs">
                        <th></th>
                        <th scope="col" class="text-left font-normal px-2 pb-3">produkt</th>
                        <th scope="col" class="text-center font-normal pb-3">wartość</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-t border-coffee">
                            <td class="h-full">
                                <div class="w-6 h-20 bg-red-brick"></div>
                            </td>
                            {{-- product --}}
                            <td>
                                <div class="flex gap-4 py-4 px-2">
                                    <img src="{{ '/storage/products_assets/' . $product['image'] }}" alt="książka" class="h-20 w-15 object-cover object-center">
                                    <div class="grow-1">
                                        <h4 class="font-technic text-xs font-light">{{ $product['type'] }}</h4>
                                        <h3 class="font-title text-base/5 h-10">{{ $product['name'] }}</h3>
                                        <div class="flex gap-8 font-paragraph text-base/5 mt-1">
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
                        <th colspan="2" class="font-paragraph text-xl font-light pt-4 text-left">Razem</th>
                        <td class="font-paragraph text-2xl font-medium pt-4 text-center">
                            {{ $totalPrice }} <span class="font-normal text-base">zł</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <h2>Brak produktów w koszyku. Sprawdź naszą <a href="/shop">ofertę</a>.</h2>
    @endif
</div>