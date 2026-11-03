<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Thanh Toán MoMo - MoMo Payment Gateway Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .momo-pink { background-color: #a50064; }
        .momo-pink-light { background-color: #d82d8b; }
        .text-momo { color: #a50064; }
        .border-momo { border-color: #a50064; }
    </style>
</head>
<body class="bg-[#f5f5f7] min-h-screen text-slate-800 flex flex-col justify-between font-sans">

    <!-- Header MoMo -->
    <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl momo-pink flex items-center justify-center text-white text-xl font-black shadow-md">
                    M
                </div>
                <div>
                    <div class="font-extrabold text-base tracking-wide flex items-center gap-2">
                        <span class="text-momo">MoMo</span> Payment Gateway
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            TEST SANDBOX
                        </span>
                    </div>
                    <div class="text-xs text-slate-500">Môi trường kiểm thử cổng thanh toán trực tuyến</div>
                </div>
            </div>

            <div class="text-right">
                <span class="text-xs text-slate-400 block">Thời gian thanh toán còn lại</span>
                <span id="countdown_timer" class="font-mono font-bold text-sm text-red-600">14:59</span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-4xl mx-auto px-4 py-6 w-full flex-1">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Cột trái: Tóm tắt đơn hàng -->
            <div class="md:col-span-5 bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Thông tin đơn hàng</h3>
                
                <div class="space-y-3 pb-4 border-b border-slate-100 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Mã đơn hàng:</span>
                        <span class="font-bold text-slate-800 font-mono">{{ $order->order_code ?? ('#' . $order->id) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Khách hàng:</span>
                        <span class="font-semibold text-slate-700">{{ $order->customer_name ?? $order->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Số điện thoại:</span>
                        <span class="font-semibold text-slate-700">{{ $order->customer_phone ?? $order->phone }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nhà cung cấp:</span>
                        <span class="font-bold text-slate-800">CHRONOLUX Haute Horlogerie</span>
                    </div>
                </div>

                <div class="pt-4 text-center bg-pink-50/50 rounded-xl p-4 mt-4 border border-pink-100">
                    <span class="text-xs text-slate-500 block mb-1">Số tiền cần thanh toán</span>
                    <span class="text-2xl font-black text-momo">
                        {{ number_format($transaction->amount ?: $order->total_amount, 0, ',', '.') }} đ
                    </span>
                </div>
            </div>

            <!-- Cột phải: Phương thức thanh toán (QR Code & Thẻ ATM) -->
            <div class="md:col-span-7 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <!-- Tab Chuyển đổi -->
                <div class="flex border-b border-slate-200 mb-5">
                    <button type="button" id="tab_atm" onclick="switchTab('atm')" 
                            class="flex-1 pb-3 font-bold text-sm text-momo border-b-2 border-momo transition">
                        <i class="fa-solid fa-credit-card mr-1.5"></i> Thẻ ATM Nội Địa
                    </button>
                    <button type="button" id="tab_qr" onclick="switchTab('qr')" 
                            class="flex-1 pb-3 font-bold text-sm text-slate-400 hover:text-slate-600 transition">
                        <i class="fa-solid fa-qrcode mr-1.5"></i> Quét QR MoMo
                    </button>
                </div>

                <!-- NỘI DUNG TAB 1: THẺ ATM NỘI ĐỊA (THEO BẢNG LAB 06) -->
                <div id="content_atm">
                    <!-- Form nhập thẻ ATM -->
                    <form action="{{ route('user.payment.momo.sandbox.process', $transaction->id) }}" method="POST" id="form_payment">
                        @csrf
                        <input type="hidden" name="action" id="input_action" value="success">

                        <div class="space-y-3.5 mb-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Ngân hàng phát hành thẻ</label>
                                <select class="w-full text-sm border border-slate-300 rounded-lg p-2.5 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-pink-500 font-medium">
                                    <option>Napas - Ngân hàng TMCP Ngoại Thương VN (VCB)</option>
                                    <option>Napas - Techcombank</option>
                                    <option>Napas - MBBank</option>
                                    <option>Napas - VietinBank</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Số thẻ ATM *</label>
                                <input type="text" name="card_number" id="card_number" required 
                                       value="9704 0000 0000 0018"
                                       placeholder="9704 xxxx xxxx xxxx" 
                                       class="w-full text-sm font-mono font-bold tracking-wider border border-slate-300 rounded-lg p-2.5 focus:border-momo focus:ring-1 focus:ring-momo outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tên in trên thẻ *</label>
                                    <input type="text" name="card_holder" id="card_holder" value="NGUYEN VAN A" required 
                                           class="w-full text-sm uppercase font-bold border border-slate-300 rounded-lg p-2.5 focus:border-momo focus:ring-1 focus:ring-momo outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Ngày phát hành *</label>
                                    <input type="text" name="expiry_date" value="12/30" placeholder="MM/YY" required 
                                           class="w-full text-sm font-bold border border-slate-300 rounded-lg p-2.5 focus:border-momo focus:ring-1 focus:ring-momo outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Mã xác thực OTP</label>
                                <input type="text" name="otp" value="000000" placeholder="000000" maxlength="6" 
                                       class="w-full text-sm font-mono font-bold tracking-widest text-center border border-slate-300 rounded-lg p-2.5 focus:border-momo focus:ring-1 focus:ring-momo outline-none">
                            </div>
                        </div>



                        <!-- Hành động submit -->
                        <div class="flex items-center gap-3">
                            <button type="submit" 
                                    class="flex-1 py-3 px-4 rounded-xl momo-pink hover:bg-[#880052] text-white font-bold text-sm shadow-md transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-shield-halved"></i> Xác Nhận Thanh Toán
                            </button>
                            <button type="button" onclick="cancelPayment()" 
                                    class="py-3 px-4 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 font-semibold text-sm transition">
                                Hủy giao dịch
                            </button>
                        </div>
                    </form>
                </div>

                <!-- NỘI DUNG TAB 2: QUÉT MÃ QR MOMO -->
                <div id="content_qr" class="hidden text-center py-4">
                    <p class="text-xs text-slate-500 mb-3">Mở ứng dụng MoMo trên điện thoại hoặc bấm nút xác nhận bên dưới</p>
                    
                    <div class="inline-block p-4 bg-white rounded-2xl border-2 border-dashed border-pink-300 shadow-md mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=2|99|0985507253|CHRONOLUX|{{ $order->id }}|0|0|{{ (int)($transaction->amount ?: $order->total_amount) }}|Thanh toan don hang {{ $order->order_code }}" 
                             alt="MoMo QR" class="w-44 h-44 mx-auto rounded-lg">
                    </div>

                    <div class="max-w-xs mx-auto space-y-2">
                        <form action="{{ route('user.payment.momo.sandbox.process', $transaction->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="action" value="success">
                            <input type="hidden" name="card_number" value="9704 0000 0000 0018">
                            <button type="submit" 
                                    class="w-full py-2.5 px-4 rounded-xl momo-pink hover:bg-[#880052] text-white font-bold text-sm shadow transition">
                                <i class="fa-solid fa-check-circle mr-1"></i> Giả Lập Quét Mã Thành Công
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200 bg-white">
        &copy; {{ date('Y') }} Cổng thanh toán trực tuyến MoMo &middot; Kết nối bảo mật tự động
    </footer>

    <!-- Script xử lý chuyển tab và chọn thẻ -->
    <script>
        function switchTab(tab) {
            const tabAtm = document.getElementById('tab_atm');
            const tabQr = document.getElementById('tab_qr');
            const contentAtm = document.getElementById('content_atm');
            const contentQr = document.getElementById('content_qr');

            if (tab === 'atm') {
                tabAtm.className = 'flex-1 pb-3 font-bold text-sm text-momo border-b-2 border-momo transition';
                tabQr.className = 'flex-1 pb-3 font-bold text-sm text-slate-400 hover:text-slate-600 transition';
                contentAtm.classList.remove('hidden');
                contentQr.classList.add('hidden');
            } else {
                tabQr.className = 'flex-1 pb-3 font-bold text-sm text-momo border-b-2 border-momo transition';
                tabAtm.className = 'flex-1 pb-3 font-bold text-sm text-slate-400 hover:text-slate-600 transition';
                contentQr.classList.remove('hidden');
                contentAtm.classList.add('hidden');
            }
        }

        function selectCard(number, action) {
            document.getElementById('card_number').value = number;
            document.getElementById('input_action').value = (action === 'success') ? 'success' : 'fail';
        }

        function cancelPayment() {
            if (confirm('Bạn có chắc muốn hủy phiên thanh toán MoMo này?')) {
                document.getElementById('input_action').value = 'cancel';
                document.getElementById('form_payment').submit();
            }
        }

        // Đếm ngược thời gian giả lập
        let seconds = 899;
        const timerEl = document.getElementById('countdown_timer');
        setInterval(() => {
            if (seconds > 0) {
                seconds--;
                const m = String(Math.floor(seconds / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                timerEl.innerText = `${m}:${s}`;
            }
        }, 1000);
    </script>
</body>
</html>
