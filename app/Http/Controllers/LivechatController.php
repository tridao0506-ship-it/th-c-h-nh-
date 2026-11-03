<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivechatController extends Controller
{
    /**
     * Khách hàng lấy toàn bộ tin nhắn của mình
     */
    public function getClientMessages(Request $request)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $query = ChatMessage::query();
        if ($userId) {
            $query->where(function ($q) use ($userId, $sessionId) {
                $q->where('user_id', $userId)
                  ->orWhere(function ($sub) use ($sessionId) {
                      $sub->whereNull('user_id')->where('session_id', $sessionId);
                  });
            });
        } else {
            $query->where('session_id', $sessionId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'is_logged_in' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
                'role' => Auth::user()->role,
            ] : null,
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender_type,
                    'sender_name' => $msg->sender_name,
                    'text' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d/m/Y'),
                ];
            }),
        ]);
    }

    /**
     * Khách hàng gửi tin nhắn cho Shop
     */
    public function sendClientMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'product_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $sessionId = session()->getId();

        $productId = $request->input('product_id');
        $product = $productId ? Product::find($productId) : null;

        // Nếu khách chưa chọn sản phẩm ở tin này, kiểm tra xem trước đó đã hỏi sản phẩm nào chưa
        if (!$product && $user) {
            $lastWithProd = ChatMessage::where('user_id', $user->id)
                ->whereNotNull('product_id')
                ->latest()
                ->first();
            if ($lastWithProd) {
                $productId = $lastWithProd->product_id;
                $product = $lastWithProd->product;
            }
        }

        // Tạo tin nhắn mới từ khách hàng
        $chat = ChatMessage::create([
            'user_id' => $user ? $user->id : null,
            'session_id' => $sessionId,
            'sender_type' => 'customer',
            'sender_name' => $user ? $user->name : 'Khách Trực Tuyến',
            'customer_name' => $user ? $user->name : 'Khách Trực Tuyến',
            'customer_phone' => $user ? $user->phone : null,
            'customer_email' => $user ? $user->email : null,
            'product_id' => $product ? $product->id : null,
            'product_name' => $product ? $product->name : null,
            'message' => trim($request->input('message')),
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'sender' => 'customer',
                'sender_name' => $chat->sender_name,
                'text' => $chat->message,
                'time' => $chat->created_at->format('H:i'),
                'date' => $chat->created_at->format('d/m/Y'),
            ],
        ]);
    }

    /**
     * Admin: Lấy danh sách toàn bộ các cuộc hội thoại từ khách hàng thật
     */
    public function getAdminConversations(Request $request)
    {
        $allMessages = ChatMessage::with(['user', 'product'])->orderBy('created_at', 'asc')->get();

        // Nhóm theo user_id hoặc session_id
        $groups = [];
        foreach ($allMessages as $msg) {
            $key = $msg->user_id ? 'user_' . $msg->user_id : 'guest_' . $msg->session_id;
            if (!isset($groups[$key])) {
                $groups[$key] = [];
            }
            $groups[$key][] = $msg;
        }

        $conversations = [];
        foreach ($groups as $key => $msgs) {
            $lastMsg = end($msgs);
            $firstMsg = $msgs[0];

            $user = null;
            $customerName = $firstMsg->customer_name ?: 'Khách Hàng';
            $customerPhone = $firstMsg->customer_phone;
            $customerEmail = $firstMsg->customer_email;
            $avatarLetter = mb_substr($customerName, 0, 1, 'UTF-8');

            if ($firstMsg->user_id) {
                $user = User::find($firstMsg->user_id);
                if ($user) {
                    $customerName = $user->name;
                    $customerEmail = $user->email;
                    $customerPhone = $user->phone ?: $customerPhone;
                    $avatarLetter = mb_substr($user->name, 0, 1, 'UTF-8');
                }
            }

            // Tìm sản phẩm được hỏi gần nhất
            $productInfo = null;
            for ($i = count($msgs) - 1; $i >= 0; $i--) {
                if ($msgs[$i]->product) {
                    $prod = $msgs[$i]->product;
                    $productInfo = [
                        'id' => $prod->id,
                        'name' => $prod->name,
                        'price' => number_format($prod->price, 0, ',', '.') . ' ₫',
                        'image' => $prod->image,
                    ];
                    break;
                } elseif (!empty($msgs[$i]->product_name)) {
                    $productInfo = [
                        'id' => null,
                        'name' => $msgs[$i]->product_name,
                        'price' => 'Liên hệ tư vấn',
                        'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=160&auto=format&fit=crop&q=80',
                    ];
                    break;
                }
            }

            // Đếm số tin chưa đọc từ khách
            $unreadCount = 0;
            foreach ($msgs as $m) {
                if ($m->sender_type === 'customer' && !$m->is_read) {
                    $unreadCount++;
                }
            }

            $badge = $unreadCount > 0 ? 'Cần trả lời' : ($user ? 'Khách hàng' : 'Khách vãng lai');

            $conversations[] = [
                'id' => $key,
                'user_id' => $firstMsg->user_id,
                'name' => $customerName,
                'avatar' => $avatarLetter,
                'avatar_bg' => $firstMsg->user_id ? 'bg-blue-600' : 'bg-emerald-600',
                'phone' => $customerPhone ?: 'Chưa cập nhật',
                'email' => $customerEmail ?: 'Chưa cập nhật',
                'unread_count' => $unreadCount,
                'badge' => $badge,
                'product' => $productInfo,
                'preview' => $lastMsg->message,
                'time' => $lastMsg->created_at->format('H:i'),
                'updated_at' => $lastMsg->created_at->toIso8601String(),
            ];
        }

        // Sắp xếp các hội thoại có tin nhắn mới nhất lên đầu tiên
        usort($conversations, function ($a, $b) {
            return strcmp($b['updated_at'], $a['updated_at']);
        });

        return response()->json([
            'success' => true,
            'count' => count($conversations),
            'conversations' => $conversations,
        ]);
    }

    /**
     * Admin: Lấy toàn bộ tin nhắn của 1 khách hàng cụ thể & Đánh dấu đã đọc
     */
    public function getAdminMessages(Request $request)
    {
        $conversationKey = $request->input('conversation_id');
        if (!$conversationKey) {
            return response()->json(['success' => false, 'messages' => []]);
        }

        $query = ChatMessage::with(['user', 'product']);
        if (str_starts_with($conversationKey, 'user_')) {
            $userId = (int) substr($conversationKey, 5);
            $query->where('user_id', $userId);
        } else {
            $sessionId = substr($conversationKey, 6);
            $query->where('session_id', $sessionId);
        }

        $messages = $query->orderBy('created_at', 'asc')->get();

        // Đánh dấu tất cả tin nhắn của khách là đã đọc
        ChatMessage::where(function ($q) use ($conversationKey) {
            if (str_starts_with($conversationKey, 'user_')) {
                $q->where('user_id', (int) substr($conversationKey, 5));
            } else {
                $q->where('session_id', substr($conversationKey, 6));
            }
        })->where('sender_type', 'customer')->where('is_read', false)->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender_type,
                    'sender_name' => $msg->sender_name ?: ($msg->sender_type === 'admin' ? 'Shop Admin' : 'Khách Hàng'),
                    'text' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d/m/Y'),
                ];
            }),
        ]);
    }

    /**
     * Admin: Gửi tin nhắn phản hồi cho khách
     */
    public function sendAdminReply(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        $conversationKey = $request->input('conversation_id');
        $adminUser = Auth::user();
        $adminName = $adminUser ? $adminUser->name : 'Shop Admin';

        $userId = null;
        $sessionId = null;
        $customerName = 'Khách Hàng';
        $customerPhone = null;
        $customerEmail = null;

        if (str_starts_with($conversationKey, 'user_')) {
            $userId = (int) substr($conversationKey, 5);
            $targetUser = User::find($userId);
            if ($targetUser) {
                $customerName = $targetUser->name;
                $customerPhone = $targetUser->phone;
                $customerEmail = $targetUser->email;
            }
        } else {
            $sessionId = substr($conversationKey, 6);
            $lastCustomerMsg = ChatMessage::where('session_id', $sessionId)->first();
            if ($lastCustomerMsg) {
                $customerName = $lastCustomerMsg->customer_name;
            }
        }

        $chat = ChatMessage::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'sender_type' => 'admin',
            'sender_name' => $adminName,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'message' => trim($request->input('message')),
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'sender' => 'admin',
                'sender_name' => $adminName,
                'text' => $chat->message,
                'time' => $chat->created_at->format('H:i'),
                'date' => $chat->created_at->format('d/m/Y'),
            ],
        ]);
    }
}
