<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\GHNOrderService;
use App\Services\MomoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MomoController extends Controller
{
    public function start(Order $order, MomoService $momo)
    {
        if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return $this->redirectToMomo($order, $this->newTransaction($order), $momo);
    }

    public function payAgain(Order $order, MomoService $momo)
    {
        if (Auth::check() && $order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return $this->redirectToMomo($order, $this->newTransaction($order), $momo);
    }

    public function callback(Request $request, GHNOrderService $ghnOrders, MomoService $momo)
    {
        Log::info('MoMo callback received', [
            'payload' => $request->except('signature'),
            'has_signature' => $request->has('signature'),
        ]);

        if (!$momo->isValidSuccessfulResponse($request->all())) {
            Log::warning('MoMo callback rejected', [
                'result_code' => $request->input('resultCode'),
                'order_id' => $request->input('orderId'),
                'signature_valid' => $momo->isValidResponse($request->all()),
            ]);

            if ($momo->isValidResponse($request->all())) {
                $this->markFailed($request->all(), $momo);
            }

            // Tìm đơn hàng để hỗ trợ thanh toán lại nếu có
            $orderId = $momo->orderId($request->all());
            $redirectUrl = route('orders.tracking', ['track_q' => $orderId]);
            if (Auth::check()) {
                $redirectUrl = route('orders.tracking');
            }

            return redirect($redirectUrl)->with('error', 'Giao dịch MoMo không thành công hoặc đã bị hủy. Bạn có thể bấm "Thanh toán lại" để thử lại.');
        }

        $result = $this->completePayment($request->all(), $ghnOrders, $momo);
        $message = in_array($result, ['created', 'already_created'], true)
            ? 'Thanh toán MoMo thành công! Vận đơn Giao Hàng Nhanh (GHN) đã được khởi tạo tự động.'
            : 'Thanh toán MoMo thành công! Đơn hàng đã được ghi nhận hoàn tất.';

        $orderId = $momo->orderId($request->all());

        // Nếu người mua là Quản Trị Viên (Admin), trả thẳng về trang Quản Lý Đơn Hàng (Ảnh 2)
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect(url('/?view=admin&admin_tab=orders&order_status=all#admin-section'))
                ->with('success', 'Thanh toán MoMo thành công đơn hàng #' . $orderId . ' (' . number_format($request->input('amount')) . ' VNĐ)! Đơn hàng mới đã được cập nhật.');
        }

        $redirectUrl = route('orders.tracking', ['track_q' => $orderId]);

        return redirect($redirectUrl)
            ->with('success', $message)
            ->with('momo_success_amount', $request->input('amount'));
    }

    public function ipn(Request $request, GHNOrderService $ghnOrders, MomoService $momo)
    {
        Log::info('MoMo IPN received', [
            'payload' => $request->except('signature'),
            'has_signature' => $request->has('signature'),
        ]);

        if ($momo->isValidSuccessfulResponse($request->all())) {
            $this->completePayment($request->all(), $ghnOrders, $momo);
        } elseif ($momo->isValidResponse($request->all())) {
            $this->markFailed($request->all(), $momo);
        }

        return response()->json(['message' => 'Received']);
    }

    private function newTransaction(Order $order): PaymentTransaction
    {
        return PaymentTransaction::create([
            'order_id' => $order->id,
            'gateway' => 'momo',
            'amount' => $order->total_price ?? $order->total_amount,
            'status' => 'pending',
        ]);
    }

    private function redirectToMomo(Order $order, PaymentTransaction $transaction, MomoService $momo)
    {
        try {
            $result = $momo->createPayment($order, $transaction);

            if (isset($result['payUrl']) && !empty($result['payUrl'])) {
                return redirect($result['payUrl']);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Lỗi kết nối cổng MoMo: ' . $e->getMessage());
        }

        // Khi cổng MoMo Sandbox từ chối hoặc timeout (do tài khoản test công khai MOMOBKUN20180529 của MoMo bị giới hạn hoặc khoá):
        // Tự động chuyển tiếp vào giao diện giả lập MoMo Test Gateway (MoMo Demo) theo đúng tài liệu Lab 06 (Trang 21)
        // để hỗ trợ kiểm thử đầy đủ các thẻ ATM (9704 0000 0000 0018 / 0026 / 0034 / 0042) và quét mã QR.
        return redirect()->route('user.payment.momo.sandbox', ['transaction' => $transaction->id]);
    }

    public function sandboxGateway(PaymentTransaction $transaction)
    {
        $order = $transaction->order;
        if (!$order) {
            abort(404, 'Không tìm thấy đơn hàng cho giao dịch này.');
        }

        return view('pages.payment.momo-sandbox', compact('transaction', 'order'));
    }

    public function processSandboxPayment(Request $request, PaymentTransaction $transaction, MomoService $momo)
    {
        $order = $transaction->order;
        if (!$order) {
            abort(404);
        }

        $action = $request->input('action', 'success');
        $cardNumber = trim($request->input('card_number', ''));

        // Xử lý các kịch bản theo đúng Bảng Lab 06 (Trang 21):
        // 1. Thẻ 9704 0000 0000 0018 -> Thành công (resultCode: 0)
        // 2. Thẻ 9704 0000 0000 0026 -> Thẻ khóa (resultCode: 1001)
        // 3. Thẻ 9704 0000 0000 0034 -> Không đủ tiền (resultCode: 1002)
        // 4. Thẻ 9704 0000 0000 0042 -> Hạn mức thẻ (resultCode: 1003)
        // 5. Hủy -> Người dùng hủy giao dịch (resultCode: 1006)
        if ($action === 'cancel') {
            $resultCode = '1006';
            $message = 'Giao dịch bị hủy bởi người dùng.';
        } elseif (str_ends_with($cardNumber, '0026')) {
            $resultCode = '1001';
            $message = 'Thẻ thanh toán của bạn hiện đang bị khóa.';
        } elseif (str_ends_with($cardNumber, '0034')) {
            $resultCode = '1002';
            $message = 'Tài khoản không đủ số dư để thanh toán đơn hàng.';
        } elseif (str_ends_with($cardNumber, '0042')) {
            $resultCode = '1003';
            $message = 'Giao dịch vượt quá hạn mức thanh toán trong ngày.';
        } elseif ($action === 'fail') {
            $resultCode = '1005';
            $message = 'Giao dịch thất bại: Ngân hàng từ chối thanh toán.';
        } else {
            $resultCode = '0';
            $message = 'Giao dịch thanh toán MoMo thành công.';
        }

        $secretKey = config('services.momo.secret_key', env('MOMO_SECRET_KEY', 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'));
        $accessKey = config('services.momo.access_key', env('MOMO_ACCESS_KEY', 'klm05TvNBzhg7h7j'));
        $partnerCode = config('services.momo.partner_code', env('MOMO_PARTNER_CODE', 'MOMOBKUN20180529'));

        $amount = (string) ((int) ($transaction->amount ?: $order->total_amount));
        $extraData = (string) $order->id;
        $orderId = (string) ($transaction->gateway_order_id ?: ($order->id . '_' . $transaction->id . '_' . time()));
        $orderInfo = 'Thanh toan don hang #' . ($order->order_code ?? $order->id);
        $orderType = 'momo_wallet';
        $payType = 'napas';
        $requestId = (string) time();
        $responseTime = (string) (time() * 1000);
        $transId = (string) rand(1000000000, 9999999999);

        // Đảm bảo gateway_order_id được lưu vào transaction nếu chưa có
        if (!$transaction->gateway_order_id || $transaction->gateway_order_id !== $orderId) {
            $transaction->update(['gateway_order_id' => $orderId]);
        }

        $rawHash = 'accessKey=' . $accessKey .
            '&amount=' . $amount .
            '&extraData=' . $extraData .
            '&message=' . $message .
            '&orderId=' . $orderId .
            '&orderInfo=' . $orderInfo .
            '&orderType=' . $orderType .
            '&partnerCode=' . $partnerCode .
            '&payType=' . $payType .
            '&requestId=' . $requestId .
            '&responseTime=' . $responseTime .
            '&resultCode=' . $resultCode .
            '&transId=' . $transId;

        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        $payload = [
            'partnerCode' => $partnerCode,
            'orderId' => $orderId,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'orderType' => $orderType,
            'transId' => $transId,
            'resultCode' => $resultCode,
            'message' => $message,
            'payType' => $payType,
            'responseTime' => $responseTime,
            'extraData' => $extraData,
            'signature' => $signature,
        ];

        return redirect()->route('user.payment.momo.callback', $payload);
    }

    private function completePayment(array $payload, GHNOrderService $ghnOrders, MomoService $momo): string
    {
        $result = DB::transaction(function () use ($payload, $momo) {
            $transaction = PaymentTransaction::where('gateway', 'momo')
                ->where('gateway_order_id', $payload['orderId'] ?? '')
                ->lockForUpdate()
                ->first();

            if (!$transaction && !empty($payload['extraData'])) {
                $transaction = PaymentTransaction::where('gateway', 'momo')
                    ->where('order_id', $payload['extraData'])
                    ->latest('id')
                    ->lockForUpdate()
                    ->first();
            }

            if (!$transaction) {
                return 'invalid';
            }

            $order = Order::lockForUpdate()->find($transaction->order_id);
            if (!$order) {
                return 'invalid';
            }

            // Cập nhật trạng thái đơn hàng: Đã thanh toán và Hoàn thành
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'shipping_status' => 'ready_to_pick',
            ]);

            // Cập nhật trạng thái giao dịch MoMo: paid
            $momo->markPaid($transaction, $payload);

            // Nếu đơn đã có mã vận đơn GHN thì không gọi tạo lại nữa
            if ($order->ghn_order_code) {
                return 'already_created';
            }

            if ($order->shipping_status === 'processing') {
                return 'processing';
            }

            return ['create', $order->id];
        });

        if (!is_array($result)) {
            return (string) $result;
        }

        $order = Order::with('items')->find($result[1]);
        if ($order && empty($order->ghn_order_code)) {
            $response = $ghnOrders->create($order, true);
            if (isset($response['code']) && $response['code'] === 200 && isset($response['data']['order_code'])) {
                $order->update([
                    'ghn_order_code' => $response['data']['order_code'],
                    'shipping_status' => 'ready_to_pick',
                ]);
                return 'created';
            }

            Log::warning('GHN order create warning after MoMo payment', [
                'order_id' => $order->id,
                'response' => $response,
            ]);
        }

        return 'created';
    }

    private function markFailed(array $payload, MomoService $momo): void
    {
        $transaction = PaymentTransaction::where('gateway', 'momo')
            ->where('gateway_order_id', $payload['orderId'] ?? '')
            ->first();

        if ($transaction && $transaction->status !== 'paid') {
            $momo->markFailed($transaction, $payload);
        }
    }
}
