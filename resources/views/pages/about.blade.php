@extends('layouts.app')

@section('title', 'Về Chúng Tôi - Câu Chuyện Thương Hiệu ChronoLux')

@section('content')

<div class="bg-slate-900 border-b border-slate-800 py-12 text-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <span class="font-cinzel text-amber-400 text-xs uppercase tracking-[0.3em] font-semibold">ChronoLux Heritage</span>
        <h1 class="text-3xl sm:text-4xl font-serif font-bold text-white">Hành Trình Khẳng Định Giá Trị Thời Gian</h1>
        <p class="text-xs text-slate-400 max-w-xl mx-auto">
            Hơn 14 năm gìn giữ và lan tỏa tình yêu đối với những cỗ máy thời gian cơ khí đỉnh cao tại Việt Nam.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
    
    <!-- Section 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="space-y-4">
            <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-bold">Khởi Nguồn</span>
            <h2 class="text-2xl font-serif font-bold text-white">Đam Mê Từ Những Chuyển Động Vi Sai</h2>
            <p class="text-xs text-slate-300 leading-relaxed">
                Được thành lập vào năm 2012 từ tình yêu thuần khiết với nghệ thuật chế tác đồng hồ Thụy Sĩ, ChronoLux đã phát triển thành hệ thống phân phối đồng hồ cao cấp hàng đầu tại Việt Nam.
            </p>
            <p class="text-xs text-slate-300 leading-relaxed">
                Đối với chúng tôi, đồng hồ không chỉ là một công cụ đo thời gian, mà là một tác phẩm nghệ thuật thu nhỏ trên cổ tay, thể hiện bản lĩnh, cá tính và giá trị trường tồn của người sở hữu.
            </p>
        </div>
        <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-xl">
            <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=800&auto=format&fit=crop&q=80" alt="ChronoLux Showroom" class="w-full h-80 object-cover">
        </div>
    </div>

    <!-- Core Values -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-2xl space-y-3 text-center">
            <div class="w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-stamp"></i>
            </div>
            <h3 class="font-bold text-sm text-white font-cinzel">100% Chính Hãng</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Mỗi chiếc đồng hồ đều có nguồn gốc rõ ràng, đầy đủ hóa đơn, hộp sổ và thẻ bảo hành quốc tế từ nhà sản xuất.
            </p>
        </div>

        <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-2xl space-y-3 text-center">
            <div class="w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <h3 class="font-bold text-sm text-white font-cinzel">Phòng Lab Chuẩn Thụy Sĩ</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Được trang bị máy đo độ kín nước áp suất chân không và máy căn chỉnh sai số điện tử vi sai nhập khẩu từ Thụy Sĩ.
            </p>
        </div>

        <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-2xl space-y-3 text-center">
            <div class="w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <h3 class="font-bold text-sm text-white font-cinzel">Phục Vụ Tận Tâm</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Đội ngũ chuyên viên tư vấn am hiểu sâu sắc về lịch sử các thương hiệu, sẵn sàng hỗ trợ khách hàng tìm kiếm phiên bản ưng ý nhất.
            </p>
        </div>
    </div>

</div>

@endsection
