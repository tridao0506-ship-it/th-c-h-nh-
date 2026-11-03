@extends('admin.layout')

@section('title', 'Dashboard Tổng Quan - SHOP ADMIN')
@section('page_title', 'Tổng Quan Doanh Thu & Bán Hàng')

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Doanh Thu</span>
            <i class="fa-solid fa-coins text-amber-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-amber-400">
            {{ number_format($totalRevenue, 0, ',', '.') }} ₫
        </div>
        <span class="text-[10px] text-emerald-400 font-semibold mt-1 block">Từ {{ $totalOrders }} đơn hàng đã đặt</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Số Đơn Hàng</span>
            <i class="fa-solid fa-box text-blue-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-white">{{ $totalOrders }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">{{ $statusCounts['pending'] }} đơn chờ duyệt</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Đồng Hồ Trong Kho</span>
            <i class="fa-solid fa-clock text-purple-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-white">{{ $totalProducts }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">{{ $categories->count() ?? 8 }} Thương hiệu lớn</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tài Khoản Thành Viên</span>
            <i class="fa-solid fa-users text-emerald-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-emerald-400">
            {{ $adminTotalUsers ?? 10 }}
        </div>
        <span class="text-[10px] text-slate-400 mt-1 block">{{ $adminRoleCount ?? 1 }} Quản trị | {{ $customerRoleCount ?? 9 }} Khách</span>
    </div>

</div>

<!-- 2 Cột 70/30 Bố cục Tổng Quan theo mẫu ảnh -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-8">
    
    <!-- CỘT TRÁI (70% ~ lg:col-span-8) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- BIỂU ĐỒ THỐNG KÊ DOANH THU & ĐƠN HÀNG -->
        <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-amber-400"></i>
                    THỐNG KÊ DOANH THU & ĐƠN HÀNG
                </h3>
                
                <!-- Legend chú thích -->
                <div class="flex items-center gap-4 text-xs font-semibold">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3.5 h-3.5 rounded bg-amber-500 inline-block shadow-xs"></span>
                        <span class="text-slate-300">Doanh thu (tỷ VNĐ)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3.5 h-3.5 rounded bg-blue-500 inline-block shadow-xs"></span>
                        <span class="text-slate-300">Số lượng đơn hàng</span>
                    </div>
                </div>
            </div>

            <!-- Canvas Biểu đồ -->
            <div class="relative w-full h-[330px]">
                <canvas id="adminStandaloneChart"></canvas>
            </div>

            <!-- Bộ lọc thời gian -->
            <div class="flex flex-wrap items-center gap-2 pt-4 mt-3 border-t border-slate-800">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2">THỜI GIAN:</span>
                <button type="button" id="btn-period-7days" onclick="updateStandalonePeriod('7days')" 
                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition shadow-xs bg-blue-600 text-white">
                    7 ngày qua
                </button>
                <button type="button" id="btn-period-month" onclick="updateStandalonePeriod('month')" 
                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white bg-slate-800 border border-slate-700 hover:bg-slate-700 transition">
                    Tháng này
                </button>
                <button type="button" id="btn-period-year" onclick="updateStandalonePeriod('year')" 
                        class="period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white bg-slate-800 border border-slate-700 hover:bg-slate-700 transition">
                    Năm nay
                </button>
            </div>
        </div>

        <!-- CẢNH BÁO HỆ THỐNG & NHẮC VIỆC -->
        <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
                    CẢNH BÁO HỆ THỐNG & NHẮC VIỆC QUAN TRỌNG
                </h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    {{ $lowStockProducts->count() }} sản phẩm cần chú ý
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Cảnh báo kho -->
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 space-y-2.5">
                    <div class="flex items-center justify-between text-xs font-bold text-amber-400">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            Đồng hồ sắp hết hàng (kho ≤ 5)
                        </span>
                        <a href="{{ route('admin.products') }}" class="text-[11px] text-sky-400 hover:underline">Quản lý kho →</a>
                    </div>
                    @if($lowStockProducts->isEmpty())
                        <div class="text-xs text-slate-400 py-2">Kho hàng ổn định, không có sản phẩm nào thiếu hụt.</div>
                    @else
                        <div class="space-y-1.5">
                            @foreach($lowStockProducts->take(3) as $lsp)
                                <div class="flex items-center justify-between text-xs bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/60">
                                    <div class="truncate max-w-[210px] font-medium text-slate-200" title="{{ $lsp->name }}">
                                        {{ $lsp->name }}
                                    </div>
                                    <span class="font-bold {{ $lsp->stock == 0 ? 'text-red-400' : 'text-amber-400' }} text-[11px] whitespace-nowrap">
                                        {{ $lsp->stock == 0 ? 'Hết hàng' : 'Còn ' . $lsp->stock . ' chiếc' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Nhắc việc đơn hàng & Livechat -->
                <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 space-y-2.5">
                    <div class="flex items-center justify-between text-xs font-bold text-blue-400">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-bell"></i>
                            Nhiệm vụ cần xử lý ngay
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                                <span class="text-slate-300">Đơn chờ xử lý / đóng gói:</span>
                            </div>
                            <a href="{{ route('admin.orders') }}" class="font-bold text-sky-400 hover:underline">
                                {{ $statusCounts['pending'] + $statusCounts['processing'] }} đơn →
                            </a>
                        </div>
                        <div class="flex items-center justify-between text-xs bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/60">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                <span class="text-slate-300">Tin nhắn khách hàng:</span>
                            </div>
                            <a href="{{ url('/?view=admin&admin_tab=livechat#admin-section') }}" class="font-bold text-sky-400 hover:underline">
                                {{ $unreadLivechatCount ?? 0 }} tin nhắn →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- CỘT PHẢI (30% ~ lg:col-span-4) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- 1. ĐƠN HÀNG MỚI NHẤT -->
        <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-blue-400"></i>
                    ĐƠN HÀNG MỚI NHẤT
                </h3>
                <a href="{{ route('admin.orders') }}" class="text-xs text-sky-400 hover:underline font-medium">
                    Xem tất cả →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentOrders as $rOrder)
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
                        $dotColor = 'bg-blue-400';
                        $statusLabel = 'Đang xử lý';
                        $statusClass = 'text-blue-400 font-semibold';

                        if ($rOrder->order_status === 'completed') {
                            $dotColor = 'bg-emerald-400';
                            $statusLabel = 'Hoàn thành';
                            $statusClass = 'text-emerald-400 font-semibold';
                        } elseif ($rOrder->payment_status === 'paid') {
                            $dotColor = 'bg-emerald-400';
                            $statusLabel = 'Đã thanh toán';
                            $statusClass = 'text-emerald-400 font-semibold';
                        } elseif ($rOrder->order_status === 'pending') {
                            $dotColor = 'bg-amber-400';
                            $statusLabel = 'Chờ duyệt';
                            $statusClass = 'text-amber-400 font-semibold';
                        } elseif ($rOrder->order_status === 'shipping') {
                            $dotColor = 'bg-sky-400';
                            $statusLabel = 'Đang giao';
                            $statusClass = 'text-sky-400 font-semibold';
                        } elseif ($rOrder->order_status === 'cancelled') {
                            $dotColor = 'bg-rose-400';
                            $statusLabel = 'Đã hủy';
                            $statusClass = 'text-rose-400 font-semibold';
                        }
                    @endphp
                    <div class="flex items-center justify-between text-xs py-2 border-b border-slate-800/60 last:border-b-0 hover:bg-slate-800/40 rounded-xl px-2 transition">
                        <div class="flex items-start gap-2.5 min-w-0 pr-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }} mt-1 flex-shrink-0"></span>
                            <div class="min-w-0">
                                <div class="font-medium text-slate-200 truncate leading-snug" title="{{ $rOrder->customer_name }}">
                                    Đơn hàng #{{ $rOrder->order_code }} - {{ $rOrder->customer_name }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    <span class="font-bold text-amber-400">{{ number_format($rOrder->total_amount, 0, ',', '.') }} đ</span>
                                    <span class="text-slate-500 mx-1">•</span>
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

        <!-- 2. SẢN PHẨM BÁN CHẠY -->
        <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-fire text-amber-400"></i>
                    SẢN PHẨM BÁN CHẠY
                </h3>
            </div>

            <!-- Table Header -->
            <div class="grid grid-cols-12 text-[11px] font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-800">
                <div class="col-span-6">Sản phẩm</div>
                <div class="col-span-2 text-center">Số lượng</div>
                <div class="col-span-4 text-right">Doanh thu</div>
            </div>

            <!-- List Products -->
            <div class="divide-y divide-slate-800/60">
                @forelse($topSellingWatches as $w)
                    <div class="grid grid-cols-12 items-center py-2.5 text-xs hover:bg-slate-800/40 rounded-xl px-2 transition">
                        <div class="col-span-6 flex items-center gap-2.5 pr-2 min-w-0">
                            <img src="{{ $w->image }}" alt="{{ $w->name }}" class="w-9 h-9 rounded-lg object-cover border border-slate-700 shadow-2xs flex-shrink-0 bg-slate-800" onerror="this.src='/images/placeholder.png'">
                            <span class="font-semibold text-slate-200 truncate text-[11px]" title="{{ $w->name }}">
                                {{ $w->name }}
                            </span>
                        </div>
                        <div class="col-span-2 text-center font-bold text-white">
                            {{ $w->sold }}
                        </div>
                        <div class="col-span-4 text-right font-bold text-amber-400 text-[11px]">
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

<script>
    const standaloneDashDataSets = {
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

    let standaloneChartInstance = null;
    let currentStandalonePeriod = '7days';

    function initStandaloneChart() {
        const canvas = document.getElementById('adminStandaloneChart');
        if (!canvas) return;
        if (typeof Chart === 'undefined') return;

        if (standaloneChartInstance) {
            standaloneChartInstance.resize();
            return;
        }

        const data = standaloneDashDataSets[currentStandalonePeriod] || standaloneDashDataSets['7days'];

        const ctx = canvas.getContext('2d');
        const orangeGradient = ctx.createLinearGradient(0, 0, 0, 300);
        orangeGradient.addColorStop(0, 'rgba(249, 115, 22, 0.35)');
        orangeGradient.addColorStop(1, 'rgba(249, 115, 22, 0.02)');

        standaloneChartInstance = new Chart(canvas, {
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
                        pointBorderColor: '#182234',
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
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#182234',
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
                            color: 'rgba(51, 65, 85, 0.4)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
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
                            color: '#94a3b8',
                            font: { size: 11, weight: 'bold' }
                        },
                        grid: {
                            color: 'rgba(51, 65, 85, 0.4)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#94a3b8',
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
                            color: '#94a3b8',
                            font: { size: 11, weight: 'bold' }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#94a3b8',
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

    function updateStandalonePeriod(period) {
        currentStandalonePeriod = period;
        ['7days', 'month', 'year'].forEach(p => {
            const btn = document.getElementById('btn-period-' + p);
            if (btn) {
                if (p === period) {
                    btn.className = "period-btn px-3.5 py-1.5 rounded-lg text-xs font-bold transition shadow-xs bg-blue-600 text-white";
                } else {
                    btn.className = "period-btn px-3.5 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white bg-slate-800 border border-slate-700 hover:bg-slate-700 transition";
                }
            }
        });

        if (standaloneChartInstance && standaloneDashDataSets[period]) {
            const d = standaloneDashDataSets[period];
            standaloneChartInstance.data.labels = d.labels;
            standaloneChartInstance.data.datasets[0].data = d.revenues;
            standaloneChartInstance.data.datasets[1].data = d.orders;
            standaloneChartInstance.update();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initStandaloneChart, 100);
    });
</script>

@endsection
