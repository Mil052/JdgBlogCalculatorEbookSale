@props([
    'order',
    'orderStatusTypes' => [
        'awaiting' => 'oczekujące (przetwarzanie zamówienia)',
        'accepted' => 'zamówienie przyjęte do realizacji', 
        'completed' => 'zamówienie zrealizowane',
        'canceled' => 'anulowane'
    ],
    'paymentTypes' => [
        'online' => 'PayU (płatność online)',
        'traditional' => 'tradycyjny przelew / płatność gotówką',
        'on_delivery' => 'płatność przy odbiorze'
    ]
])

<dl class="grid md:grid-cols-2 gap-12">
    {{-- shipping address and contact data --}}
    <div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">imię</dt>
            <dd class="bg-cream px-3 rounded-sm">{{ $order->name }}</dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">nazwisko</dt>
            <dd class="bg-cream px-3 rounded-sm">{{ $order->surname }}</dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">address</dt>
            <dd class="bg-cream px-3 rounded-sm">
                {{ $order->address . ', ' . $order->postal_code . ' ' . $order->city }}
            </dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">email</dt>
            <dd class="bg-cream px-3 rounded-sm">{{ $order->email }}</dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">telefon</dt>
            <dd class="bg-cream px-3 rounded-sm">{{ $order->phone }}</dd>
        </div>
    </div>
    {{-- payment and order status --}}
    <div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">status zamówienia</dt>
            <dd class="bg-cream px-3 rounded-sm">
                {{ isset($order->order_status) ? $orderStatusTypes[$order->order_status] : '-' }}
            </dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">sposób płatności</dt>
            <dd class="bg-cream px-3 rounded-sm">
                {{ isset($order->payment_type) ? $paymentTypes[$order->payment_type] : '-' }}
            </dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">kwota</dt>
            <dd class="bg-cream px-3 rounded-sm">{{ $order->total_price }} zł</dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">status płatności</dt>
            <dd class="bg-cream px-3 rounded-sm">
                {{ $order->payment_status ?? '-' }}
            </dd>
        </div>
        <div class="my-2">
            <dt class="text-coffee text-sm my-1">ID transakcji</dt>
            <dd class="bg-cream px-3 rounded-sm">
                {{ $order->payment_transaction_id ?? '-' }}
            </dd>
        </div>
    </div>
</dl>