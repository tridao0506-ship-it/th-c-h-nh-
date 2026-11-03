<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GHNWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('GHN Webhook received: ', $request->all());

        $orderCode = $request->input('OrderCode');
        $status = strtolower((string) $request->input('Status'));

        if ($orderCode) {
            $order = Order::where('ghn_order_code', $orderCode)->first();
            if ($order) {
                $statusMap = [
                    'ready_to_pick' => 'ready_to_pick',
                    'picking' => 'shipping',
                    'delivering' => 'shipping',
                    'delivered' => 'completed',
                    'cancel' => 'cancelled',
                ];

                $newShippingStatus = $statusMap[$status] ?? $order->shipping_status;
                $order->update([
                    'shipping_status' => $newShippingStatus,
                    'order_status' => ($newShippingStatus === 'completed') ? 'completed' : $order->order_status,
                ]);
            }
        }

        return response()->json(['code' => 200, 'message' => 'success']);
    }
}
