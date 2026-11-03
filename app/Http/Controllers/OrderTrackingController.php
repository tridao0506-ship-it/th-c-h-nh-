<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        $ordersList = null;
        $keyword = trim($request->input('track_q', $request->input('q', '')));

        if (!empty($keyword)) {
            // Check if it's an order code or numeric ID
            $order = Order::where('order_code', $keyword)
                ->orWhere('id', is_numeric($keyword) ? (int)$keyword : 0)
                ->with(['items', 'paymentTransactions'])
                ->first();

            // If not found, try searching by phone number
            if (!$order) {
                $ordersList = Order::where('customer_phone', $keyword)
                    ->with(['items', 'paymentTransactions'])
                    ->latest()
                    ->get();
            }
        } elseif (auth()->check()) {
            // Hiển thị đơn hàng của user đang đăng nhập nếu không nhập từ khóa
            $ordersList = Order::where('customer_email', auth()->user()->email)
                ->orWhere('customer_phone', auth()->user()->phone)
                ->with(['items', 'paymentTransactions'])
                ->latest()
                ->get();
        }

        return view('pages.tracking', compact('order', 'ordersList', 'keyword'));
    }
}
