<!-- ========================================================================= -->
<!-- FLOATING LIVECHAT WIDGET (CHAT TRỰC TIẾP VỚI SHOP 24/7 QUA DATABASE THỰC)   -->
<!-- ========================================================================= -->
<div id="floating-livechat-container" class="fixed bottom-6 right-6 z-[9999] font-sans">
    
    <!-- 1. HỘP THOẠI CHAT POPUP (Mặc định ẩn, bấm nút tròn sẽ mở) -->
    <div id="livechat-popup" class="hidden mb-4 w-[340px] sm:w-[380px] h-[520px] bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden transition-all duration-300 transform scale-95 origin-bottom-right">
        
        <!-- Header hộp chat -->
        <div class="bg-gradient-to-r from-[#182234] via-[#1e293b] to-[#0f172a] text-white p-4 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-amber-500/20 border border-amber-400 text-amber-400 flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-headset text-base"></i>
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-[#182234]"></span>
                </div>
                <div>
                    <h4 class="font-bold text-sm text-white flex items-center gap-1.5">
                        <span>ChronoLux Live Support</span>
                        <span class="text-[9px] bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 px-1.5 py-0.5 rounded font-medium">Online</span>
                    </h4>
                    <p class="text-[10px] text-slate-300">
                        @auth
                            Xin chào, <strong class="text-amber-400">{{ Auth::user()->name }}</strong> (Đã kết nối)
                        @else
                            Tư vấn chọn đồng hồ & CSKH 24/7
                        @endauth
                    </p>
                </div>
            </div>
            <button type="button" onclick="toggleFloatingChat()" class="text-slate-400 hover:text-white text-base p-1 transition" title="Thu nhỏ">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Chọn nhanh chủ đề hỏi -->
        <div class="bg-slate-50 border-b border-slate-200 p-2.5 text-xs">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                <i class="fa-solid fa-bolt text-amber-500"></i> Chọn nhanh câu hỏi:
            </div>
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none">
                <button type="button" onclick="sendQuickClientMessage('Shop ơi, tư vấn giúp em mẫu Rolex Datejust 36mm với ạ!')" 
                    class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-300 text-slate-700 hover:border-amber-500 hover:text-amber-600 text-[11px] transition shadow-2xs">
                    ⌚ Rolex Datejust
                </button>
                <button type="button" onclick="sendQuickClientMessage('Mẫu đồng hồ bên mình có sẵn ở showroom không ạ?')" 
                    class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-300 text-slate-700 hover:border-amber-500 hover:text-amber-600 text-[11px] transition shadow-2xs">
                    🏬 Hàng có sẵn?
                </button>
                <button type="button" onclick="sendQuickClientMessage('Chính sách bảo hành và ship hàng thế nào shop?')" 
                    class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-300 text-slate-700 hover:border-amber-500 hover:text-amber-600 text-[11px] transition shadow-2xs">
                    🛡️ Bảo hành & Ship
                </button>
            </div>
        </div>

        <!-- Khung nội dung tin nhắn -->
        <div id="livechat-messages-container" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50/40 text-xs">
            <!-- Tin nhắn sẽ tải động từ Database -->
            <div id="livechat-loading-spinner" class="py-4 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-circle-notch fa-spin text-amber-500 mr-1.5"></i> Đang tải cuộc trò chuyện...
            </div>
        </div>

        <!-- Ô nhập tin nhắn & Nút gửi -->
        <div class="p-3 bg-white border-t border-slate-200">
            <form id="livechat-client-form" onsubmit="handleClientSendMessage(event)" class="flex items-center gap-2">
                <input type="text" id="livechat-client-input" placeholder="Nhập câu hỏi cần tư vấn..." required autocomplete="off"
                    class="flex-1 bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-amber-500 transition">
                <button type="submit" id="livechat-client-send-btn" class="w-9 h-9 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-xs transition shadow-xs flex-shrink-0">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>

    <!-- 2. NÚT TRÒN LIVE CHAT NỔI (LUÔN HIỆN Ở GÓC DƯỚI BÊN PHẢI) -->
    <div class="flex items-center justify-end">
        <button type="button" id="floating-livechat-btn" onclick="toggleFloatingChat()" 
            class="group relative w-14 h-14 rounded-full bg-gradient-to-tr from-[#182234] via-[#1e293b] to-amber-600 text-white flex items-center justify-center text-2xl shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 border-2 border-amber-400/40 cursor-pointer">
            
            <i id="floating-icon-chat" class="fa-solid fa-comments text-amber-400 group-hover:scale-110 transition"></i>
            <i id="floating-icon-close" class="fa-solid fa-xmark text-white hidden"></i>

            <!-- Chấm xanh Online nhấp nháy -->
            <span class="absolute top-0 right-0 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-white"></span>
            </span>

            <!-- Tooltip nổi bật khi hover -->
            <span class="absolute right-16 bg-[#182234] text-amber-300 text-xs font-semibold py-1.5 px-3 rounded-xl whitespace-nowrap shadow-xl border border-slate-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none hidden sm:block">
                💬 Chat trực tuyến với Shop
            </span>
        </button>
    </div>

</div>

<!-- SCRIPT ĐIỀU KHIỂN FLOATING LIVECHAT (KẾT NỐI DATABASE THỰC) -->
<script>
    let clientChatPollInterval = null;
    let lastClientLoadedCount = -1;
    let isClientChatOpen = false;

    function toggleFloatingChat() {
        const popup = document.getElementById('livechat-popup');
        const iconChat = document.getElementById('floating-icon-chat');
        const iconClose = document.getElementById('floating-icon-close');
        
        if (!popup) return;

        if (popup.classList.contains('hidden')) {
            popup.classList.remove('hidden');
            popup.classList.remove('scale-95');
            popup.classList.add('scale-100');
            if (iconChat) iconChat.classList.add('hidden');
            if (iconClose) iconClose.classList.remove('hidden');
            isClientChatOpen = true;
            
            loadClientLivechatMessages();
            startClientChatPolling();

            setTimeout(() => {
                document.getElementById('livechat-client-input')?.focus();
            }, 100);
        } else {
            popup.classList.add('hidden');
            popup.classList.add('scale-95');
            popup.classList.remove('scale-100');
            if (iconChat) iconChat.classList.remove('hidden');
            if (iconClose) iconClose.classList.add('hidden');
            isClientChatOpen = false;
        }
    }

    function startClientChatPolling() {
        if (clientChatPollInterval) clearInterval(clientChatPollInterval);
        clientChatPollInterval = setInterval(() => {
            if (isClientChatOpen) {
                loadClientLivechatMessages(true);
            }
        }, 2500);
    }

    function loadClientLivechatMessages(isSilent = false) {
        fetch('{{ route("livechat.client.messages") }}')
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                const container = document.getElementById('livechat-messages-container');
                if (!container) return;

                const messages = data.messages || [];
                const isDifferentCount = (messages.length !== lastClientLoadedCount);

                // Nếu chưa có tin nhắn nào trong DB
                if (messages.length === 0) {
                    if (!isSilent) {
                        container.innerHTML = `
                            <div class="flex items-start gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-[#182234] text-amber-400 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-slate-700">
                                    <i class="fa-solid fa-clock text-[11px]"></i>
                                </div>
                                <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-2xs max-w-[85%] space-y-1">
                                    <div class="font-bold text-[11px] text-[#182234]">Chuyên viên ChronoLux</div>
                                    <p class="leading-relaxed">
                                        Kính chào quý khách! ChronoLux rất hân hạnh được phục vụ. Quý khách đang quan tâm đến thương hiệu hoặc mẫu đồng hồ nào cần shop hỗ trợ ngay ạ?
                                    </p>
                                    <div class="text-[9px] text-slate-400 pt-0.5">Vừa xong</div>
                                </div>
                            </div>
                        `;
                    }
                    return;
                }

                if (isDifferentCount || !isSilent) {
                    lastClientLoadedCount = messages.length;
                    let html = `
                        <div class="flex items-start gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-[#182234] text-amber-400 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-slate-700">
                                <i class="fa-solid fa-clock text-[11px]"></i>
                            </div>
                            <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-2xs max-w-[85%] space-y-1">
                                <div class="font-bold text-[11px] text-[#182234]">Chuyên viên ChronoLux</div>
                                <p class="leading-relaxed">
                                    Kính chào quý khách! ChronoLux rất hân hạnh được phục vụ. Quý khách đang quan tâm đến mẫu đồng hồ nào cần shop hỗ trợ ngay ạ?
                                </p>
                                <div class="text-[9px] text-slate-400 pt-0.5">Hệ thống hỗ trợ 24/7</div>
                            </div>
                        </div>
                    `;

                    messages.forEach(msg => {
                        if (msg.sender === 'customer') {
                            html += `
                                <div class="flex items-start justify-end gap-2">
                                    <div class="bg-amber-500 text-slate-950 font-medium p-3 rounded-2xl rounded-tr-none shadow-xs max-w-[85%] space-y-0.5">
                                        <p class="leading-relaxed text-xs">${escapeClientHtml(msg.text)}</p>
                                        <div class="text-[9px] text-slate-800 text-right">${msg.time}</div>
                                    </div>
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-[#182234] text-amber-400 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-slate-700 shadow-2xs">
                                        A
                                    </div>
                                    <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none shadow-2xs max-w-[85%] space-y-1">
                                        <div class="font-bold text-[11px] text-[#182234] flex items-center justify-between">
                                            <span>${escapeClientHtml(msg.sender_name || 'Shop Admin')}</span>
                                            <span class="text-[9px] text-slate-400 font-normal">${msg.time}</span>
                                        </div>
                                        <p class="leading-relaxed">${escapeClientHtml(msg.text)}</p>
                                    </div>
                                </div>
                            `;
                        }
                    });

                    container.innerHTML = html;
                    container.scrollTop = container.scrollHeight;
                }
            })
            .catch(err => {
                console.error("Lỗi tải tin nhắn livechat:", err);
            });
    }

    function sendQuickClientMessage(text) {
        const input = document.getElementById('livechat-client-input');
        if (input) {
            input.value = text;
            handleClientSendMessage(new Event('submit'));
        }
    }

    function handleClientSendMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('livechat-client-input');
        if (!input || !input.value.trim()) return;

        const text = input.value.trim();
        input.value = '';

        const container = document.getElementById('livechat-messages-container');
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

        // Optimistic UI update
        if (container) {
            const tempMsgHtml = `
                <div class="flex items-start justify-end gap-2">
                    <div class="bg-amber-500 text-slate-950 font-medium p-3 rounded-2xl rounded-tr-none shadow-xs max-w-[85%] space-y-0.5">
                        <p class="leading-relaxed text-xs">${escapeClientHtml(text)}</p>
                        <div class="text-[9px] text-slate-800 text-right">${timeStr} <i class="fa-solid fa-check text-[8px]"></i></div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', tempMsgHtml);
            container.scrollTop = container.scrollHeight;
        }

        // Gửi qua API backend lưu vào database
        fetch('{{ route("livechat.client.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                message: text,
                product_id: window.currentWatchProductId || null
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.message) {
                clientLoadedMessageIds.add(res.message.id);
            }
            // Kích hoạt cập nhật Admin nếu đang mở cùng phiên
            if (typeof loadAdminConversations === 'function') {
                loadAdminConversations();
            }
        })
        .catch(err => {
            console.error("Lỗi gửi tin nhắn:", err);
        });
    }

    function escapeClientHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }
</script>
