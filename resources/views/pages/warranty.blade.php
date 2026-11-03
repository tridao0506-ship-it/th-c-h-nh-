@extends('layouts.app')

@section('title', 'Chính Sách Bảo Hành 5 Năm Vàng | ChronoLux')

@section('content')

<div class="bg-slate-900 border-b border-slate-800 py-12 text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <span class="font-cinzel text-amber-400 text-xs uppercase tracking-[0.3em] font-semibold">ChronoLux Care 5 Years</span>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-white">Chính Sách Bảo Hành 5 Năm Vàng Toàn Diện</h1>
        <p class="text-xs text-slate-400 max-w-xl mx-auto">
            Đặc quyền an tâm tuyệt đối dành riêng cho khách hàng sở hữu đồng hồ tại hệ thống ChronoLux.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <!-- 4 Pillars of Warranty -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-slate-900/90 border border-slate-800 p-6 rounded-3xl space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <h3 class="font-cinzel text-base font-bold text-white">1. Miễn Phí Lau Dầu & Căn Chỉnh Sai Số</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Đồng hồ cơ Automatic được bảo dưỡng, lau dầu máy định kỳ trọn đời hoặc trong 5 năm bởi các kỹ thuật viên giàu kinh nghiệm trên máy đo điện tử Witschi Thụy Sĩ.
            </p>
        </div>

        <div class="bg-slate-900/90 border border-slate-800 p-6 rounded-3xl space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-battery-full"></i>
            </div>
            <h3 class="font-cinzel text-base font-bold text-white">2. Miễn Phí Thay Pin Trọn Đời</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Áp dụng cho toàn bộ các dòng đồng hồ pin Quartz và năng lượng ánh sáng. Sử dụng pin Thụy Sĩ Renata chính hãng, kèm thay thế gioăng chống nước miễn phí.
            </p>
        </div>

        <div class="bg-slate-900/90 border border-slate-800 p-6 rounded-3xl space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-shield-virus"></i>
            </div>
            <h3 class="font-cinzel text-base font-bold text-white">3. Bảo Hiểm Cả Lỗi Người Dùng (Năm Đầu Tiên)</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Trong 12 tháng đầu, nếu đồng hồ gặp sự cố do va quẹt, vào nước do sơ suất hay rơi rớt, ChronoLux hỗ trợ tới 50% chi phí linh kiện chính hãng thay thế.
            </p>
        </div>

        <div class="bg-slate-900/90 border border-slate-800 p-6 rounded-3xl space-y-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-xl">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <h3 class="font-cinzel text-base font-bold text-white">4. Cam Kết Hoàn Tiền 1000%</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Nếu bất kỳ trung tâm kiểm định ủy quyền nào của hãng xác nhận sản phẩm của chúng tôi không phải hàng chính hãng, ChronoLux cam kết đền bù gấp 10 lần giá trị hóa đơn.
            </p>
        </div>

    </div>

    <!-- Process -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 space-y-6">
        <h2 class="text-xl font-serif font-bold text-white">Quy Trình Tiếp Nhận Bảo Hành Nhanh Chóng</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-slate-300">
            <div class="space-y-2">
                <span class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center">1</span>
                <div class="font-bold text-white text-sm">Gửi Đồng Hồ</div>
                <p class="text-slate-400 leading-relaxed">Mang đồng hồ tới bất kỳ showroom nào hoặc gọi Hotline 1900 8888 để nhân viên bưu tá đến tận nhà lấy hàng miễn phí.</p>
            </div>

            <div class="space-y-2">
                <span class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center">2</span>
                <div class="font-bold text-white text-sm">Kiểm Định Phòng Lab</div>
                <p class="text-slate-400 leading-relaxed">Kỹ thuật viên trưởng kiểm tra bằng thiết bị chuyên dụng và gửi video báo cáo tình trạng cho khách hàng trong 24h.</p>
            </div>

            <div class="space-y-2">
                <span class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center">3</span>
                <div class="font-bold text-white text-sm">Bàn Giao Tận Tay</div>
                <p class="text-slate-400 leading-relaxed">Đồng hồ được vệ sinh siêu âm vỏ dây sáng bóng, khử từ và bàn giao tận tay quý khách kèm phiếu kiểm chuẩn.</p>
            </div>
        </div>
    </div>

</div>

@endsection
