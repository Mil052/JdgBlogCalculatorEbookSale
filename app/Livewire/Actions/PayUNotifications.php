<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\Order;

class PayUNotifications
{
    protected function getSignatureFromHeader($signatureHeader)
    {
        // https://developers.payu.com/europe/pl/docs/payment-flows/lifecycle/#notification-examples
        $params = explode(";", $signatureHeader);

        foreach ($params as $param) {
            $signatureParam = explode("=", $param);
            if ($signatureParam[0] === "signature") {
                return $signatureParam[1];
            }
        }
        return null;
    }

    protected function checkSignature($signatureHeader, $payload)
    {
        $signature = $this->getSignatureFromHeader($signatureHeader);
        $computedSignature = md5( $payload . env('PAYU_SECOND_KEY_MD5'));

        if ($signature == $computedSignature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Handle PayU notifications.
     */
    public function __invoke()
    {
        $signatureHeader = request()->header('OpenPayu-Signature');
        $payload = request()->getContent();

        Log::debug('PayU Notification Received: ' . $payload);

        $validSignature = $this->checkSignature($signatureHeader, $payload);

        if ($validSignature) {
            $requestData = json_decode($payload, true);

            Log::debug('PayU Notification Order status: ' . $requestData['order']['status']);

            $order= Order::find($requestData['order']['extOrderId']);

            // If order status in DB is "COMPLETED" ignore all notifications and return status 200
            if ($order->payment_status === 'COMPLETED') {
                return response()->noContent(200);
            }

            // Set order payment status based on notification
            $order->payment_status = $requestData['order']['status'];

            if ($requestData['order']['status'] === 'COMPLETED') {
                $order->payment_transaction_id = $requestData['properties'][0]['value'];
                $order->order_status = 'accepted';
            }
            
            $order->save();

            return response()->noContent(200);
        }
        Log::debug('PayU Notification Signature is Invalid.');
        return abort(403);
    }
}