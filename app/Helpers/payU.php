<?php

use Illuminate\Support\Facades\Http;

if (! function_exists('PayUAuthorize')) {
  function PayUAuthorize(): string 
	{
		$response = Http::asForm()->post(env('PAYU_AUTHORIZATION_URL'), [
			'grant_type' => 'client_credentials',
			'client_id' => env('PAYU_CLIENT_ID'),
			'client_secret' => env('PAYU_CLIENT_SECRET'),
    	]);

		if ($response->failed()) {
			throw new Exception('Failed to authorize with PayU: ' . $response->body());
		}
		
		return $response->json()['access_token'];
	}
}

if (! function_exists('payUCreateOrder')) {
  function payUCreateOrder(string $authorizationToken, $orderId, $description, $products, $total, $buyer) 
	{
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer ' . $authorizationToken
		])->post(env('PAYU_ORDER_URL'), [
			'continueUrl' => route('order-payment-status', [ 'id' => $orderId ]),
			'notifyUrl' => route('payment-notifications'),
			// 'notifyUrl' => 'https://neville-metallic-takisha.ngrok-free.dev/shop/payment/notifications',
			'customerIp' => request()->ip(),
			'merchantPosId' => env('PAYU_MERCHANT_POS_ID'),
			'extOrderId' => $orderId,
			'description' => $description,
			'currencyCode' => 'PLN',
			'totalAmount' => (int) $total * 100, // liczona w groszach
			'buyer' => $buyer,
			'products' => $products
    ]);

		if ($response->failed()) {
			throw new Exception('Failed to create new order with PayU: ' . $response->body());
		}
		
		return $response->json();
	}
}
