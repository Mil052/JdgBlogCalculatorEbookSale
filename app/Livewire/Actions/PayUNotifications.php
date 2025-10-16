<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Order;

class PayUNotifications
{
    private function getSignatureFromHeader($signatureHeader)
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

    private function checkSignature($signatureHeader, $payload)
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
        $validSignature = $this->checkSignature($signatureHeader, $payload);

        if ($validSignature) {
            $requestData = json_decode($payload, true);

            $order= Order::find($requestData['order']['extOrderId']);

            // If notificationhas been already sent before return status 200
            if ($order->payment_status === $requestData['order']['status']) {
                return response()->noContent(200);
            }
            // If payment status changed update order data
            $order->payment_status = $requestData['order']['status'];

            if ($requestData['order']['status'] === 'COMPLETED') {
                $order->payment_transaction_id = $requestData['properties']['value'];
            }
            
            $order->save();

            return response()->noContent(200);
        }
        return abort(403);
    }
}