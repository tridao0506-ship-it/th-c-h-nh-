<!-- ========================================================================= -->
<!-- SHOP ADMIN EMBEDDED COMPONENT (KHỚP CHUẨN XÁC ẢNH GIAO DIỆN ADMIN ĐƠN GIẢN) -->
<!-- ========================================================================= -->
@php
    $activeTab = $adminTab ?? 'orders';
@endphp

<div class="bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[780px]">
    
    <!-- 1. LEFT SIDEBAR (Dark Navy #182234 matching reference image) -->
    <aside class="w-full md:w-64 bg-[#182234] border-r border-slate-800/90 flex flex-col justify-between flex-shrink-0 select-none text-slate-100">
        <div>
            <!-- Header: Yellow Clock Icon + QUẢN LÝ ĐỒNG HỒ / SHOP ADMIN + Hamburger Icon -->
            <div class="px-5 py-4 border-b border-slate-700/60 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-clock text-yellow-400 text-xl"></i>
                    <div>
                        <span class="font-bold text-white text-base tracking-wider font-sans whitespace-nowrap block leading-tight">QUẢN LÝ ĐỒNG HỒ</span>
                        <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-widest">SHOP ADMIN</span>
                    </div>
                </div>
                <button type="button" class="text-slate-400 hover:text-white p-1 rounded focus:outline-none" title="Menu quản trị">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Profile Info: Chào, Administrator matching screenshot -->
            <div class="px-5 py-3 border-b border-slate-700/60 flex items-center gap-2.5 text-xs text-yellow-400 font-medium">
                <i class="fa-solid fa-user text-yellow-400 text-sm"></i>
                <span>Chào, Administrator</span>
            </div>

            <!-- Menu Navigation Items matching reference order -->
            <nav class="py-2 text-sm font-medium space-y-0.5">
                
                <!-- 1. Tổng quan -->
                <button type="button" onclick="switchAdminTab('dashboard')" id="nav-btn-dashboard"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'dashboard' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-base {{ $activeTab === 'dashboard' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Tổng quan</span>
                </button>

                <!-- 2. Báo cáo doanh thu -->
                <button type="button" onclick="switchAdminTab('finance')" id="nav-btn-finance"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'finance' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-chart-line w-5 text-center text-base {{ $activeTab === 'finance' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Báo cáo doanh thu</span>
                </button>

                <!-- 3. Danh mục -->
                <button type="button" onclick="switchAdminTab('categories')" id="nav-btn-categories"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'categories' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-layer-group w-5 text-center text-base {{ $activeTab === 'categories' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Danh mục</span>
                </button>

                <!-- 4. Sản phẩm -->
                <button type="button" onclick="switchAdminTab('products')" id="nav-btn-products"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'products' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-clock w-5 text-center text-base {{ $activeTab === 'products' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Sản phẩm</span>
                </button>

                <!-- 5. Đơn hàng (ACTIVE MẶC ĐỊNH KHỚP ẢNH MẪU CỦA BẠN) -->
                <button type="button" onclick="switchAdminTab('orders')" id="nav-btn-orders"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'orders' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-receipt w-5 text-center text-base {{ $activeTab === 'orders' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Đơn hàng</span>
                </button>

                <!-- 6. Người dùng -->
                <button type="button" onclick="switchAdminTab('users')" id="nav-btn-users"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'users' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-user-group w-5 text-center text-base {{ $activeTab === 'users' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Người dùng</span>
                </button>

                <!-- 7. Tin nhắn Livechat -->
                <button type="button" onclick="switchAdminTab('livechat')" id="nav-btn-livechat"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'livechat' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-comments w-5 text-center text-base {{ $activeTab === 'livechat' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Tin nhắn Livechat</span>
                </button>

                <!-- 8. Giao dịch thanh toán COD -->
                <button type="button" onclick="switchAdminTab('transactions')" id="nav-btn-transactions"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'transactions' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-money-bill-wave w-5 text-center text-base {{ $activeTab === 'transactions' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Giao dịch COD</span>
                </button>

                <!-- 9. Báo cáo hoạt động -->
                <button type="button" onclick="switchAdminTab('reports')" id="nav-btn-reports"
                        class="admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ $activeTab === 'reports' ? 'border-cyan-400 bg-slate-800 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }} text-left">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base {{ $activeTab === 'reports' ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span>Báo cáo</span>
                </button>

            </nav>
        </div>

    </aside>

    <!-- 2. RIGHT MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 bg-white text-slate-800">
        
        <!-- Header phụ của Admin -->
        <div class="h-14 border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between bg-white sticky top-0 z-10">
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                <span>Quản trị SHOP</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-900 font-bold" id="admin-current-tab-title">Xử Lý & Quản Lý Đơn Hàng</span>
            </div>
        </div>

        <div class="p-6 sm:p-8 flex-1 bg-white space-y-6">
            
            <!-- ============================================================= -->
            <!-- TAB: XỬ LÝ & QUẢN LÝ ĐƠN HÀNG (KHỚP 100% ẢNH MẪU USER GỬI)   -->
            <!-- ============================================================= -->
            <div id="tab-content-orders" class="admin-tab-pane space-y-5 {{ $activeTab === 'orders' ? '' : 'hidden' }}">
                
                <!-- 1. Header Đơn hàng -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-500 flex items-center justify-center text-xl flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Xử Lý & Quản Lý Đơn Hàng</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Theo dõi chỉ số giá trị, chuyển trạng thái và quản lý hủy đơn theo quy tắc chuẩn</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 text-white text-xs font-bold shadow-sm">
                            <i class="fa-solid fa-bag-shopping text-amber-400"></i>
                            <span>Tổng cộng: {{ $totalOrders }} đơn</span>
                        </span>
                    </div>
                </div>

                <!-- 2. 4 Thẻ Thống Kê Chỉ Số Chuẩn Ảnh Mẫu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1: DOANH THU ĐÃ THU (Xanh lá) -->
                    <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 p-4 shadow-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">DOANH THU ĐÃ THU</span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">Đã bảo đảm</span>
                        </div>
                        <div class="text-xl font-black text-emerald-600 pt-1">
                            {{ number_format($paidRevenue, 0, ',', '.') }} VNĐ
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Từ {{ $statusCounts['completed'] }} đơn đã hoàn thành
                        </div>
                    </div>

                    <!-- Card 2: CẦN XỬ LÝ / ĐÓNG GÓI (Vàng cam) -->
                    <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-amber-400 p-4 shadow-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">CẦN XỬ LÝ / ĐÓNG GÓI</span>
                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">🟡 Chờ duyệt/Hủy</span>
                        </div>
                        <div class="text-xl font-black text-slate-900 pt-1">
                            {{ $statusCounts['pending'] + $statusCounts['processing'] }} đơn
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Giá trị: <strong class="text-slate-700 font-semibold">{{ number_format($pendingValue, 0, ',', '.') }} VNĐ</strong>
                        </div>
                    </div>

                    <!-- Card 3: ĐANG VẬN CHUYỂN (Xanh ngọc / Cyan) -->
                    <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-cyan-400 p-4 shadow-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">ĐANG VẬN CHUYỂN</span>
                            <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold">🔒 Không cho hủy</span>
                        </div>
                        <div class="text-xl font-black text-slate-900 pt-1">
                            {{ $statusCounts['shipping'] }} đơn
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Giá trị: <strong class="text-slate-700 font-semibold">{{ number_format($shippingValue, 0, ',', '.') }} VNĐ</strong> (GHN giao hàng)
                        </div>
                    </div>

                    <!-- Card 4: KẾT QUẢ ĐƠN HÀNG (Xám slate) -->
                    <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-slate-400 p-4 shadow-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">KẾT QUẢ ĐƠN HÀNG</span>
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">Tổng: {{ $totalOrders }}</span>
                        </div>
                        <div class="flex items-center gap-3 pt-2 text-xs font-bold">
                            <div class="flex items-center gap-1.5 text-emerald-600">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>{{ $statusCounts['completed'] }} Hoàn thành</span>
                            </div>
                            <div class="h-4 w-px bg-slate-200"></div>
                            <div class="flex items-center gap-1.5 text-rose-600">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>{{ $statusCounts['cancelled'] }} Đã hủy đơn</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. Thanh Nút Lọc Trạng Thái Nhanh (Pills) -->
                @php
                    $currSt = request('order_status', 'all');
                @endphp
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold whitespace-nowrap">
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=all#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'all' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Tất cả ({{ $statusCounts['all'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=pending#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'pending' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Chờ xử lý ({{ $statusCounts['pending'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=paid#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'paid' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Đã thanh toán ({{ $statusCounts['paid'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=processing#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'processing' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Đang đóng gói ({{ $statusCounts['processing'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=shipping#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'shipping' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Đang giao hàng ({{ $statusCounts['shipping'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=completed#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'completed' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Hoàn thành ({{ $statusCounts['completed'] }})
                    </a>
                    <a href="{{ url('/?view=admin&admin_tab=orders&order_status=cancelled#admin-section') }}" 
                       class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'cancelled' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                        Đã hủy ({{ $statusCounts['cancelled'] }})
                    </a>
                </div>

                <!-- 4. Thanh Tìm Kiếm & Bộ Lọc Nâng Cao -->
                <form action="{{ url('/#admin-section') }}" method="GET" class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 flex flex-wrap items-center gap-3 text-xs">
                    <input type="hidden" name="view" value="admin">
                    <input type="hidden" name="admin_tab" value="orders">

                    <!-- Lọc theo Trạng Thái -->
                    <div class="flex items-center gap-2">
                        <label class="font-bold text-slate-700 whitespace-nowrap">Lọc theo Trạng Thái:</label>
                        <select name="order_status" class="border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
                            <option value="all" {{ request('order_status') == 'all' ? 'selected' : '' }}>-- Tất cả trạng thái --</option>
                            <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="paid" {{ request('order_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Đang đóng gói</option>
                            <option value="shipping" {{ request('order_status') == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="completed" {{ request('order_status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <!-- Hình thức Thanh toán -->
                    <div class="flex items-center gap-2">
                        <label class="font-bold text-slate-700 whitespace-nowrap">Hình thức Thanh toán:</label>
                        <select name="payment_method" class="border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
                            <option value="all" {{ request('payment_method') == 'all' ? 'selected' : '' }}>-- Tất cả phương thức --</option>
                            <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>MoMo</option>
                            <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Tiền mặt khi nhận hàng (COD)</option>
                            <option value="banking" {{ request('payment_method') == 'banking' ? 'selected' : '' }}>Chuyển khoản (Banking)</option>
                        </select>
                    </div>

                    <!-- Tìm kiếm đơn hàng -->
                    <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                        <label class="font-bold text-slate-700 whitespace-nowrap">Tìm kiếm đơn hàng:</label>
                        <div class="relative flex-1">
                            <input type="text" name="order_q" value="{{ request('order_q') }}" placeholder="🔍 Mã #DH, tên khách, SĐT, email..." 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
                        </div>
                    </div>

                    <!-- Nút Lọc & Xóa -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-1.5 bg-slate-900 hover:bg-black text-white font-bold rounded-lg transition shadow-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-filter text-amber-400"></i>
                            <span>Lọc</span>
                        </button>
                        @if(request('order_status') || request('payment_method') || request('order_q'))
                            <a href="{{ url('/?view=admin&admin_tab=orders#admin-section') }}" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 text-slate-600 font-semibold rounded-lg transition">
                                Xóa lọc
                            </a>
                        @endif
                    </div>
                </form>

                <!-- 5. Bảng Danh Sách Đơn Hàng (Header Xanh Đen #182234 Chuẩn Ảnh Mẫu) -->
                <div class="overflow-x-auto border border-slate-200 rounded-2xl shadow-sm bg-white">
                    <table class="w-full text-xs text-left text-slate-700 min-w-[880px] border-collapse">
                        <thead class="bg-[#182234] text-white uppercase text-[11px] tracking-wider font-bold">
                            <tr>
                                <th class="py-2.5 px-3.5">MÃ ĐƠN</th>
                                <th class="py-2.5 px-3.5">KHÁCH HÀNG</th>
                                <th class="py-2.5 px-3.5">SẢN PHẨM & ĐỊA CHỈ</th>
                                <th class="py-2.5 px-3.5">TỔNG TIỀN</th>
                                <th class="py-2.5 px-3.5 text-center">TRẠNG THÁI</th>
                                <th class="py-2.5 px-3.5 text-center">CHUYỂN TRẠNG THÁI</th>
                                <th class="py-2.5 px-3.5 text-center">XỬ LÝ / THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($adminOrders as $ord)
                                <tr class="hover:bg-slate-50/80 transition">
                                    
                                    <!-- 1. MÃ ĐƠN -->
                                    <td class="py-2.5 px-3.5 align-top whitespace-nowrap">
                                        <div class="font-bold text-slate-900 text-xs">{{ $ord->order_code }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">{{ $ord->created_at->format('d/m/Y H:i') }}</div>
                                    </td>

                                    <!-- 2. KHÁCH HÀNG -->
                                    <td class="py-2.5 px-3.5 align-top">
                                        <div class="font-bold text-slate-900">{{ $ord->customer_name }}</div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5 whitespace-nowrap">
                                            <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                            <span>{{ $ord->customer_phone }}</span>
                                        </div>
                                        @if($ord->customer_email)
                                            <div class="text-[10px] text-slate-400 flex items-center gap-1 mt-0.5 truncate max-w-[150px]">
                                                <i class="fa-regular fa-envelope text-[10px]"></i>
                                                <span>{{ $ord->customer_email }}</span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- 3. SẢN PHẨM & ĐỊA CHỈ -->
                                    <td class="py-2.5 px-3.5 align-top max-w-xs">
                                        <div class="flex items-start gap-1.5 text-slate-900 font-medium text-xs">
                                            <span class="w-4 h-4 rounded-full bg-amber-400 text-slate-950 inline-flex items-center justify-center text-[9px] mt-0.5 flex-shrink-0 shadow-xs"><i class="fa-solid fa-clock text-[8px]"></i></span>
                                            <div class="space-y-0.5 min-w-0">
                                                @if($ord->items->isNotEmpty())
                                                    @foreach($ord->items as $it)
                                                        <div class="line-clamp-1 font-semibold text-slate-800">{{ $it->product_name }} <span class="font-bold text-slate-600">x{{ $it->quantity }}</span></div>
                                                    @endforeach
                                                @else
                                                    <div class="line-clamp-1 font-semibold text-slate-800">Đồng hồ ChronoLux cao cấp</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-1.5 text-[11px] text-slate-500 mt-1">
                                            <i class="fa-solid fa-location-dot text-rose-500 mt-0.5 flex-shrink-0"></i>
                                            <span class="line-clamp-1">{{ $ord->shipping_address ?? 'Số 7 Phú Diễn, Phường Phúc Diễn, Hà Nội' }}</span>
                                        </div>
                                    </td>

                                    <!-- 4. TỔNG TIỀN -->
                                    <td class="py-2.5 px-3.5 align-top whitespace-nowrap">
                                        <div class="font-black text-slate-900 text-xs">
                                            {{ number_format($ord->total_amount, 0, ',', '.') }} VNĐ
                                        </div>
                                        <div class="mt-1">
                                            @if($ord->payment_method === 'momo')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#a50064] text-white shadow-2xs">
                                                    MoMo
                                                </span>
                                            @elseif($ord->payment_method === 'banking')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white shadow-2xs">
                                                    BANKING
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white shadow-2xs">
                                                    COD
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- 5. TRẠNG THÁI -->
                                    <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                                        @if($ord->order_status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-2xs">
                                                Hoàn thành
                                            </span>
                                        @elseif($ord->order_status === 'shipping')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500 text-white shadow-2xs">
                                                Đang giao hàng
                                            </span>
                                        @elseif($ord->order_status === 'processing')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white shadow-2xs">
                                                Đang đóng gói
                                            </span>
                                        @elseif($ord->order_status === 'cancelled')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500 text-white shadow-2xs">
                                                Đã hủy
                                            </span>
                                        @elseif($ord->payment_status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-500 text-white shadow-2xs">
                                                Đã thanh toán
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300 shadow-2xs">
                                                Chờ xử lý
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 6. CHUYỂN TRẠNG THÁI (Dropdown tức thì) -->
                                    <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                                        <form action="{{ route('admin.orders.status', $ord->id) }}" method="POST">
                                            @csrf
                                            <select name="order_status" onchange="this.form.submit()" 
                                                    class="border border-slate-300 rounded-lg px-2.5 py-1 text-xs text-slate-700 bg-white focus:outline-none focus:border-blue-500 cursor-pointer shadow-2xs">
                                                <option value="pending" {{ $ord->order_status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                                <option value="paid" {{ $ord->payment_status === 'paid' && $ord->order_status !== 'completed' ? 'selected' : '' }}>Đã thanh toán</option>
                                                <option value="processing" {{ $ord->order_status === 'processing' ? 'selected' : '' }}>Đang đóng gói</option>
                                                <option value="shipping" {{ $ord->order_status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                                <option value="completed" {{ $ord->order_status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                                <option value="cancelled" {{ $ord->order_status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </form>
                                    </td>

                                    <!-- 7. XỬ LÝ / THAO TÁC (Nút Chi tiết & Nút Hủy) -->
                                    <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Nút Chi Tiết -->
                                            <button type="button" 
                                                    onclick="showOrderDetailModal('{{ $ord->order_code }}', '{{ addslashes($ord->customer_name) }}', '{{ $ord->customer_phone }}', '{{ addslashes($ord->customer_email ?? '') }}', '{{ addslashes($ord->shipping_address ?? 'Hà Nội') }}', '{{ number_format($ord->total_amount, 0, ',', '.') }} VNĐ', '{{ strtoupper($ord->payment_method) }}', '{{ $ord->order_status }}', '{{ $ord->created_at->format('d/m/Y H:i') }}', '{{ addslashes($ord->notes ?? 'Không có ghi chú') }}', '{{ number_format($ord->shipping_fee, 0, ',', '.') }} VNĐ', '{{ $ord->shipping_distance ? $ord->shipping_distance . ' km' : 'Khoảng 15 km' }}', '{{ $ord->ghn_order_code ?? 'Đang cập nhật' }}')"
                                                    class="px-3 py-1 rounded-full border border-blue-400 text-blue-600 hover:bg-blue-50 font-medium text-xs flex items-center gap-1 transition shadow-2xs">
                                                <i class="fa-regular fa-eye"></i>
                                                <span>Chi tiết</span>
                                            </button>

                                            <!-- Nút Hủy Đơn -->
                                            @if($ord->order_status !== 'cancelled' && $ord->order_status !== 'shipping' && $ord->order_status !== 'completed')
                                                <form action="{{ route('admin.orders.cancel', $ord->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng {{ $ord->order_code }}?');">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 rounded-full border border-rose-300 text-rose-500 hover:bg-rose-50 font-medium text-xs flex items-center gap-1 transition shadow-2xs">
                                                        <i class="fa-solid fa-xmark"></i>
                                                        <span>Hủy</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-2 py-1 text-slate-300 text-xs">-</span>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400">
                                        Không tìm thấy đơn hàng nào phù hợp với bộ lọc.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PHÂN TRANG (PAGINATION) GỌN GÀNG, VỪA VẶN THEO YÊU CẦU -->
                @if($adminOrders instanceof \Illuminate\Pagination\LengthAwarePaginator && $adminOrders->hasPages())
                    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200 text-xs shadow-xs">
                        <div class="text-slate-500">
                            Hiển thị <span class="font-bold text-slate-800">{{ $adminOrders->firstItem() }}</span> - <span class="font-bold text-slate-800">{{ $adminOrders->lastItem() }}</span> trên tổng số <span class="font-bold text-slate-800">{{ $adminOrders->total() }}</span> đơn hàng
                        </div>
                        <div class="flex items-center gap-1.5 flex-wrap">
                            {{-- Nút trang trước --}}
                            @if ($adminOrders->onFirstPage())
                                <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Trước
                                </span>
                            @else
                                <a href="{{ $adminOrders->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium transition shadow-2xs text-xs flex items-center gap-1">
                                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Trước
                                </a>
                            @endif

                            {{-- Các số trang --}}
                            @foreach ($adminOrders->getUrlRange(1, $adminOrders->lastPage()) as $page => $url)
                                @if ($page == $adminOrders->currentPage())
                                    <span class="w-8 h-8 rounded-lg bg-[#182234] text-white font-bold flex items-center justify-center shadow-xs text-xs">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium flex items-center justify-center transition shadow-2xs text-xs">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Nút trang sau --}}
                            @if ($adminOrders->hasMorePages())
                                <a href="{{ $adminOrders->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium transition shadow-2xs text-xs flex items-center gap-1">
                                    Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @else
                                <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1">
                                    Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            <!-- ============================================================= -->
            <!-- TAB 1: TỔNG QUAN DASHBOARD                                    -->
            <!-- ============================================================= -->
            <div id="tab-content-dashboard" class="admin-tab-pane space-y-6 {{ $activeTab === 'dashboard' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200">
                        <div class="text-xs font-bold text-amber-800 uppercase tracking-wider">Tổng Doanh Thu</div>
                        <div class="text-2xl font-black text-amber-600 mt-2">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</div>
                        <div class="text-[11px] text-amber-700 mt-1">Từ {{ $totalOrders }} đơn hàng</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-blue-50 border border-blue-200">
                        <div class="text-xs font-bold text-blue-800 uppercase tracking-wider">Tổng Đơn Hàng</div>
                        <div class="text-2xl font-black text-blue-600 mt-2">{{ $totalOrders }}</div>
                        <div class="text-[11px] text-blue-700 mt-1">{{ $statusCounts['pending'] }} đơn chờ duyệt</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-purple-50 border border-purple-200">
                        <div class="text-xs font-bold text-purple-800 uppercase tracking-wider">Sản Phẩm Trong Kho</div>
                        <div class="text-2xl font-black text-purple-600 mt-2">{{ $totalProducts }}</div>
                        <div class="text-[11px] text-purple-700 mt-1">{{ $categories->count() }} thương hiệu</div>
                    </div>
                    <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200">
                        <div class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Tài Khoản Thành Viên</div>
                        <div class="text-2xl font-black text-emerald-600 mt-2">{{ $adminTotalUsers }}</div>
                        <div class="text-[11px] text-emerald-700 mt-1">{{ $adminRoleCount }} Quản trị | {{ $customerRoleCount }} Khách</div>
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- BỐ CỤC 2 CỘT 70/30 THEO ĐÚNG MẪU THIẾT KẾ (ẢNH 2)            -->
                <!-- Cột trái (70%): Biểu đồ thống kê trực quan + Cảnh báo hệ thống-->
                <!-- Cột phải (30%): Đơn hàng mới nhất + Top sản phẩm bán chạy     -->
                <!-- ============================================================= -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-6">
                    
                    <!-- CỘT TRÁI (KHOẢNG 70% ~ lg:col-span-8) -->
                    <div class="lg:col-span-8 space-y-6">
                        
                        <!-- 1. BIỂU ĐỒ THỐNG KÊ DOANH THU & ĐƠN HÀNG (Chuẩn Ảnh 2) -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <i class="fa-solid fa-chart-line text-amber-500"></i>
                                    THỐNG KÊ DOANH THU & ĐƠN HÀNG
                                </h3>
                                
                                <!-- Legend chú thích khớp mẫu ảnh: Doanh thu (tỷ VNĐ) & Số lượng đơn hàng -->
                                <div class="flex items-center gap-4 text-xs font-semibold">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-3.5 h-3.5 rounded bg-amber-500 inline-block shadow-xs"></span>
                                        <span class="text-slate-700">Doanh thu (tỷ VNĐ)</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-3.5 h-3.5 rounded bg-blue-600 inline-block shadow-xs"></span>
                                        <span class="text-slate-700">Số lượng đơn hàng</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Canvas Biểu đồ đường (Line Chart) đường cong mượt mà -->
                            <div class="relative w-full h-[330px]">
                                <canvas id="dashboardRevenueOrderChart"></canvas>
                            </div>

                            <!-- Bộ lọc thời gian khớp mẫu ảnh 2: [ 7 ngày qua ] [ Tháng này ] [ Năm nay ] -->
                            <div class="flex flex-wrap items-center gap-2 pt-4 mt-3 border-t border-slate-100">
                                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider mr-2">THỜI GIAN:</span>
                                <button type="button" id="btn-period-7days" onclick="updateDashboardPeriod('7days')" 
                                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition shadow-xs bg-blue-100 text-blue-700 border border-blue-300">
                                    7 ngày qua
                                </button>
                                <button type="button" id="btn-period-month" onclick="updateDashboardPeriod('month')" 
                                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition">
                                    Tháng này
                                </button>
                                <button type="button" id="btn-period-year" onclick="updateDashboardPeriod('year')" 
                                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition">
                                    Năm nay
                                </button>
                            </div>
                        </div>

                        <!-- 2. CẢNH BÁO HỆ THỐNG & NHẮC VIỆC (Theo đúng yêu cầu của người dùng) -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                                    CẢNH BÁO HỆ THỐNG & NHẮC VIỆC QUAN TRỌNG
                                </h3>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ $lowStockProducts->count() }} sản phẩm cần chú ý
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Khối cảnh báo kho -->
                                <div class="p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80 space-y-2.5">
                                    <div class="flex items-center justify-between text-xs font-bold text-amber-800">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-boxes-stacked text-amber-600"></i>
                                            Đồng hồ sắp hết hàng (kho ≤ 5)
                                        </span>
                                        <button type="button" onclick="switchAdminTab('products')" class="text-[11px] text-blue-600 hover:underline">
                                            Quản lý kho →
                                        </button>
                                    </div>
                                    @if($lowStockProducts->isEmpty())
                                        <div class="text-xs text-slate-500 py-2">
                                            Kho hàng ổn định, không có sản phẩm nào sắp hết hàng.
                                        </div>
                                    @else
                                        <div class="space-y-1.5">
                                            @foreach($lowStockProducts->take(3) as $lsp)
                                                <div class="flex items-center justify-between text-xs bg-white p-2 rounded-lg border border-amber-100 shadow-2xs">
                                                    <div class="truncate max-w-[210px] font-medium text-slate-800" title="{{ $lsp->name }}">
                                                        {{ $lsp->name }}
                                                    </div>
                                                    <span class="font-bold {{ $lsp->stock == 0 ? 'text-red-600' : 'text-amber-600' }} text-[11px] whitespace-nowrap">
                                                        {{ $lsp->stock == 0 ? 'Hết hàng' : 'Còn ' . $lsp->stock . ' chiếc' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <!-- Khối nhắc việc đơn hàng & Livechat -->
                                <div class="p-3.5 rounded-xl bg-blue-50/60 border border-blue-200/80 space-y-2.5">
                                    <div class="flex items-center justify-between text-xs font-bold text-blue-800">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-bell text-blue-600"></i>
                                            Nhiệm vụ cần xử lý ngay
                                        </span>
                                    </div>
                                    <div class="space-y-2">
                                        <!-- Đơn hàng cần xử lý -->
                                        <div class="flex items-center justify-between text-xs bg-white p-2.5 rounded-lg border border-blue-100 shadow-2xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                <span class="text-slate-700">Đơn chờ xử lý / đóng gói:</span>
                                            </div>
                                            <button type="button" onclick="switchAdminTab('orders')" class="font-bold text-blue-600 hover:underline">
                                                {{ $statusCounts['pending'] + $statusCounts['processing'] }} đơn →
                                            </button>
                                        </div>
                                        <!-- Tin nhắn Livechat -->
                                        <div class="flex items-center justify-between text-xs bg-white p-2.5 rounded-lg border border-blue-100 shadow-2xs">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                                <span class="text-slate-700">Tin nhắn khách hàng:</span>
                                            </div>
                                            <button type="button" onclick="switchAdminTab('livechat')" class="font-bold text-blue-600 hover:underline">
                                                {{ $unreadLivechatCount ?? 0 }} tin nhắn →
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- CỘT PHẢI (KHOẢNG 30% ~ lg:col-span-4) -->
                    <div class="lg:col-span-4 space-y-6">
                        
                        <!-- 1. ĐƠN HÀNG MỚI NHẤT (Chuẩn Ảnh 2) -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-3">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <i class="fa-solid fa-receipt text-blue-600"></i>
                                    ĐƠN HÀNG MỚI NHẤT
                                </h3>
                                <button type="button" onclick="switchAdminTab('orders')" class="text-xs text-blue-600 hover:underline font-medium">
                                    Xem tất cả →
                                </button>
                            </div>

                            <div class="space-y-3">
                                @php
                                    $recentOrdersList = $dashboardRecentOrders ?? $recentOrders ?? [];
                                @endphp

                                @forelse($recentOrdersList as $rOrder)
                                    @php
                                        $diffMins = now()->diffInMinutes($rOrder->created_at);
                                        if ($diffMins < 1) {
                                            $timeStr = 'Vừa xong';
                                        } elseif ($diffMins < 60) {
                                            $timeStr = $diffMins . ' phút trước';
                                        } elseif ($diffMins < 1440) {
                                            $timeStr = floor($diffMins / 60) . ' giờ trước';
                                        } else {
                                            $timeStr = floor($diffMins / 1440) . ' ngày trước';
                                        }

                                        $isPaid = ($rOrder->payment_status === 'paid' || $rOrder->order_status === 'completed');
                                        $dotColor = 'bg-blue-500';
                                        $statusLabel = 'Đang xử lý';
                                        $statusClass = 'text-blue-600 font-semibold';

                                        if ($rOrder->order_status === 'completed') {
                                            $dotColor = 'bg-emerald-500';
                                            $statusLabel = 'Hoàn thành';
                                            $statusClass = 'text-emerald-600 font-semibold';
                                        } elseif ($rOrder->payment_status === 'paid') {
                                            $dotColor = 'bg-emerald-500';
                                            $statusLabel = 'Đã thanh toán';
                                            $statusClass = 'text-emerald-600 font-semibold';
                                        } elseif ($rOrder->order_status === 'pending') {
                                            $dotColor = 'bg-amber-500';
                                            $statusLabel = 'Chờ duyệt';
                                            $statusClass = 'text-amber-600 font-semibold';
                                        } elseif ($rOrder->order_status === 'shipping') {
                                            $dotColor = 'bg-sky-500';
                                            $statusLabel = 'Đang giao';
                                            $statusClass = 'text-sky-600 font-semibold';
                                        } elseif ($rOrder->order_status === 'cancelled') {
                                            $dotColor = 'bg-rose-500';
                                            $statusLabel = 'Đã hủy';
                                            $statusClass = 'text-rose-600 font-semibold';
                                        }
                                    @endphp
                                    <div class="flex items-center justify-between text-xs py-1.5 border-b border-slate-50 last:border-b-0 hover:bg-slate-50/50 rounded-lg px-1 transition">
                                        <div class="flex items-start gap-2.5 min-w-0 pr-2">
                                            <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }} mt-1 flex-shrink-0"></span>
                                            <div class="min-w-0">
                                                <div class="font-medium text-slate-800 truncate leading-snug" title="{{ $rOrder->customer_name }}">
                                                    Đơn hàng #{{ $rOrder->order_code }} - {{ $rOrder->customer_name }}
                                                </div>
                                                <div class="text-[11px] text-slate-500 mt-0.5">
                                                    <span class="font-bold text-slate-700">{{ number_format($rOrder->total_amount, 0, ',', '.') }} đ</span>
                                                    <span class="text-slate-400 mx-1">•</span>
                                                    <span>[{{ $timeStr }}]</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 text-right">
                                            <span class="{{ $statusClass }} text-[11px] block">{{ $statusLabel }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-xs text-slate-400">
                                        Chưa có đơn hàng nào
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- 2. SẢN PHẨM BÁN CHẠY (Top đồng hồ bán chạy nhất theo đơn hàng thực tế - Chuẩn Ảnh 2) -->
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-3">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <i class="fa-solid fa-fire text-amber-500"></i>
                                    SẢN PHẨM BÁN CHẠY
                                </h3>
                            </div>

                            <!-- Table Header khớp mẫu ảnh 2: Sản phẩm | Số lượng | Doanh thu -->
                            <div class="grid grid-cols-12 text-[11px] font-bold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100">
                                <div class="col-span-6">Sản phẩm</div>
                                <div class="col-span-2 text-center">Số lượng</div>
                                <div class="col-span-4 text-right">Doanh thu</div>
                            </div>

                            <!-- Danh sách sản phẩm thực tế từ Database của shop -->
                            <div class="divide-y divide-slate-100">
                                @php
                                    $topWatchesList = $topSellingWatches ?? [];
                                @endphp

                                @forelse($topWatchesList as $w)
                                    <div class="grid grid-cols-12 items-center py-2.5 text-xs hover:bg-slate-50/50 rounded-lg px-1 transition">
                                        <div class="col-span-6 flex items-center gap-2.5 pr-2 min-w-0">
                                            <img src="{{ $w->image }}" alt="{{ $w->name }}" class="w-9 h-9 rounded-lg object-cover border border-slate-200 shadow-2xs flex-shrink-0 bg-slate-100" onerror="this.src='/images/placeholder.png'">
                                            <span class="font-semibold text-slate-800 truncate text-[11px]" title="{{ $w->name }}">
                                                {{ $w->name }}
                                            </span>
                                        </div>
                                        <div class="col-span-2 text-center font-bold text-slate-700">
                                            {{ $w->sold }}
                                        </div>
                                        <div class="col-span-4 text-right font-bold text-amber-600 text-[11px]">
                                            {{ $w->formatted_revenue }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-xs text-slate-400">
                                        Chưa có dữ liệu sản phẩm bán chạy
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 2: QUẢN LÝ SẢN PHẨM & TỒN KHO                             -->
            <!-- ============================================================= -->
            <div id="tab-content-products" class="admin-tab-pane space-y-6 {{ $activeTab === 'products' ? '' : 'hidden' }}">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Quản Lý Danh Sách Đồng Hồ</h3>
                        <p class="text-xs text-slate-500">Cập nhật thông tin, thay đổi giá và quản lý tồn kho sản phẩm</p>
                    </div>
                    <button type="button" onclick="toggleAddProductForm()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center gap-2 transition shadow">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>+ Thêm Đồng Hồ Mới</span>
                    </button>
                </div>

                <!-- FORM THÊM SẢN PHẨM MỚI -->
                <div id="form-add-product" class="hidden border border-slate-200 rounded-2xl p-5 bg-slate-50 space-y-4 shadow-sm">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Nhập Thông Tin Đồng Hồ Mới</h4>
                        <button type="button" onclick="toggleAddProductForm()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Tên đồng hồ *</label>
                                <input type="text" name="name" required placeholder="Ví dụ: Rolex Submariner Date 41mm" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Thương hiệu *</label>
                                <input type="text" name="brand" required placeholder="Rolex, Omega, Seiko, Tissot..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Danh mục thương hiệu</label>
                                <select name="category_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->country }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Giá bán (₫) *</label>
                                <input type="number" name="price" required min="100000" step="100000" placeholder="385000000" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Giá niêm yết gốc (₫)</label>
                                <input type="number" name="original_price" min="100000" step="100000" placeholder="420000000" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Số lượng tồn kho *</label>
                                <input type="number" name="stock" required min="0" value="5" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Loại bộ máy</label>
                                <input type="text" name="movement" value="Automatic Thụy Sĩ" placeholder="Automatic, Quartz, Calibre 3235..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Đường kính mặt</label>
                                <input type="text" name="dial_size" value="40mm" placeholder="40mm, 41mm, 36mm..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">Mặt kính</label>
                                <input type="text" name="glass_type" value="Sapphire nguyên khối chống trầy" class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Link ảnh sản phẩm (URL)</label>
                            <input type="url" name="image" placeholder="https://images.unsplash.com/..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-2">
                            <button type="button" onclick="toggleAddProductForm()" class="px-4 py-2 rounded-lg bg-slate-200 text-slate-700 font-semibold">Hủy</button>
                            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold transition shadow">Lưu Sản Phẩm</button>
                        </div>
                    </form>
                </div>

                <!-- TABLE DANH SÁCH SẢN PHẨM (KÈM PHÂN TRANG GỌN GÀNG VÀ BỘ LỌC) -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm bg-white">
                    <div class="p-3.5 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-700">Tổng cộng: <strong id="product-total-count" class="text-amber-600 font-bold">{{ $allProducts->count() }} mẫu đồng hồ</strong> trong hệ thống</span>
                            <span class="text-[11px] text-slate-400 hidden md:inline">| Admin có quyền sửa thông tin, chỉnh tồn kho và xóa</span>
                        </div>

                        <!-- Bộ lọc tìm kiếm nhanh & Số lượng trên trang -->
                        <div class="flex items-center gap-2.5">
                            <div class="relative">
                                <input type="text" id="admin_product_search" onkeyup="filterAdminProducts()" placeholder="Tìm kiếm đồng hồ, SKU..." 
                                       class="text-xs border border-slate-300 rounded-lg pl-7 pr-3 py-1.5 bg-white focus:outline-none focus:border-blue-500 w-44 sm:w-56">
                                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                            </div>

                            <div class="flex items-center gap-1.5 text-xs text-slate-600">
                                <span class="text-[11px] text-slate-500">Mỗi trang:</span>
                                <select id="admin_product_per_page" onchange="changeProductPerPage(this.value)" 
                                        class="text-xs border border-slate-300 rounded-lg px-2 py-1.5 bg-white font-semibold focus:outline-none focus:border-blue-500">
                                    <option value="5" selected>5</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="999">Tất cả</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-slate-700 border-collapse" id="admin_products_table">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-100/70 text-slate-600 uppercase text-[10px] tracking-wider">
                                    <th class="py-3 px-3">Ảnh</th>
                                    <th class="py-3 px-3">Tên đồng hồ & SKU</th>
                                    <th class="py-3 px-3">Thương hiệu</th>
                                    <th class="py-3 px-3">Giá bán</th>
                                    <th class="py-3 px-3">Tồn kho & Cập nhật</th>
                                    <th class="py-3 px-3 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white" id="admin_products_tbody">
                                @foreach($allProducts as $p)
                                    <tr class="admin-product-row hover:bg-slate-50/80 transition" 
                                        data-name="{{ strtolower($p->name) }}" 
                                        data-brand="{{ strtolower($p->brand) }}" 
                                        data-sku="{{ strtolower($p->sku) }}">
                                        <td class="py-2.5 px-3">
                                            <img src="{{ $p->image }}" referrerpolicy="no-referrer" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';" class="w-12 h-12 object-contain rounded-lg border border-slate-200 p-0.5 bg-slate-50">
                                        </td>
                                        <td class="py-2.5 px-3 max-w-xs">
                                            <div class="font-bold text-slate-900 truncate">{{ $p->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">SKU: {{ $p->sku }} • Máy: {{ $p->movement }}</div>
                                        </td>
                                        <td class="py-2.5 px-3 font-bold text-amber-600">{{ $p->brand }}</td>
                                        <td class="py-2.5 px-3">
                                            <div class="font-bold text-slate-900">{{ $p->formatted_price }}</div>
                                            @if($p->original_price > $p->price)
                                                <div class="text-[10px] text-slate-400 line-through">{{ $p->formatted_original_price }}</div>
                                            @endif
                                        </td>
                                        <td class="py-2.5 px-3">
                                            <form action="{{ route('admin.products.stock', $p->id) }}" method="POST" class="flex items-center gap-1.5">
                                                @csrf
                                                <input type="number" name="stock" value="{{ $p->stock }}" min="0" class="w-16 border border-slate-300 rounded-lg px-2 py-1 text-xs font-bold text-center">
                                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-semibold transition" title="Lưu số lượng tồn kho">
                                                    Lưu
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-2.5 px-3 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button type="button" onclick="openEditProductModal({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->brand) }}', {{ $p->price }}, {{ $p->original_price ?? $p->price }}, {{ $p->stock }}, '{{ addslashes($p->movement) }}', '{{ addslashes($p->image) }}')" 
                                                    class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[11px] transition flex items-center gap-1 shadow-sm" title="Chỉnh sửa sản phẩm">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <span>Sửa</span>
                                                </button>

                                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mẫu đồng hồ \'{{ addslashes($p->name) }}\' này?');">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold text-[11px] transition" title="Xóa sản phẩm">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- THANH PHÂN TRANG (PAGINATION BAR) CHO SẢN PHẨM -->
                    <div id="admin-product-pagination-bar" class="p-3.5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                        <div class="text-slate-500">
                            Hiển thị <span id="product-page-range" class="font-bold text-slate-800">1 - 5</span> trên tổng số <span id="product-page-total" class="font-bold text-slate-800">{{ $allProducts->count() }}</span> mẫu đồng hồ
                        </div>
                        <div class="flex items-center gap-1.5" id="product-pagination-buttons">
                            <!-- Nút phân trang render bằng JavaScript -->
                        </div>
                    </div>
                </div>

            </div>

            <!-- ============================================================= -->
            <!-- TAB 3: DANH MỤC & THƯƠNG HIỆU (CÓ ĐỦ THÊM - XÓA - SỬA)         -->
            <!-- ============================================================= -->
            <div id="tab-content-categories" class="admin-tab-pane space-y-6 {{ $activeTab === 'categories' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                    <div class="xl:col-span-8 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Danh Sách Thương Hiệu ({{ $categories->count() }})</h3>
                                <p class="text-[11px] text-slate-500">Quản lý các thương hiệu đồng hồ đối tác, có thể thêm, sửa và xóa thương hiệu.</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto border border-slate-200 rounded-xl shadow-sm bg-white">
                            <table class="w-full text-xs text-left text-slate-700 min-w-[560px]">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-[10px] tracking-wider">
                                        <th class="py-3 px-4 font-bold">Tên thương hiệu</th>
                                        <th class="py-3 px-3 font-bold whitespace-nowrap w-44">Xuất xứ</th>
                                        <th class="py-3 px-3 font-bold text-center whitespace-nowrap w-36">Số mẫu đồng hồ</th>
                                        <th class="py-3 px-3 font-bold text-center whitespace-nowrap w-32">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($categories as $cat)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-3 px-4">
                                                <div class="font-bold text-slate-900 text-xs">{{ $cat->name }}</div>
                                                @if($cat->description)
                                                    <div class="text-[10px] text-slate-400 truncate max-w-[240px] mt-0.5">{{ $cat->description }}</div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-3 text-slate-600 whitespace-nowrap text-xs font-medium">
                                                {{ $cat->country }}
                                            </td>
                                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap shadow-xs {{ $cat->products_count > 0 ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-500' }}">
                                                    {{ $cat->products_count }} mẫu
                                                </span>
                                            </td>
                                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                                    <!-- Nút SỬA Thương hiệu -->
                                                    <button type="button" onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->country) }}', '{{ addslashes($cat->description ?? '') }}')" 
                                                        class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[11px] transition flex items-center gap-1 shadow-sm" title="Chỉnh sửa thương hiệu">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        <span>Sửa</span>
                                                    </button>

                                                    <!-- Nút XÓA Thương hiệu -->
                                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu \'{{ addslashes($cat->name) }}\'?');">
                                                        @csrf
                                                        <button type="submit" class="px-2 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold text-[11px] transition" title="Xóa thương hiệu">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- THÊM THƯƠNG HIỆU MỚI -->
                    <div class="xl:col-span-4 border border-slate-200 rounded-xl p-5 space-y-3 bg-slate-50 h-fit shadow-sm">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                            <i class="fa-solid fa-plus-circle text-amber-600 text-sm"></i>
                            <h4 class="text-xs font-bold text-slate-900 uppercase">Thêm Thương Hiệu Mới</h4>
                        </div>
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3 text-xs">
                            @csrf
                            <div>
                                <label class="block text-slate-700 font-semibold mb-1">Tên thương hiệu *</label>
                                <input type="text" name="name" required placeholder="Ví dụ: Breitling, Cartier..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-slate-700 font-semibold mb-1">Xuất xứ</label>
                                <input type="text" name="country" value="Thụy Sĩ (Swiss Made)" placeholder="Thụy Sĩ (Swiss Made), Nhật Bản..." class="w-full border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-900 focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-slate-700 font-semibold mb-1">Mô tả giới thiệu (tùy chọn)</label>
                                <textarea name="description" rows="2" placeholder="Tóm tắt lịch sử hoặc phân khúc thương hiệu..." class="w-full border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-900 focus:outline-none focus:border-amber-500"></textarea>
                            </div>
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-plus"></i>
                                <span>Thêm Thương Hiệu</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 4: NGƯỜI DÙNG & PHÂN QUYỀN                                 -->
            <!-- ============================================================= -->
            <div id="tab-content-users" class="admin-tab-pane space-y-4 {{ $activeTab === 'users' ? '' : 'hidden' }}">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-900">Danh Sách Tài Khoản ({{ $adminTotalUsers }})</h3>
                    <div class="text-xs text-slate-500">
                        Quản trị: <span class="font-bold text-amber-600">{{ $adminRoleCount }}</span> | Khách hàng: <span class="font-bold text-blue-600">{{ $customerRoleCount }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-xs text-left text-slate-700">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="py-2.5 px-3">Tên thành viên</th>
                                <th class="py-2.5 px-3">Email</th>
                                <th class="py-2.5 px-3">Số điện thoại</th>
                                <th class="py-2.5 px-3">Vai trò</th>
                                <th class="py-2.5 px-3 text-right">Phân quyền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($adminUsers as $u)
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">{{ $u->name }}</td>
                                    <td class="py-2.5 px-3 font-mono">{{ $u->email }}</td>
                                    <td class="py-2.5 px-3">{{ $u->phone ?? 'Chưa cập nhật' }}</td>
                                    <td class="py-2.5 px-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $u->isAdmin() ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $u->isAdmin() ? 'Quản Trị Viên' : 'Khách Hàng' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right">
                                        @if($u->id !== Auth::id())
                                            <form action="{{ route('admin.users.role', $u->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 rounded text-[10px] font-semibold {{ $u->isAdmin() ? 'bg-slate-200 text-slate-700' : 'bg-blue-600 text-white' }}">
                                                    {{ $u->isAdmin() ? 'Hạ xuống Khách' : 'Nâng lên Admin' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Đang đăng nhập</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 7: TIN NHẮN LIVECHAT KHÁCH HÀNG                           -->
            <!-- ============================================================= -->
            <div id="tab-content-livechat" class="admin-tab-pane space-y-4 {{ $activeTab === 'livechat' ? '' : 'hidden' }}">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-headset text-blue-600"></i>
                            <span>Tin Nhắn Trực Tuyến (Livechat Khách Hàng)</span>
                        </h3>
                        <p class="text-xs text-slate-500">Chọn khách hàng bên trái để xem sản phẩm họ đang hỏi và nhắn tin trao đổi trực tiếp</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="loadAdminConversations()" class="text-[11px] text-slate-600 hover:text-blue-600 border border-slate-200 bg-white px-2.5 py-1 rounded-lg transition shadow-2xs" title="Làm mới cuộc trò chuyện">
                            <i class="fa-solid fa-rotate text-blue-500 mr-1"></i> Làm mới
                        </button>
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center gap-1.5 shadow-2xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Đang trực tuyến</span>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 border border-slate-200 rounded-2xl overflow-hidden shadow-xs bg-white min-h-[520px]">
                    <!-- Customer list (Left column) -->
                    <div class="lg:col-span-4 border-r border-slate-200 bg-slate-50/70 p-3 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between px-2 mb-2.5">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Khách hàng hỏi sản phẩm</span>
                                <span id="admin-chat-count-badge" class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold text-[10px]">4 khách</span>
                            </div>
                            
                            <!-- Search box in chat list -->
                            <div class="relative mb-3">
                                <input type="text" id="admin-chat-search-input" oninput="filterAdminChats(this.value)" placeholder="Tìm khách hoặc sản phẩm..." 
                                    class="w-full text-xs bg-white border border-slate-200 rounded-xl pl-8 pr-3 py-1.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 transition shadow-2xs">
                                <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
                            </div>

                            <!-- List of customer chats -->
                            <div id="admin-chat-customers-list" class="space-y-2 max-h-[420px] overflow-y-auto pr-1">
                                <!-- Rendered dynamically by JavaScript -->
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200 mt-2 px-1 text-[11px] text-slate-400 flex items-center justify-between">
                            <span><i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>Hệ thống tự động đồng bộ</span>
                            <span class="font-medium">ChronoLux Support</span>
                        </div>
                    </div>

                    <!-- Chat conversation area (Right column) -->
                    <div class="lg:col-span-8 flex flex-col justify-between bg-white">
                        
                        <!-- Top Header: Customer Info + Product Inquired Box -->
                        <div id="admin-chat-header-bar" class="p-3.5 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div id="admin-chat-active-avatar" class="w-10 h-10 rounded-full bg-blue-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-xs">
                                    P
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 id="admin-chat-active-name" class="font-bold text-slate-900 text-sm">Phạm Thanh Thảo</h4>
                                        <span id="admin-chat-active-status" class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold">Cần trả lời</span>
                                    </div>
                                    <div id="admin-chat-active-contact" class="text-[11px] text-slate-500 flex items-center gap-2">
                                        <span><i class="fa-solid fa-phone text-[10px] text-slate-400 mr-1"></i>0912 345 678</span>
                                        <span>•</span>
                                        <span><i class="fa-solid fa-envelope text-[10px] text-slate-400 mr-1"></i>thanhthao.pham@gmail.com</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Inquired Product Card -->
                            <div id="admin-chat-product-box" class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200 shadow-2xs max-w-xs">
                                <img id="admin-chat-product-img" src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=160&auto=format&fit=crop&q=80" alt="Sản phẩm" class="w-10 h-10 object-cover rounded-lg border border-slate-100 flex-shrink-0">
                                <div class="overflow-hidden">
                                    <div class="text-[9px] font-bold uppercase tracking-wider text-amber-600">Sản phẩm hỏi:</div>
                                    <div id="admin-chat-product-name" class="text-[11px] font-semibold text-slate-900 truncate">Rolex Datejust 36mm Vàng Hồng</div>
                                    <div id="admin-chat-product-price" class="text-[10px] font-bold text-amber-600">345.000.000 ₫</div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat message thread container -->
                        <div id="admin-chat-messages-container" class="flex-1 p-4 overflow-y-auto space-y-3.5 bg-slate-50/30 max-h-[350px] min-h-[280px]">
                            <!-- Dynamically populated -->
                        </div>

                        <!-- Quick suggestion chips -->
                        <div class="px-4 py-2 bg-slate-50/80 border-t border-slate-100 flex items-center gap-1.5 overflow-x-auto scrollbar-none text-xs">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap mr-1">
                                <i class="fa-solid fa-bolt text-amber-500"></i> Phản hồi nhanh:
                            </span>
                            <button type="button" onclick="fillAdminReplyText('Dạ mẫu này hiện đang có sẵn tại showroom, sẵn sàng giao ngay cho bạn nhé!')" 
                                class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-700 text-[11px] transition shadow-2xs">
                                🏬 Có sẵn tại showroom
                            </button>
                            <button type="button" onclick="fillAdminReplyText('Dạ bên em hỗ trợ miễn phí giao hàng hỏa tốc toàn quốc (GHN 2-4h), được mở kiểm tra trước khi thanh toán COD bạn nhé!')" 
                                class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-700 text-[11px] transition shadow-2xs">
                                🚚 Miễn phí ship COD
                            </button>
                            <button type="button" onclick="fillAdminReplyText('Sản phẩm được bảo hành chính hãng 5 năm toàn quốc, đầy đủ hộp sổ thẻ bảo hành quốc tế bạn nhé!')" 
                                class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-700 text-[11px] transition shadow-2xs">
                                🛡️ Bảo hành 5 năm
                            </button>
                            <button type="button" onclick="fillAdminReplyText('Shop xin gửi bạn video & ảnh chụp thực tế sản phẩm độ nét cao qua Zalo/Hotline ạ!')" 
                                class="whitespace-nowrap px-2.5 py-1 rounded-full bg-white border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-700 text-[11px] transition shadow-2xs">
                                📸 Gửi ảnh thực tế
                            </button>
                        </div>

                        <!-- Reply input bar -->
                        <div class="p-3 bg-white border-t border-slate-200">
                            <form id="admin-chat-form" onsubmit="handleAdminSendMessage(event)" class="flex items-center gap-2">
                                <input type="text" id="admin-chat-input" placeholder="Nhập tin nhắn phản hồi khách hàng..." required 
                                    class="flex-1 border border-slate-300 rounded-xl px-4 py-2.5 text-xs bg-slate-50 text-slate-900 focus:bg-white focus:outline-none focus:border-blue-500 shadow-2xs transition">
                                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition flex-shrink-0">
                                    <i class="fa-solid fa-paper-plane text-xs"></i>
                                    <span>Gửi Phản Hồi</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 6: BÁO CÁO THỐNG KÊ DOANH THU (CHUẨN ẢNH MẪU CỦA BẠN)      -->
            <!-- ============================================================= -->
            <div id="tab-content-finance" class="admin-tab-pane space-y-6 {{ $activeTab === 'finance' ? '' : 'hidden' }}">
                
                <!-- 1. HEADER: Tiêu đề + Nút In báo cáo & Quản lý đơn hàng -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-500 flex items-center justify-center text-xl shadow-xs flex-shrink-0">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-sans tracking-tight">Báo Cáo Thống Kê Doanh Thu</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Phân tích chi tiết doanh thu theo ngày và tỷ trọng doanh thu theo từng danh mục sản phẩm</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold flex items-center gap-2 shadow-xs transition cursor-pointer">
                            <i class="fa-solid fa-print"></i>
                            <span>In báo cáo</span>
                        </button>
                        <button type="button" onclick="switchAdminTab('orders')" class="px-4 py-2 rounded-xl bg-[#0066ff] hover:bg-blue-700 text-white text-xs font-semibold flex items-center gap-2 shadow-xs transition cursor-pointer">
                            <i class="fa-solid fa-receipt"></i>
                            <span>Quản lý đơn hàng</span>
                        </button>
                    </div>
                </div>

                <!-- 2. BỘ LỌC THỜI GIAN & NGÀY THÁNG (Chuẩn Ảnh Mẫu) -->
                <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3.5">
                    <!-- Nút lọc nhanh dạng viên thuốc (Pills) -->
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ url('/?view=admin&admin_tab=finance&period=all#admin-section') }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ ($period ?? 'all') === 'all' ? 'bg-[#0f172a] text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            Tất cả
                        </a>
                        <a href="{{ url('/?view=admin&admin_tab=finance&period=today#admin-section') }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ ($period ?? '') === 'today' ? 'bg-[#0f172a] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                            Hôm nay
                        </a>
                        <a href="{{ url('/?view=admin&admin_tab=finance&period=7days#admin-section') }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ ($period ?? '') === '7days' ? 'bg-[#0f172a] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                            7 ngày qua
                        </a>
                        <a href="{{ url('/?view=admin&admin_tab=finance&period=30days#admin-section') }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ ($period ?? '') === '30days' ? 'bg-[#0f172a] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                            30 ngày qua
                        </a>
                        <a href="{{ url('/?view=admin&admin_tab=finance&period=month#admin-section') }}" 
                           class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ ($period ?? '') === 'month' ? 'bg-[#0f172a] text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                            Tháng này
                        </a>
                    </div>

                    <!-- Ô chọn khoảng ngày: Từ mm/dd/yyyy Đến mm/dd/yyyy [Xem] -->
                    <form action="{{ url('/') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                        <input type="hidden" name="view" value="admin">
                        <input type="hidden" name="admin_tab" value="finance">
                        <span class="font-medium text-slate-500">Từ</span>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="border border-slate-300 rounded-lg px-2.5 py-1 text-xs text-slate-800 bg-white focus:outline-none focus:border-blue-500 shadow-xs">
                        <span class="font-medium text-slate-500">Đến</span>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="border border-slate-300 rounded-lg px-2.5 py-1 text-xs text-slate-800 bg-white focus:outline-none focus:border-blue-500 shadow-xs">
                        <button type="submit" class="px-4 py-1.5 rounded-lg bg-[#0f172a] hover:bg-slate-800 text-white text-xs font-semibold transition shadow-xs cursor-pointer flex items-center gap-1.5">
                            <i class="fa-solid fa-filter text-[10px]"></i>
                            <span>Xem</span>
                        </button>
                    </form>
                </div>

                <!-- 3. 4 THẺ THỐNG KÊ CHỈ SỐ DOANH THU (Chuẩn Ảnh Mẫu) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1: Doanh thu thực tế (Kỳ này) -->
                    <div class="bg-white border border-slate-200 border-l-4 border-l-emerald-500 rounded-2xl p-5 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">DOANH THU THỰC TẾ (KỲ NÀY)</div>
                        <div>
                            <div class="text-2xl font-black text-[#10b981] tracking-tight">
                                {{ number_format($actualRevenue ?? $totalRevenue ?? 0, 0, ',', '.') }} <span class="text-base font-bold">VNĐ</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">Tính trên các đơn đã thanh toán & hoàn thành</div>
                        </div>
                    </div>

                    <!-- Card 2: Đơn hàng đã thu tiền -->
                    <div class="bg-white border border-slate-200 border-l-4 border-l-blue-500 rounded-2xl p-5 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">ĐƠN HÀNG ĐÃ THU TIỀN</div>
                        <div>
                            <div class="text-2xl font-black text-[#0066ff] tracking-tight">
                                {{ $paidOrdersCount ?? 0 }} <span class="text-slate-500 text-sm font-semibold">/ {{ $totalOrdersCount ?? $totalOrders ?? 0 }} đơn tổng</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">Tỷ lệ thành công: <strong class="text-slate-700 font-bold">{{ $successRate ?? 0 }}%</strong></div>
                        </div>
                    </div>

                    <!-- Card 3: Giá trị TB / Đơn (AOV) -->
                    <div class="bg-white border border-slate-200 border-l-4 border-l-amber-500 rounded-2xl p-5 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">GIÁ TRỊ TB / ĐƠN (AOV)</div>
                        <div>
                            <div class="text-2xl font-black text-slate-900 tracking-tight">
                                {{ number_format($aov ?? $avgOrderValue ?? 0, 0, ',', '.') }} <span class="text-base font-bold">VNĐ</span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">Doanh thu trung bình trên mỗi đơn hàng</div>
                        </div>
                    </div>

                    <!-- Card 4: Danh mục doanh thu cao nhất -->
                    <div class="bg-white border border-slate-200 border-l-4 border-l-sky-500 rounded-2xl p-5 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">DANH MỤC DOANH THU CAO NHẤT</div>
                        <div>
                            <div class="text-2xl font-black text-[#0284c7] tracking-tight truncate">
                                {{ $topCategoryName ?? 'Rolex' }}
                            </div>
                            <div class="text-[11px] text-slate-500 mt-1 font-medium">Đạt: <strong class="text-slate-800 font-bold">{{ number_format($topCategoryRevenue ?? 0, 0, ',', '.') }} VNĐ</strong></div>
                        </div>
                    </div>

                </div>

                <!-- 4. 2 BIỂU ĐỒ SONG SONG (Chuẩn Ảnh Mẫu) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                    
                    <!-- Biểu đồ trái: Xu Hướng Doanh Thu Theo Ngày (Combo Line + Bar) -->
                    <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Xu Hướng Doanh Thu Theo Ngày</h3>
                                    <p class="text-[11px] text-slate-400">Biểu đồ doanh thu thực tế và số lượng đơn hàng hoàn tất</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-blue-50 border border-blue-200/60 text-blue-600 font-semibold text-xs">
                                {{ $trendDaysCount ?? 5 }} ngày ghi nhận
                            </span>
                        </div>

                        <div class="relative w-full" style="height: 280px;">
                            <canvas id="embeddedRevenueTrendChart"></canvas>
                        </div>
                    </div>

                    <!-- Biểu đồ phải: Cơ Cấu Doanh Thu (Donut Chart) -->
                    <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs flex flex-col justify-between">
                        <div class="pb-3 border-b border-slate-100 mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Cơ Cấu Doanh Thu</h3>
                                    <p class="text-[11px] text-slate-400">Tỷ trọng doanh thu theo danh mục</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative w-full flex items-center justify-center" style="height: 280px;">
                            <canvas id="embeddedRevenueDonutChart"></canvas>
                        </div>
                    </div>

                </div>

                <!-- 5. BẢNG CHI TIẾT DOANH THU THEO THƯƠNG HIỆU / DANH MỤC ĐỒNG HỒ -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-xs space-y-3">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-clock text-amber-500"></i>
                            <span>Chi Tiết Doanh Thu Theo Thương Hiệu Đồng Hồ</span>
                        </h4>
                        <span class="text-xs text-slate-500 font-medium">{{ count($categoryRevenues ?? []) }} thương hiệu</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-slate-700">
                            <thead class="text-[10px] uppercase tracking-wider text-slate-500 border-b border-slate-200 bg-slate-50/70">
                                <tr>
                                    <th class="py-2.5 px-3">Thương Hiệu</th>
                                    <th class="py-2.5 px-3">Xuất Xứ</th>
                                    <th class="py-2.5 px-3 text-center">Số Mẫu Đồng Hồ</th>
                                    <th class="py-2.5 px-3 text-right">Doanh Số Thu Được</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($categoryRevenues as $cat)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-2.5 px-3 font-bold text-slate-900 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                            <span>{{ $cat->name }}</span>
                                        </td>
                                        <td class="py-2.5 px-3 text-slate-500">{{ $cat->country }}</td>
                                        <td class="py-2.5 px-3 text-center font-semibold text-slate-700">{{ $cat->products_count }} mẫu</td>
                                        <td class="py-2.5 px-3 text-right font-black text-emerald-600">
                                            {{ number_format($cat->revenue, 0, ',', '.') }} VNĐ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Script vẽ biểu đồ Chart.js cho Báo cáo thống kê doanh thu -->
            <script>
            function initFinanceCharts() {
                if (typeof Chart === 'undefined') return;

                const trendCanvas = document.getElementById('embeddedRevenueTrendChart');
                if (trendCanvas && !trendCanvas.chartInstance) {
                    trendCanvas.chartInstance = new Chart(trendCanvas, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($trendLabels ?? ['29/10', '30/10', '31/10', '01/11', '02/11']) !!},
                            datasets: [
                                {
                                    type: 'line',
                                    label: 'Doanh Thu (VNĐ)',
                                    data: {!! json_encode($trendRevenues ?? [375042900, 194492900, 448015800, 654800200, 560082500]) !!},
                                    borderColor: '#0284c7',
                                    backgroundColor: 'rgba(2, 132, 199, 0.08)',
                                    borderWidth: 2.5,
                                    tension: 0.35,
                                    fill: false,
                                    yAxisID: 'yRevenue',
                                    pointBackgroundColor: '#0284c7',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4.5,
                                    pointHoverRadius: 6,
                                    order: 1
                                },
                                {
                                    type: 'bar',
                                    label: 'Số Đơn Hoàn Tất',
                                    data: {!! json_encode($trendOrders ?? [3, 2, 5, 5, 2]) !!},
                                    backgroundColor: 'rgba(16, 185, 129, 0.75)',
                                    hoverBackgroundColor: '#10b981',
                                    borderRadius: 6,
                                    yAxisID: 'yOrders',
                                    barPercentage: 0.45,
                                    order: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: { font: { size: 11, family: 'Instrument Sans' }, boxWidth: 14 }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            if (ctx.dataset.yAxisID === 'yRevenue') {
                                                return ' Doanh Thu: ' + new Intl.NumberFormat('vi-VN').format(ctx.raw) + ' VNĐ';
                                            }
                                            return ' Số Đơn: ' + ctx.raw + ' đơn';
                                        }
                                    }
                                }
                            },
                            scales: {
                                yRevenue: {
                                    type: 'linear',
                                    position: 'left',
                                    ticks: {
                                        callback: function(val) {
                                            return val >= 1000000 ? (val / 1000000).toLocaleString('vi-VN') + 'M' : val;
                                        },
                                        font: { size: 10 }
                                    },
                                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                                },
                                yOrders: {
                                    type: 'linear',
                                    position: 'right',
                                    ticks: { stepSize: 1, font: { size: 10 } },
                                    grid: { drawOnChartArea: false }
                                },
                                x: {
                                    ticks: { font: { size: 10 } },
                                    grid: { display: false }
                                }
                            }
                        }
                    });
                }

                const donutCanvas = document.getElementById('embeddedRevenueDonutChart');
                if (donutCanvas && !donutCanvas.chartInstance) {
                    donutCanvas.chartInstance = new Chart(donutCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($donutLabels ?? ['Rolex', 'Hublot', 'Omega', 'Tissot']) !!},
                            datasets: [{
                                data: {!! json_encode($donutData ?? [2233600000, 885000000, 337000000, 94200000]) !!},
                                backgroundColor: [
                                    '#0066ff', '#10b981', '#f59e0b', '#0284c7', 
                                    '#8b5cf6', '#ec4899', '#14b8a6', '#64748b'
                                ],
                                borderWidth: 2.5,
                                borderColor: '#ffffff',
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '62%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { font: { size: 10, family: 'Instrument Sans' }, boxWidth: 10, padding: 10 }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx) {
                                            return ' ' + ctx.label + ': ' + new Intl.NumberFormat('vi-VN').format(ctx.raw) + ' VNĐ';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                initFinanceCharts();
            });
            // Re-render when switching tabs
            const origSwitchAdminTab = window.switchAdminTab;
            window.switchAdminTab = function(tabName) {
                if (typeof origSwitchAdminTab === 'function') {
                    origSwitchAdminTab(tabName);
                }
                if (tabName === 'finance') {
                    setTimeout(initFinanceCharts, 100);
                }
            };
            </script>

            <!-- ============================================================= -->
            <!-- TAB 8: GIAO DỊCH THANH TOÁN (COD)                             -->
            <!-- ============================================================= -->
            <div id="tab-content-transactions" class="admin-tab-pane space-y-6 {{ $activeTab === 'transactions' ? '' : 'hidden' }}">
                <!-- Filter Row -->
                <div>
                    <form action="{{ url('/#admin-section') }}" method="GET" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="view" value="admin">
                        <input type="hidden" name="admin_tab" value="transactions">
                        
                        <span class="text-xs font-medium text-slate-700">Sắp xếp</span>
                        
                        <div class="relative">
                            <select name="admin_sort" class="border border-slate-300 rounded-lg px-4 py-1.5 text-xs text-slate-700 bg-white pr-8 focus:outline-none focus:border-blue-500 appearance-none shadow-sm cursor-pointer">
                                <option value="latest" {{ request('admin_sort', 'latest') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ request('admin_sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                <option value="price_desc" {{ request('admin_sort') == 'price_desc' ? 'selected' : '' }}>Giá trị cao nhất</option>
                                <option value="price_asc" {{ request('admin_sort') == 'price_asc' ? 'selected' : '' }}>Giá trị thấp nhất</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>

                        <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                            Áp dụng bộ lọc
                        </button>

                        <a href="{{ url('/?view=admin&admin_tab=transactions#admin-section') }}" class="px-4 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold shadow-sm transition">
                            Xóa bộ lọc
                        </a>

                        <div class="ml-auto flex items-center gap-1.5 text-xs text-slate-600">
                            <span class="text-[11px] text-slate-500">Mỗi trang:</span>
                            <select id="admin_trans_per_page" onchange="changeTransPerPage(this.value)" 
                                    class="text-xs border border-slate-300 rounded-lg px-2 py-1.5 bg-white font-semibold focus:outline-none focus:border-blue-500 shadow-xs cursor-pointer">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="999">Tất cả</option>
                            </select>
                        </div>
                    </form>

                    <p class="text-xs text-slate-500 mt-4">
                        Có <span class="font-bold text-slate-800" id="trans-summary-total">{{ $adminTotalTransactions }}</span> đơn phù hợp bộ lọc. Số tiền bao gồm phí vận chuyển, ngày lọc là ngày tạo đơn.
                    </p>
                </div>

                <!-- Section Title -->
                <div class="pt-2">
                    <h2 class="text-sm font-bold text-slate-900">Danh sách giao dịch (<span id="trans-title-count">{{ $adminTotalTransactions }}</span> đơn)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        COD: Xác nhận thu tiền hoặc thất bại; đơn đã thu tiền có thể chuyển sang chờ hoàn tiền rồi xác nhận đã hoàn tiền.
                    </p>
                </div>

                <!-- Table Transactions matching Image 2 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm bg-white">
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-slate-700 border-collapse" id="admin_trans_table">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Đơn hàng</th>
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Khách hàng</th>
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Phương thức</th>
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Số tiền</th>
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Thanh toán</th>
                                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Cập nhật COD</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100" id="admin_trans_tbody">
                                @forelse($adminTransactions as $tx)
                                    <tr class="admin-trans-row hover:bg-slate-50/80 transition">
                                        <td class="py-3 px-4 align-top">
                                            <span class="font-bold text-slate-900 text-xs">{{ $tx->order_code }}</span>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="fa-regular fa-clock text-[10px]"></i>
                                                <span>{{ $tx->created_at ? $tx->created_at->format('d/m/Y H:i') : '24/09/2026 02:01' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 align-top">
                                            <div class="font-semibold text-slate-800">{{ $tx->customer_name }}</div>
                                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="fa-solid fa-phone text-[10px]"></i>
                                                <span>{{ $tx->customer_phone }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 align-top">
                                            @if(strtolower($tx->payment_method) === 'momo')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#a50064] text-white inline-flex items-center gap-1 shadow-sm">
                                                    <i class="fa-solid fa-wallet text-[9px]"></i>
                                                    <span>MoMo</span>
                                                </span>
                                            @elseif(strtolower($tx->payment_method) === 'banking')
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white inline-flex items-center gap-1 shadow-sm">
                                                    <i class="fa-solid fa-qrcode text-[9px]"></i>
                                                    <span>Banking</span>
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white inline-flex items-center gap-1 shadow-sm">
                                                    <i class="fa-solid fa-truck-fast text-[9px]"></i>
                                                    <span>COD</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 align-top font-bold text-slate-900 whitespace-nowrap">
                                            {{ number_format($tx->total_amount, 0, ',', '.') }} đ
                                        </td>
                                        <td class="py-3 px-4 align-top whitespace-nowrap">
                                            @if($tx->payment_status === 'paid')
                                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                                    <span>Đã thanh toán</span>
                                                </span>
                                            @elseif($tx->payment_status === 'failed')
                                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-rose-600 bg-rose-50 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i>
                                                    <span>Thất bại</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2.5 py-0.5 rounded-full">
                                                    <i class="fa-regular fa-clock text-[10px]"></i>
                                                    <span>Chờ thanh toán</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 align-top whitespace-nowrap">
                                            @if(strtolower($tx->payment_method) === 'cod' && $tx->payment_status !== 'paid')
                                                <form action="{{ route('admin.transactions.status', $tx->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                                    @csrf
                                                    <input type="hidden" name="payment_status" value="paid">
                                                    <button type="submit" class="px-2.5 py-1 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] transition shadow-xs flex items-center gap-1">
                                                        <i class="fa-solid fa-check text-[9px]"></i>
                                                        <span>Xác nhận thu tiền</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-slate-400 text-[11px] italic">Tự động</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-slate-400">Không tìm thấy giao dịch nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- THANH PHÂN TRANG (PAGINATION BAR) CHO GIAO DỊCH (COD / MOMO / BANKING) -->
                    <div id="admin-trans-pagination-bar" class="p-3.5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                        <div class="text-slate-500">
                            Hiển thị <span id="trans-page-range" class="font-bold text-slate-800">1 - 5</span> trên tổng số <span id="trans-page-total" class="font-bold text-slate-800">{{ $adminTotalTransactions }}</span> giao dịch
                        </div>
                        <div class="flex items-center gap-1.5" id="trans-pagination-buttons">
                            <!-- Nút phân trang render bằng JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 9: BÁO CÁO                                                -->
            <!-- ============================================================= -->
            <div id="tab-content-reports" class="admin-tab-pane space-y-6 {{ $activeTab === 'reports' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="border border-slate-200 rounded-2xl p-5 space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-fire text-amber-500"></i>
                            <span>Top Mẫu Bán Chạy</span>
                        </h4>
                        <div class="divide-y divide-slate-100">
                            @forelse($topSellingProducts as $tp)
                                <div class="py-2.5 flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-800 truncate max-w-xs">{{ $tp->name }}</span>
                                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">{{ $tp->sold_count }} đã bán</span>
                                </div>
                            @empty
                                <div class="text-xs text-slate-500 py-6 text-center">Chưa có lượt mua nào trên website.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-2xl p-5 space-y-3">
                        <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                            <span>Cảnh Báo Tồn Kho Thấp (≤ 5)</span>
                        </h4>
                        @if($lowStockProducts->isEmpty())
                            <div class="text-xs text-slate-500 py-6 text-center">Tất cả sản phẩm đều đủ số lượng tồn kho.</div>
                        @else
                            <div class="divide-y divide-slate-100">
                                @foreach($lowStockProducts as $lp)
                                    <div class="py-2.5 flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-800 truncate max-w-xs">{{ $lp->name }}</span>
                                        <span class="font-bold text-rose-600">Còn {{ $lp->stock }} chiếc</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL: CHI TIẾT ĐƠN HÀNG (POPUP ĐẦY ĐỦ THÔNG TIN KHI BẤM NÚT CHI TIẾT)   -->
<!-- ========================================================================= -->
<div id="modal-order-detail" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full space-y-5 shadow-2xl relative text-slate-800 border border-slate-200 animate-in fade-in zoom-in-95 duration-200">
        <button type="button" onclick="closeOrderDetailModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800 transition">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-xs">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Chi Tiết Đơn Hàng <span id="modal-order-code" class="text-blue-600 font-mono"></span></h3>
                <p class="text-xs text-slate-500">Ngày tạo: <span id="modal-order-date"></span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <!-- Thông tin khách hàng -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="font-bold text-slate-900 uppercase text-[11px] tracking-wider flex items-center gap-1.5 text-blue-600">
                    <i class="fa-solid fa-user"></i>
                    <span>Thông Tin Khách Hàng</span>
                </div>
                <div><span class="text-slate-500">Họ và tên:</span> <strong id="modal-customer-name" class="text-slate-900"></strong></div>
                <div><span class="text-slate-500">Số điện thoại:</span> <span id="modal-customer-phone" class="font-semibold text-slate-900"></span></div>
                <div><span class="text-slate-500">Email:</span> <span id="modal-customer-email" class="text-slate-700"></span></div>
                <div><span class="text-slate-500">Địa chỉ nhận:</span> <span id="modal-shipping-address" class="text-slate-800 font-medium"></span></div>
                <div><span class="text-slate-500">Ghi chú:</span> <span id="modal-order-notes" class="italic text-slate-600"></span></div>
            </div>

            <!-- Thông tin thanh toán & Trạng thái -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="font-bold text-slate-900 uppercase text-[11px] tracking-wider flex items-center gap-1.5 text-emerald-600">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Thanh Toán & Vận Chuyển GHN</span>
                </div>
                <div><span class="text-slate-500">Tổng tiền đơn:</span> <strong id="modal-order-total" class="text-base font-black text-rose-600"></strong></div>
                <div><span class="text-slate-500">Hình thức:</span> <span id="modal-payment-method" class="font-bold px-2 py-0.5 rounded bg-slate-200 text-slate-800 text-[10px]"></span></div>
                <div><span class="text-slate-500">Cước ship GHN:</span> <strong id="modal-order-shipping-fee" class="font-bold text-emerald-600"></strong></div>
                <div><span class="text-slate-500">Khoảng cách:</span> <span id="modal-order-distance" class="font-semibold text-slate-700"></span></div>
                <div><span class="text-slate-500">Mã vận đơn GHN:</span> <span id="modal-order-ghn-code" class="font-mono font-bold text-indigo-600"></span></div>
                <div><span class="text-slate-500">Trạng thái:</span> <span id="modal-order-status" class="font-bold text-blue-600"></span></div>
                <div class="pt-2 text-[11px] text-slate-500 flex items-center gap-1.5 border-t border-slate-100">
                    <i class="fa-solid fa-truck-fast text-amber-500"></i>
                    <span>Dịch vụ chuẩn Giao Hàng Nhanh (GHN Express)</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-200">
            <button type="button" onclick="closeOrderDetailModal()" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition shadow-sm">
                Đóng cửa sổ
            </button>
        </div>
    </div>
</div>

<!-- MODAL: CHỈNH SỬA SẢN PHẨM (DÀNH CHO ADMIN) -->
<div id="modal-edit-product" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full space-y-4 shadow-2xl relative text-slate-800 border border-slate-200">
        <button type="button" onclick="closeEditProductModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-2.5 pb-2 border-b border-slate-200">
            <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Chỉnh Sửa Thông Tin Đồng Hồ</h3>
                <p class="text-xs text-slate-500">Cập nhật thông tin chi tiết, giá bán và tồn kho</p>
            </div>
        </div>

        <form id="form-edit-product-action" action="" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tên sản phẩm *</label>
                <input type="text" id="edit-prod-name" name="name" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500 font-semibold">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Thương hiệu *</label>
                    <input type="text" id="edit-prod-brand" name="brand" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Bộ máy</label>
                    <input type="text" id="edit-prod-movement" name="movement" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Giá bán (₫) *</label>
                    <input type="number" id="edit-prod-price" name="price" required min="100000" step="100000" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500 font-bold">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Giá gốc (₫)</label>
                    <input type="number" id="edit-prod-orig-price" name="original_price" min="100000" step="100000" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tồn kho *</label>
                    <input type="number" id="edit-prod-stock" name="stock" required min="0" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500 font-bold">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Đường dẫn hình ảnh (URL)</label>
                <input type="text" id="edit-prod-image" name="image" oninput="updateEditImagePreview(this.value)" placeholder="Dán đường dẫn ảnh tại đây (https://...)" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500 font-mono text-xs">
            </div>

            <!-- Khung so sánh & Xem trước: Ảnh hiện tại (ảnh cũ) & Ảnh mới -->
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between gap-3">
                <!-- Cột trái: Ảnh cũ (Ảnh hiện tại) -->
                <div class="flex items-center gap-2.5">
                    <div class="w-14 h-14 rounded-xl border border-slate-300 bg-white p-1 overflow-hidden flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img id="edit-prod-old-image" src="" alt="Ảnh cũ" referrerpolicy="no-referrer" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=Chưa+Có+Ảnh';">
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Ảnh hiện tại</span>
                        <span id="edit-prod-old-status" class="text-[11px] text-slate-700 font-semibold block">Đang sử dụng</span>
                    </div>
                </div>

                <div class="text-slate-300 font-bold text-base">➔</div>

                <!-- Cột phải: Xem trước ảnh mới sau khi đổi link -->
                <div class="flex items-center gap-2.5 flex-1 min-w-0">
                    <div class="w-14 h-14 rounded-xl border-2 border-dashed border-amber-500 bg-white p-1 overflow-hidden flex items-center justify-center flex-shrink-0 shadow-sm relative">
                        <img id="edit-prod-preview-image" src="" alt="Xem trước ảnh mới" referrerpolicy="no-referrer" class="w-full h-full object-contain" onerror="handlePreviewError()">
                        <span id="edit-prod-preview-badge" class="absolute -top-1.5 -right-1.5 bg-amber-500 text-slate-950 text-[9px] font-bold px-1 rounded-full shadow">MỚI</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 block">Xem trước ảnh mới</span>
                        <p id="edit-prod-preview-status" class="text-[11px] text-slate-500 truncate">Nhập link để xem trước</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold transition">Hủy bỏ</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Cập Nhật Thông Tin</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: CHỈNH SỬA THƯƠNG HIỆU / DANH MỤC (DÀNH CHO ADMIN) -->
<div id="modal-edit-category" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-4 shadow-2xl relative text-slate-800 border border-slate-200">
        <button type="button" onclick="closeEditCategoryModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-2.5 pb-2 border-b border-slate-200">
            <div class="w-8 h-8 rounded-full bg-amber-500/20 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Chỉnh Sửa Thương Hiệu Đồng Hồ</h3>
                <p class="text-xs text-slate-500">Cập nhật tên, xuất xứ và mô tả thương hiệu</p>
            </div>
        </div>

        <form id="form-edit-category-action" action="" method="POST" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tên thương hiệu *</label>
                <input type="text" id="edit-cat-name" name="name" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500 font-semibold">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Xuất xứ *</label>
                <input type="text" id="edit-cat-country" name="country" required class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Mô tả giới thiệu</label>
                <textarea id="edit-cat-desc" name="description" rows="3" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 text-slate-900 focus:outline-none focus:border-amber-500" placeholder="Thông tin về lịch sử, phân khúc..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold transition">Hủy bỏ</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Lưu Cập Nhật</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript Điều Khiển Tab Admin Embedded & Product/Category Modals -->
<script>
    // Chi tiết đơn hàng modal
    function showOrderDetailModal(code, name, phone, email, address, total, method, status, date, notes, fee, distance, ghnCode) {
        document.getElementById('modal-order-code').textContent = code;
        document.getElementById('modal-order-date').textContent = date;
        document.getElementById('modal-customer-name').textContent = name;
        document.getElementById('modal-customer-phone').textContent = phone;
        document.getElementById('modal-customer-email').textContent = email || 'Không có';
        document.getElementById('modal-shipping-address').textContent = address || 'Địa chỉ mặc định';
        document.getElementById('modal-order-total').textContent = total;
        document.getElementById('modal-payment-method').textContent = method;
        document.getElementById('modal-order-status').textContent = status;
        document.getElementById('modal-order-notes').textContent = notes || 'Không có';
        if (document.getElementById('modal-order-shipping-fee')) {
            document.getElementById('modal-order-shipping-fee').textContent = fee || '0 VNĐ';
        }
        if (document.getElementById('modal-order-distance')) {
            document.getElementById('modal-order-distance').textContent = distance || 'Nội thành';
        }
        if (document.getElementById('modal-order-ghn-code')) {
            document.getElementById('modal-order-ghn-code').textContent = ghnCode || 'Chưa tạo mã';
        }
        document.getElementById('modal-order-detail').classList.remove('hidden');
    }

    function closeOrderDetailModal() {
        document.getElementById('modal-order-detail').classList.add('hidden');
    }

    // Category modal
    function openEditCategoryModal(id, name, country, desc) {
        document.getElementById('form-edit-category-action').action = '/admin/danh-muc/' + id + '/update';
        document.getElementById('edit-cat-name').value = name;
        document.getElementById('edit-cat-country').value = country;
        document.getElementById('edit-cat-desc').value = desc || '';
        document.getElementById('modal-edit-category').classList.remove('hidden');
    }

    function closeEditCategoryModal() {
        document.getElementById('modal-edit-category').classList.add('hidden');
    }

    // Product modal
    function toggleAddProductForm() {
        const form = document.getElementById('form-add-product');
        if (form) {
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    function openAddProductModal() {
        switchAdminTab('products');
        const form = document.getElementById('form-add-product');
        if (form) {
            form.classList.remove('hidden');
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function openEditProductModal(id, name, brand, price, originalPrice, stock, movement, image) {
        document.getElementById('form-edit-product-action').action = '/admin/san-pham/' + id + '/update';
        document.getElementById('edit-prod-name').value = name;
        document.getElementById('edit-prod-brand').value = brand;
        document.getElementById('edit-prod-price').value = price;
        document.getElementById('edit-prod-orig-price').value = originalPrice || price;
        document.getElementById('edit-prod-stock').value = stock;
        document.getElementById('edit-prod-movement').value = movement || '';
        document.getElementById('edit-prod-image').value = image || '';

        // Hiển thị ảnh cũ (ảnh hiện tại)
        const oldImg = document.getElementById('edit-prod-old-image');
        const oldStatus = document.getElementById('edit-prod-old-status');
        if (oldImg) {
            oldImg.src = image || 'https://placehold.co/100x100?text=Chưa+Có+Ảnh';
        }
        if (oldStatus) {
            oldStatus.textContent = image ? 'Ảnh ban đầu' : 'Chưa có ảnh';
        }

        // Khởi tạo khung xem trước ảnh mới
        updateEditImagePreview(image || '');

        document.getElementById('modal-edit-product').classList.remove('hidden');
    }

    function updateEditImagePreview(url) {
        const previewImg = document.getElementById('edit-prod-preview-image');
        const statusText = document.getElementById('edit-prod-preview-status');
        const badge = document.getElementById('edit-prod-preview-badge');
        
        url = (url || '').trim();
        if (!url) {
            if (previewImg) previewImg.src = 'https://placehold.co/100x100?text=Trống';
            if (statusText) {
                statusText.textContent = 'Chưa có đường dẫn ảnh';
                statusText.className = 'text-[11px] text-slate-400 truncate';
            }
            if (badge) badge.classList.add('hidden');
            return;
        }

        if (badge) badge.classList.remove('hidden');
        if (previewImg) {
            previewImg.src = url;
            previewImg.onload = function() {
                if (statusText) {
                    statusText.textContent = '✓ Ảnh hiển thị tốt';
                    statusText.className = 'text-[11px] text-emerald-600 font-bold truncate';
                }
            };
        }
        if (statusText) {
            statusText.textContent = 'Đang tải ảnh...';
            statusText.className = 'text-[11px] text-blue-600 truncate';
        }
    }

    function handlePreviewError() {
        const statusText = document.getElementById('edit-prod-preview-status');
        const previewImg = document.getElementById('edit-prod-preview-image');
        const url = (document.getElementById('edit-prod-image').value || '').toLowerCase();
        if (statusText) {
            if (url.includes('google.com') || url.includes('aclk')) {
                statusText.textContent = '⚠️ Đây là link web/quảng cáo Google, không phải link ảnh trực tiếp. Hãy chuột phải vào ảnh chọn "Sao chép địa chỉ hình ảnh" (Copy image address)!';
            } else {
                statusText.textContent = '⚠️ Link ảnh lỗi hoặc bị chặn (hãy dùng link trực tiếp đuôi .jpg, .png, .webp)';
            }
            statusText.className = 'text-[11px] text-rose-600 font-semibold';
        }
        if (previewImg) {
            previewImg.src = 'https://placehold.co/100x100?text=Lỗi+Ảnh';
        }
    }

    function closeEditProductModal() {
        document.getElementById('modal-edit-product').classList.add('hidden');
    }

    // Switch Tabs Admin
    function switchAdminTab(tabKey) {
        const tabs = ['orders', 'dashboard', 'finance', 'categories', 'products', 'users', 'livechat', 'transactions', 'reports'];
        const titles = {
            'orders': 'Xử Lý & Quản Lý Đơn Hàng',
            'dashboard': 'Tổng Quan Dashboard',
            'finance': 'Báo Cáo Doanh Thu',
            'categories': 'Quản Lý Danh Mục & Thương Hiệu',
            'products': 'Quản Lý Sản Phẩm & Tồn Kho',
            'users': 'Quản Lý Người Dùng & Phân Quyền',
            'livechat': 'Tin Nhắn Livechat Khách Hàng',
            'transactions': 'Giao Dịch Thanh Toán COD',
            'reports': 'Báo Cáo Hoạt Động & Tồn Kho'
        };

        tabs.forEach(t => {
            const content = document.getElementById('tab-content-' + t);
            const btn = document.getElementById('nav-btn-' + t);
            if (content) {
                if (t === tabKey) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            }
            if (btn) {
                if (t === tabKey) {
                    btn.className = "admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 border-cyan-400 bg-slate-800 text-white font-semibold text-left";
                    const icon = btn.querySelector('i');
                    if (icon) {
                        icon.className = icon.className.replace('text-slate-400', 'text-cyan-400');
                    }
                } else {
                    btn.className = "admin-nav-btn w-full flex items-center gap-3.5 px-5 py-3 transition border-l-4 border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40 text-left";
                    const icon = btn.querySelector('i');
                    if (icon) {
                        icon.className = icon.className.replace('text-cyan-400', 'text-slate-400');
                    }
                }
            }
        });

        const titleEl = document.getElementById('admin-current-tab-title');
        if (titleEl && titles[tabKey]) {
            titleEl.textContent = titles[tabKey];
        }

        if (tabKey === 'dashboard') {
            setTimeout(initDashboardChart, 50);
        }

        if (tabKey === 'livechat') {
            loadAdminConversations();
            startAdminLivechatPolling();
        }

        if (tabKey === 'products') {
            renderProductPagination();
        }

        if (tabKey === 'transactions') {
            renderTransPagination();
        }
    }

    // =========================================================================
    // PHÂN TRANG DANH SÁCH ĐỒNG HỒ ADMIN (5 MẪU / TRANG - GỌN GÀNG, KHÔNG DÀI)
    // =========================================================================
    let productCurrentPage = 1;
    let productPerPage = 5;

    function getFilteredProductRows() {
        const searchInput = document.getElementById('admin_product_search');
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const rows = Array.from(document.querySelectorAll('.admin-product-row'));
        if (!query) return rows;
        return rows.filter(row => {
            const name = row.getAttribute('data-name') || '';
            const brand = row.getAttribute('data-brand') || '';
            const sku = row.getAttribute('data-sku') || '';
            return name.includes(query) || brand.includes(query) || sku.includes(query);
        });
    }

    function renderProductPagination() {
        const allRows = Array.from(document.querySelectorAll('.admin-product-row'));
        const filteredRows = getFilteredProductRows();
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / productPerPage) || 1;

        if (productCurrentPage > totalPages) {
            productCurrentPage = totalPages;
        }
        if (productCurrentPage < 1) {
            productCurrentPage = 1;
        }

        // Ẩn tất cả các rows trước
        allRows.forEach(r => r.style.display = 'none');

        // Hiển thị các rows thuộc trang hiện tại
        const startIndex = (productCurrentPage - 1) * productPerPage;
        const endIndex = Math.min(startIndex + productPerPage, totalItems);

        for (let i = startIndex; i < endIndex; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        // Cập nhật text số lượng
        const rangeEl = document.getElementById('product-page-range');
        const totalEl = document.getElementById('product-page-total');
        const countHeaderEl = document.getElementById('product-total-count');
        if (rangeEl && totalEl) {
            if (totalItems === 0) {
                rangeEl.textContent = '0 - 0';
            } else {
                rangeEl.textContent = `${startIndex + 1} - ${endIndex}`;
            }
            totalEl.textContent = totalItems;
        }
        if (countHeaderEl) {
            countHeaderEl.textContent = `${totalItems} mẫu đồng hồ`;
        }

        // Render các nút bấm phân trang
        const container = document.getElementById('product-pagination-buttons');
        if (!container) return;
        container.innerHTML = '';

        if (totalPages <= 1) {
            return;
        }

        // Nút Trước
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = productCurrentPage === 1 
            ? 'px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1'
            : 'px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition shadow-xs text-xs flex items-center gap-1 cursor-pointer';
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i> Trước';
        prevBtn.disabled = (productCurrentPage === 1);
        prevBtn.onclick = () => {
            if (productCurrentPage > 1) {
                productCurrentPage--;
                renderProductPagination();
                document.getElementById('tab-content-products')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
        container.appendChild(prevBtn);

        // Các nút số trang
        for (let p = 1; p <= totalPages; p++) {
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            if (p === productCurrentPage) {
                pageBtn.className = 'w-8 h-8 rounded-lg bg-[#182234] text-white font-bold flex items-center justify-center shadow-xs text-xs';
            } else {
                pageBtn.className = 'w-8 h-8 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium flex items-center justify-center transition shadow-xs text-xs cursor-pointer';
            }
            pageBtn.textContent = p;
            pageBtn.onclick = () => {
                productCurrentPage = p;
                renderProductPagination();
                document.getElementById('tab-content-products')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
            container.appendChild(pageBtn);
        }

        // Nút Sau
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = productCurrentPage === totalPages
            ? 'px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1'
            : 'px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition shadow-xs text-xs flex items-center gap-1 cursor-pointer';
        nextBtn.innerHTML = 'Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = (productCurrentPage === totalPages);
        nextBtn.onclick = () => {
            if (productCurrentPage < totalPages) {
                productCurrentPage++;
                renderProductPagination();
                document.getElementById('tab-content-products')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
        container.appendChild(nextBtn);
    }

    function filterAdminProducts() {
        productCurrentPage = 1;
        renderProductPagination();
    }

    function changeProductPerPage(val) {
        productPerPage = parseInt(val, 10) || 5;
        productCurrentPage = 1;
        renderProductPagination();
    }

    // =========================================================================
    // PHÂN TRANG DANH SÁCH GIAO DỊCH (5 GIAO DỊCH / TRANG - GỌN GÀNG, CHIA TRANG)
    // =========================================================================
    let transCurrentPage = 1;
    let transPerPage = 5;

    function renderTransPagination() {
        const allRows = Array.from(document.querySelectorAll('.admin-trans-row'));
        const totalItems = allRows.length;
        const totalPages = Math.ceil(totalItems / transPerPage) || 1;

        if (transCurrentPage > totalPages) {
            transCurrentPage = totalPages;
        }
        if (transCurrentPage < 1) {
            transCurrentPage = 1;
        }

        // Ẩn tất cả các rows trước
        allRows.forEach(r => r.style.display = 'none');

        // Hiển thị các rows thuộc trang hiện tại
        const startIndex = (transCurrentPage - 1) * transPerPage;
        const endIndex = Math.min(startIndex + transPerPage, totalItems);

        for (let i = startIndex; i < endIndex; i++) {
            if (allRows[i]) {
                allRows[i].style.display = '';
            }
        }

        // Cập nhật text số lượng
        const rangeEl = document.getElementById('trans-page-range');
        const totalEl = document.getElementById('trans-page-total');
        const summaryTotalEl = document.getElementById('trans-summary-total');
        const titleCountEl = document.getElementById('trans-title-count');
        if (rangeEl && totalEl) {
            if (totalItems === 0) {
                rangeEl.textContent = '0 - 0';
            } else {
                rangeEl.textContent = `${startIndex + 1} - ${endIndex}`;
            }
            totalEl.textContent = totalItems;
        }
        if (summaryTotalEl) summaryTotalEl.textContent = totalItems;
        if (titleCountEl) titleCountEl.textContent = `${totalItems} đơn`;

        // Render các nút bấm phân trang
        const container = document.getElementById('trans-pagination-buttons');
        if (!container) return;
        container.innerHTML = '';

        if (totalPages <= 1) {
            return;
        }

        // Nút Trước
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = transCurrentPage === 1 
            ? 'px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1'
            : 'px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition shadow-xs text-xs flex items-center gap-1 cursor-pointer';
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-[10px]"></i> Trước';
        prevBtn.disabled = (transCurrentPage === 1);
        prevBtn.onclick = () => {
            if (transCurrentPage > 1) {
                transCurrentPage--;
                renderTransPagination();
                document.getElementById('tab-content-transactions')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
        container.appendChild(prevBtn);

        // Các nút số trang
        for (let p = 1; p <= totalPages; p++) {
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            if (p === transCurrentPage) {
                pageBtn.className = 'w-8 h-8 rounded-lg bg-[#182234] text-white font-bold flex items-center justify-center shadow-xs text-xs';
            } else {
                pageBtn.className = 'w-8 h-8 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium flex items-center justify-center transition shadow-xs text-xs cursor-pointer';
            }
            pageBtn.textContent = p;
            pageBtn.onclick = () => {
                transCurrentPage = p;
                renderTransPagination();
                document.getElementById('tab-content-transactions')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            };
            container.appendChild(pageBtn);
        }

        // Nút Sau
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = transCurrentPage === totalPages
            ? 'px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1'
            : 'px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition shadow-xs text-xs flex items-center gap-1 cursor-pointer';
        nextBtn.innerHTML = 'Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>';
        nextBtn.disabled = (transCurrentPage === totalPages);
        nextBtn.onclick = () => {
            if (transCurrentPage < totalPages) {
                transCurrentPage++;
                renderTransPagination();
                document.getElementById('tab-content-transactions')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
        container.appendChild(nextBtn);
    }

    function changeTransPerPage(val) {
        transPerPage = parseInt(val, 10) || 5;
        transCurrentPage = 1;
        renderTransPagination();
    }

    // =========================================================================
    // ADMIN LIVECHAT CONTROLLER (KẾT NỐI DATABASE THỰC & ĐỒNG BỘ 2 CHIỀU)
    // =========================================================================
    let currentAdminConversationId = null;
    let adminChatsFilterKeyword = '';
    let adminConversationsList = [];
    let adminLivechatPollingTimer = null;

    function initAdminLivechat() {
        loadAdminConversations();
        startAdminLivechatPolling();
    }

    function startAdminLivechatPolling() {
        if (adminLivechatPollingTimer) clearInterval(adminLivechatPollingTimer);
        adminLivechatPollingTimer = setInterval(() => {
            loadAdminConversations(true);
        }, 2500);
    }

    function loadAdminConversations(isSilent = false) {
        fetch('{{ route("admin.livechat.conversations") }}')
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                adminConversationsList = data.conversations || [];
                
                // Cập nhật số lượng khách
                const badgeEl = document.getElementById('admin-chat-count-badge');
                if (badgeEl) {
                    badgeEl.textContent = adminConversationsList.length + ' khách';
                }

                // Nếu chưa chọn hội thoại nào hoặc hội thoại hiện tại không còn, chọn hội thoại đầu tiên
                if (!currentAdminConversationId && adminConversationsList.length > 0) {
                    currentAdminConversationId = adminConversationsList[0].id;
                    renderAdminActiveConversation(adminConversationsList[0]);
                    loadAdminConversationMessages(currentAdminConversationId);
                } else if (currentAdminConversationId) {
                    const activeConv = adminConversationsList.find(c => c.id === currentAdminConversationId);
                    if (activeConv) {
                        renderAdminActiveConversation(activeConv);
                        // Tải tin nhắn mới cho hội thoại đang chọn
                        loadAdminConversationMessages(currentAdminConversationId, true);
                    }
                }

                renderAdminConversationsList();
            })
            .catch(err => {
                if (!isSilent) console.error("Lỗi tải hội thoại:", err);
            });
    }

    function renderAdminConversationsList() {
        const container = document.getElementById('admin-chat-customers-list');
        if (!container) return;

        const filtered = adminConversationsList.filter(c => {
            if (!adminChatsFilterKeyword) return true;
            return (c.name || '').toLowerCase().includes(adminChatsFilterKeyword) ||
                   (c.product?.name || '').toLowerCase().includes(adminChatsFilterKeyword) ||
                   (c.preview || '').toLowerCase().includes(adminChatsFilterKeyword);
        });

        if (filtered.length === 0) {
            container.innerHTML = '<div class="p-6 text-center text-xs text-slate-400">Không tìm thấy khách hàng nào.</div>';
            return;
        }

        container.innerHTML = filtered.map(conv => {
            const isActive = conv.id === currentAdminConversationId;
            const activeClasses = isActive 
                ? 'bg-blue-50/90 border-blue-500 ring-1 ring-blue-500 shadow-sm' 
                : 'bg-white border-slate-200 hover:border-slate-300 hover:bg-slate-50/50 shadow-2xs';

            const badgeBg = conv.unread_count > 0 ? 'bg-rose-100 text-rose-700 font-bold animate-pulse' :
                           conv.badge === 'Khách VIP' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700';

            const prodName = conv.product?.name || 'Hỏi tư vấn đồng hồ';

            return `
                <div onclick="selectAdminConversation('${conv.id}')" 
                    class="p-3 rounded-xl border ${activeClasses} cursor-pointer transition duration-150 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full ${conv.avatar_bg || 'bg-blue-600'} text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">
                                ${conv.avatar || 'K'}
                            </div>
                            <span class="font-bold text-xs ${isActive ? 'text-blue-900' : 'text-slate-900'}">${escapeAdminHtml(conv.name)}</span>
                        </div>
                        <span class="text-[10px] text-slate-400">${conv.time || ''}</span>
                    </div>

                    <!-- Inquired Product Tag -->
                    <div class="text-[11px] font-medium text-slate-700 flex items-center gap-1.5 truncate">
                        <span class="text-amber-500 text-[10px]"><i class="fa-solid fa-tag"></i></span>
                        <span class="truncate">${escapeAdminHtml(prodName)}</span>
                    </div>

                    <!-- Message Preview -->
                    <div class="text-[11px] text-slate-500 truncate">
                        ${escapeAdminHtml(conv.preview || '')}
                    </div>

                    <div class="flex items-center justify-between pt-0.5">
                        <span class="inline-block px-2 py-0.5 rounded-full ${badgeBg} text-[9px]">
                            ${conv.unread_count > 0 ? (conv.unread_count + ' tin mới') : conv.badge}
                        </span>
                        ${isActive ? '<span class="text-[10px] font-bold text-blue-600 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px]"></i> Đang xem</span>' : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function selectAdminConversation(conversationId) {
        currentAdminConversationId = conversationId;
        const conv = adminConversationsList.find(c => c.id === conversationId);
        if (conv) {
            renderAdminActiveConversation(conv);
            loadAdminConversationMessages(conversationId);
            renderAdminConversationsList();
        }
        setTimeout(() => {
            document.getElementById('admin-chat-input')?.focus();
        }, 50);
    }

    function renderAdminActiveConversation(conv) {
        const avatarEl = document.getElementById('admin-chat-active-avatar');
        const nameEl = document.getElementById('admin-chat-active-name');
        const statusEl = document.getElementById('admin-chat-active-status');
        const contactEl = document.getElementById('admin-chat-active-contact');
        
        if (avatarEl) {
            avatarEl.className = `w-10 h-10 rounded-full ${conv.avatar_bg || 'bg-blue-600'} text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-xs`;
            avatarEl.innerHTML = conv.avatar || 'K';
        }
        if (nameEl) nameEl.textContent = conv.name;
        if (statusEl) {
            statusEl.textContent = conv.unread_count > 0 ? 'Có tin mới' : 'Trực tuyến';
            statusEl.className = `px-2 py-0.5 rounded-full text-[10px] font-bold ${
                conv.unread_count > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700'
            }`;
        }
        if (contactEl) {
            contactEl.innerHTML = `
                <span><i class="fa-solid fa-phone text-[10px] text-slate-400 mr-1"></i>${conv.phone || 'Chưa có SĐT'}</span>
                <span>•</span>
                <span><i class="fa-solid fa-envelope text-[10px] text-slate-400 mr-1"></i>${conv.email || 'Chưa có Email'}</span>
            `;
        }

        // Product Box
        const prodImg = document.getElementById('admin-chat-product-img');
        const prodName = document.getElementById('admin-chat-product-name');
        const prodPrice = document.getElementById('admin-chat-product-price');

        if (conv.product) {
            if (prodName) prodName.textContent = conv.product.name;
            if (prodPrice) prodPrice.textContent = conv.product.price;
            if (prodImg && conv.product.image) {
                prodImg.src = conv.product.image;
            }
        } else {
            if (prodName) prodName.textContent = 'Hỗ trợ tư vấn chung';
            if (prodPrice) prodPrice.textContent = 'Trực tuyến 24/7';
            if (prodImg) prodImg.src = 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=160&auto=format&fit=crop&q=80';
        }

        const input = document.getElementById('admin-chat-input');
        if (input) {
            input.placeholder = `Nhập tin nhắn phản hồi cho ${conv.name}...`;
        }
    }

    let lastLoadedConversationId = null;
    let lastLoadedMessagesCount = -1;

    function loadAdminConversationMessages(conversationId, isSilent = false) {
        if (!conversationId) return;

        fetch('{{ route("admin.livechat.messages") }}?conversation_id=' + encodeURIComponent(conversationId))
            .then(res => res.json())
            .then(data => {
                if (!data.success) return;
                const container = document.getElementById('admin-chat-messages-container');
                if (!container) return;

                const messages = data.messages || [];
                const isDifferentConv = (lastLoadedConversationId !== conversationId);
                const isDifferentCount = (messages.length !== lastLoadedMessagesCount);

                if (isDifferentConv || isDifferentCount || !isSilent) {
                    lastLoadedConversationId = conversationId;
                    lastLoadedMessagesCount = messages.length;

                    if (messages.length === 0) {
                        container.innerHTML = '<div class="py-12 text-center text-xs text-slate-400">Chưa có tin nhắn nào trong cuộc hội thoại này.</div>';
                        return;
                    }

                    container.innerHTML = messages.map(msg => {
                        const isAdmin = msg.sender === 'admin';
                        if (isAdmin) {
                            return `
                                <div class="flex items-start justify-end gap-2.5">
                                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none text-xs max-w-md shadow-sm space-y-1">
                                        <div class="flex items-center justify-between gap-3 text-[10px] text-blue-200 font-semibold">
                                            <span>${escapeAdminHtml(msg.sender_name || 'Shop Admin')}</span>
                                            <span>${msg.time}</span>
                                        </div>
                                        <p class="leading-relaxed">${escapeAdminHtml(msg.text)}</p>
                                    </div>
                                    <div class="w-7 h-7 rounded-full bg-slate-900 text-amber-400 font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs border border-slate-700">
                                        A
                                    </div>
                                </div>
                            `;
                        } else {
                            return `
                                <div class="flex items-start gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs">
                                        ${escapeAdminHtml((msg.sender_name || 'K').charAt(0))}
                                    </div>
                                    <div class="bg-white border border-slate-200 text-slate-800 p-3 rounded-2xl rounded-tl-none text-xs max-w-md shadow-2xs space-y-1">
                                        <div class="flex items-center justify-between gap-3 text-[10px] text-slate-500 font-semibold">
                                            <span class="text-slate-900 font-bold">${escapeAdminHtml(msg.sender_name || 'Khách Hàng')}</span>
                                            <span>${msg.time}</span>
                                        </div>
                                        <p class="leading-relaxed">${escapeAdminHtml(msg.text)}</p>
                                    </div>
                                </div>
                            `;
                        }
                    }).join('');

                    container.scrollTop = container.scrollHeight;
                }
            })
            .catch(err => {
                if (!isSilent) console.error("Lỗi tải tin nhắn cuộc hội thoại:", err);
            });
    }

    function handleAdminSendMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('admin-chat-input');
        if (!input || !input.value.trim() || !currentAdminConversationId) return;

        const text = input.value.trim();
        input.value = '';

        const container = document.getElementById('admin-chat-messages-container');
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

        // Optimistic UI
        if (container) {
            const tempHtml = `
                <div class="flex items-start justify-end gap-2.5">
                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none text-xs max-w-md shadow-sm space-y-1">
                        <div class="flex items-center justify-between gap-3 text-[10px] text-blue-200 font-semibold">
                            <span>Shop Admin</span>
                            <span>${timeStr}</span>
                        </div>
                        <p class="leading-relaxed">${escapeAdminHtml(text)}</p>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-slate-900 text-amber-400 font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs border border-slate-700">
                        A
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', tempHtml);
            container.scrollTop = container.scrollHeight;
        }

        // Gửi tới Database thật qua Backend API
        fetch('{{ route("admin.livechat.reply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                conversation_id: currentAdminConversationId,
                message: text
            })
        })
        .then(res => res.json())
        .then(res => {
            loadAdminConversations(true);
        })
        .catch(err => {
            console.error("Lỗi gửi phản hồi của Admin:", err);
        });
    }

    function filterAdminChats(keyword) {
        adminChatsFilterKeyword = (keyword || '').toLowerCase().trim();
        renderAdminConversationsList();
    }

    function fillAdminReplyText(text) {
        const input = document.getElementById('admin-chat-input');
        if (input) {
            input.value = text;
            input.focus();
        }
    }

    function escapeAdminHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.innerText = text;
        return div.innerHTML;
    }

    // =========================================================================
    // BIỂU ĐỒ DASHBOARD TỔNG QUAN (LINE CHART 2 ĐƯỜNG CONG DOANH THU & ĐƠN HÀNG)
    // =========================================================================
    const dashDataSets = {
        '7days': {
            labels: @json($dash7DaysLabels ?? []),
            revenues: @json($dash7DaysRevenues ?? []),
            orders: @json($dash7DaysOrders ?? [])
        },
        'month': {
            labels: @json($dashMonthLabels ?? []),
            revenues: @json($dashMonthRevenues ?? []),
            orders: @json($dashMonthOrders ?? [])
        },
        'year': {
            labels: @json($dashYearLabels ?? []),
            revenues: @json($dashYearRevenues ?? []),
            orders: @json($dashYearOrders ?? [])
        }
    };

    let dashboardChartInstance = null;
    let currentDashPeriod = '7days';

    function initDashboardChart() {
        const canvas = document.getElementById('dashboardRevenueOrderChart');
        if (!canvas) return;
        if (typeof Chart === 'undefined') return;

        if (dashboardChartInstance) {
            dashboardChartInstance.resize();
            return;
        }

        const data = dashDataSets[currentDashPeriod] || dashDataSets['7days'];

        // Gradient nền cam nhẹ cho Doanh thu
        const ctx = canvas.getContext('2d');
        const orangeGradient = ctx.createLinearGradient(0, 0, 0, 300);
        orangeGradient.addColorStop(0, 'rgba(249, 115, 22, 0.25)');
        orangeGradient.addColorStop(1, 'rgba(249, 115, 22, 0.01)');

        dashboardChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Doanh thu (tỷ VNĐ)',
                        data: data.revenues,
                        borderColor: '#f97316',
                        backgroundColor: orangeGradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#f97316',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.38,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Số lượng đơn hàng',
                        data: data.orders,
                        borderColor: '#2563eb',
                        backgroundColor: 'transparent',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.38,
                        fill: false,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#f8fafc',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return ' Doanh thu: ' + context.parsed.y + ' tỷ VNĐ';
                                } else {
                                    return ' Đơn hàng: ' + context.parsed.y + ' đơn';
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(226, 232, 240, 0.7)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11, weight: '500' }
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Đơn vị tỷ VNĐ',
                            color: '#64748b',
                            font: { size: 11, weight: 'bold' }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.7)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11 },
                            callback: function(value) {
                                return value + ' tỷ';
                            }
                        },
                        min: 0,
                        suggestedMax: 2.5
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Số lượng đơn hàng',
                            color: '#64748b',
                            font: { size: 11, weight: 'bold' }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: { size: 11 },
                            precision: 0,
                            callback: function(value) {
                                return value + ' đơn';
                            }
                        },
                        min: 0,
                        suggestedMax: 15
                    }
                }
            }
        });
    }

    function updateDashboardPeriod(period) {
        currentDashPeriod = period;
        ['7days', 'month', 'year'].forEach(p => {
            const btn = document.getElementById('btn-period-' + p);
            if (btn) {
                if (p === period) {
                    btn.className = "period-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition shadow-xs bg-blue-100 text-blue-700 border border-blue-300";
                } else {
                    btn.className = "period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition";
                }
            }
        });

        if (dashboardChartInstance && dashDataSets[period]) {
            const d = dashDataSets[period];
            dashboardChartInstance.data.labels = d.labels;
            dashboardChartInstance.data.datasets[0].data = d.revenues;
            dashboardChartInstance.data.datasets[1].data = d.orders;
            dashboardChartInstance.update();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initDashboardChart, 100);
        initAdminLivechat();
        renderProductPagination();
        renderTransPagination();
    });
</script>
