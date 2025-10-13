<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;

class OrderForm extends Form
{   
    public $products = [];
    public $total;

    // Order fields

    #[Validate('required|min:3')]
    public string|null $name;

    #[Validate('required|min:3')]
    public string|null $surname;

    #[Validate('required|email:rfc')]
    public string|null $email;

    #[Validate('required|regex:/^\d{3}-\d{3}-\d{3}$/')]
    public string|null $phone;

    #[Validate('required|regex:/^\d{2}-\d{3}$/')]
    public string|null $postalCode;

    #[Validate('required|min:3')]
    public string|null $city;

    #[Validate('required|min:3')]
    public string|null $address;

    #[Validate('nullable')]
    public string|null $additionalInfo;

    // Payment

    #[Validate('required|in:online,traditional')]
    public string|null $payment;

    // Invoice use order data

    #[Validate('boolean')]
    public bool $invoiceUseOrderData = false;

    // Invoice fields

    #[Validate('exclude_if:invoiceUseOrderData,true|required|min:3')]
    public string|null $invoiceName;
    
    #[Validate('exclude_if:invoiceUseOrderData,true|required|min:3')]
    public string|null $invoiceSurname;

    #[Validate('nullable|min:3')]
    public string|null $invoiceCompany;

    #[Validate('nullable|regex:/^\d{3}-\d{3}-\d{2}-\d{2}$/')]
    public string|null $invoiceNip;

    #[Validate('exclude_if:invoiceUseOrderData,true|required|regex:/^\d{2}-\d{3}$/')]
    public string|null $invoicePostalCode;

    #[Validate('exclude_if:invoiceUseOrderData,true|required|min:3')]
    public string|null $invoiceCity;

    #[Validate('exclude_if:invoiceUseOrderData,true|required|min:3')]
    public string|null $invoiceAddress;

    public function setProductsAndTotal($products, $total) {
        foreach ($products as $product) {
            $this->products[$product['id']] = [
                'price' => $product['price'],
                'quantity' => $product['quantity']
            ];
        }

        $this->total = $total;
    }

    public function createOrder() {
        $this->validate();
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            // payment
            'payment' => $this->payment,
            'total_price' => $this->total,
            // status
            'status' => 'pending',
            // order shipping data
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'address' => $this->address,
            'additional_info' => $this->additionalInfo ?? null,
        ]);
        
        // Add products to order_product table
        $order->products()->attach($this->products);

        // Create invoice
        $invoice = new Invoice();

        if ($this->invoiceUseOrderData) {
            $invoice->name = $this->name;
            $invoice->surname = $this->surname;
            $invoice->company = null;
            $invoice->nip = null;
            $invoice->postal_code = $this->postalCode;
            $invoice->city = $this->city;
            $invoice->address = $this->address;
        } else {
            $invoice->name = $this->invoiceName;
            $invoice->surname = $this->invoiceSurname;
            $invoice->company = $this->invoiceCompany;
            $invoice->nip = $this->invoiceNip;
            $invoice->postal_code = $this->invoicePostalCode;
            $invoice->city = $this->invoiceCity;
            $invoice->address = $this->invoiceAddress;
        }

        $order->invoice()->save($invoice);

        // Reset form
        $this->reset();
    }
}