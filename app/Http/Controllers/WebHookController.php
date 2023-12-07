<?php

namespace App\Http\Controllers;

use App\Services\MercadoPagoPaymentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebHookController extends Controller
{
    public function mercadoPagoEvent(Request $request)
    {
        $args = $request->all();

        $methodType = $request->get('type');

        // Trata pagamentos
        if ($methodType == 'payment') {
            $paymentService = new MercadoPagoPaymentServices();
            $paymentService->confirmPayment($request);

            return response()->json(["status" => "success"]);
        } else {
            Log::error('mercadopago-webhook-failed', ['msg' => 'Action Type not supported', 'action' => $request->get('type')]);
            return response()->json(["status" => "success", "msg" => "queue failed because type is not supported", "type" => $request->get('type')]);
        }
    }
}
