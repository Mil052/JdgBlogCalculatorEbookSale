<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\OrderForm;
use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

new class extends Component {
    public OrderForm $form;
    public Cart $shoppingCart;

    public function mount ($products, $total, Cart $shoppingCart) {
        $this->form->setProductsAndTotal($products, $total);
        $this->shoppingCart = $shoppingCart;
    }

    public function submitOrder()
    {
        // Create order and invoice
        $newOrder = $this->form->createOrder();
        
        // Clear cart
        $this->shoppingCart->cart = null;
        $this->shoppingCart->save();
        // Notify cart-link-icon
        $this->dispatch('cart-change')->to('shop.cart-link-icon');

        // If payment type is online, create PayU order and redirect to payment page
        if ($newOrder->payment_type === 'online') {
            $authorizationToken = PayUAuthorize();
            $description = 'JDG sklep. Zamówienie nr. ' . $newOrder->id;
            $products = $newOrder->products()->map(function($product) {
                return [
                    'name' => $product->type . " " . $product->name,
                    'unitPrice' => $product->product_data->price * 100,
                    'quantity' => $product->product_data->quantity
                ];
            })->toArray();

            $payUOrder =  payUCreateOrder(
                authorizationToken: $authorizationToken,
                orderId: $newOrder->id,
                description: $description,
                products: $products,
                total: $newOrder->total_price
            );

            // Save PayU order ID to order data in DB
            $newOrder->payment_order_id = $payUOrder['orderId'];
            $newOrder->save();

            return redirect($payUOrder['redirectUri']);
        }

        // If payment type is 'traditional' or 'on_delivery' redirect to order-completed page
        return redirect()->route('order-completed', [ 'id' => $newOrder->id ]);
    }
}; ?>

<form class="m-8" wire:submit.prevent="submitOrder">
    {{-- Dane do wysyłki --}}
    <h2 class="heading-sm m-12">Adres do wysyłki</h2>
    <fieldset>
        <div class="flex flex-col gap-2 my-3">
            <label for="name" class="label">imię</label>
            <input type="text" id="name" name="name" required class="input-secondary" wire:model="form.name">
            <div>@error('form.name')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="surname" class="label">nazwisko</label>
            <input type="text" id="surname" name="surname" required class="input-secondary" wire:model="form.surname">
            <div>@error('form.surname')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="email" class="label">email</label>
            <input type="email" id="email" name="email" required class="input-secondary" wire:model="form.email">
            <div>@error('form.email')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="phone" class="label">telefon</label>
            <input type="tel" id="phone" name="phone" required class="input-secondary" pattern="\d{3}-\d{3}-\d{3}" wire:model="form.phone" placeholder="000-000-000">
            <div>@error('form.phone')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="postal_code" class="label">kod pocztowy</label>
            <input type="text" id="postal_code" name="postal_code" pattern="\d{2}-\d{3}" title="Format: XX-XXX" required class="input-secondary" wire:model="form.postalCode">
            <div>@error('form.postalCode')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="city" class="label">miasto</label>
            <input type="text" id="city" name="city" required class="input-secondary" wire:model="form.city">
            <div>@error('form.city')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="address" class="label">adres</label>
            <input type="text" id="address" name="address" required class="input-secondary" wire:model="form.address">
            <div>@error('form.address')<span>{{ $message }}</span>@enderror</div>
        </div>
        <div class="flex flex-col gap-2 my-3">
            <label for="additional_info" class="label">dodatkowe informacje</label>
            <input type="text" id="additional_info" name="additional_info" class="input-secondary" wire:model="form.additionalInfo">
        </div>
    </fieldset>
    <hr class="border-coffee my-12">
    {{-- Sposób płatności --}}
    <div class="flex flex-col gap-2 my-3">
        <label for="payment" class="label">wybierz sposób płatności</label>
        <div class="flex gap-20 justify-center input-secondary">
            <div>
                <input type="radio" id="payment_online" name="payment-type" value="online" required class="mx-4" wire:model="form.paymentType">
                <label for="payment_online" class="label">płatność online</label>
            </div>
            <div>
                <input type="radio" id="payment_traditional" name="payment-type" value="traditional" required class="mx-4" wire:model="form.paymentType">
                <label for="payment_traditional" class="label">tradycyjny przelew</label>
            </div>
            <div>
                <input type="radio" id="payment_on_delivery" name="payment-type" value="on_delivery" required class="mx-4" wire:model="form.paymentType">
                <label for="payment_on_delivery" class="label">płatność przy odbiorze</label>
            </div>
            <div>@error('form.payment')<span>{{ $message }}</span>@enderror</div>
        </div>
    </div>
    {{-- Dane do faktury - pokaż/ukryj formularz --}}
    <div class="my-12">
        <input type="checkbox" id="invoice_use_order_data" name="invoice_use_order_data" wire:model.live="form.invoiceUseOrderData">
        <label for="invoice_use_order_data" class="label mx-4">
            dane do faktury takie same jak dane do wysyłki
        </label>
    </div>
    {{-- Dane do faktury --}}
    @if (!$form->invoiceUseOrderData)
        <hr class="border-coffee my-12">
        <h2 class="heading-sm m-12">Dane do faktury</h2>
        <fieldset>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-name" class="label">imię</label>
                <input type="text" id="invoice-name" name="invoice-name" class="input-secondary" wire:model="form.invoiceName">
                <div>@error('form.invoiceName')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-surname" class="label">nazwisko</label>
                <input type="text" id="invoice-surname" name="invoice-surname" class="input-secondary" wire:model="form.invoiceSurname">
                <div>@error('form.invoiceSurname')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-company" class="label">nazwa firmy</label>
                <input type="text" id="invoice-company" name="invoice-company" class="input-secondary" wire:model="form.invoiceCompany">
                <div>@error('form.invoiceCompany')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-nip" class="label">nip</label>
                <input type="text" id="invoice-nip" inputmode="numeric" name="invoice-nip" pattern="\d{3}-\d{3}-\d{2}-\d{2}" title="Format: XXX-XXX-XX-XX" class="input-secondary" wire:model="form.invoiceNip">
                <div>@error('form.invoiceNip')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-postal_code" class="label">kod pocztowy</label>
                <input type="text" id="invoice-postal_code" name="invoice-postal_code" pattern="\d{2}-\d{3}" title="Format: XX-XXX" class="input-secondary" wire:model="form.invoicePostalCode">
                <div>@error('form.invoicePostalCode')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-city" class="label">miasto</label>
                <input type="text" id="invoice-city" name="invoice-city" class="input-secondary" wire:model="form.invoiceCity">
                <div>@error('form.invoiceCity')<span>{{ $message }}</span>@enderror</div>
            </div>
            <div class="flex flex-col gap-2 my-3">
                <label for="invoice-address" class="label">adres</label>
                <input type="text" id="invoice-address" name="invoiceAddress" class="input-secondary" wire:model="form.invoiceAddress">
                <div>@error('form.invoiceAddress')<span>{{ $message }}</span>@enderror</div>
            </div>
        </fieldset>
    @endif
    <button type="submit" class="block ml-auto my-8 btn-primary">zamawiam i płacę</button>
</form>