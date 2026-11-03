@extends('layouts.app')

@section('title', 'Liên Hệ & Hệ Thống Showroom | ChronoLux')

@section('content')

<div class="bg-slate-900 border-b border-slate-800 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2">
        <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Hệ Thống Trải Nghiệm Thực Tế</span>
        <h1 class="text-3xl font-serif font-bold text-white">Liên Hệ & Đặt Lịch Tư Vấn</h1>
        <p class="text-xs text-slate-400 max-w-md mx-auto">
            Ghé thăm không gian sang trọng của ChronoLux hoặc để lại tin nhắn để được chuyên gia hỗ trợ đo size tay và tư vấn bộ sưu tập.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left: Showrooms Info -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-5">
                <h3 class="font-cinzel text-sm font-bold text-amber-400 uppercase tracking-wider pb-3 border-b border-slate-800">
                    Hệ Thống Showroom Cao Cấp
                </h3>

                <!-- Showroom 1 -->
                <div class="space-y-1.5 text-xs">
                    <div class="font-bold text-slate-200 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400"></i> Showroom 1 - Hà Nội:
                    </div>
                    <div class="text-slate-300 pl-5">68 Phố Tràng Tiền, Quận Hoàn Kiếm, Hà Nội</div>
                    <div class="text-slate-400 pl-5 text-[11px]">Hotline: (024) 3938 8888 • Giờ mở cửa: 08:30 - 21:30</div>
                </div>

                <!-- Showroom 2 -->
                <div class="space-y-1.5 text-xs pt-3 border-t border-slate-800">
                    <div class="font-bold text-slate-200 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400"></i> Showroom 2 - TP. Hồ Chí Minh:
                    </div>
                    <div class="text-slate-300 pl-5">128 Đường Đồng Khởi, Phường Bến Nghé, Quận 1, TP. HCM</div>
                    <div class="text-slate-400 pl-5 text-[11px]">Hotline: (028) 3822 9999 • Giờ mở cửa: 09:00 - 22:00</div>
                </div>

                <!-- Showroom 3 -->
                <div class="space-y-1.5 text-xs pt-3 border-t border-slate-800">
                    <div class="font-bold text-slate-200 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400"></i> Trung Tâm Bảo Hành & Phòng Lab:
                    </div>
                    <div class="text-slate-300 pl-5">Tầng 5, Tòa Nhà ChronoLux, 15 Phố Ngô Quyền, Hoàn Kiếm, Hà Nội</div>
                    <div class="text-slate-400 pl-5 text-[11px]">Tiếp nhận thẩm định & bảo dưỡng kỹ thuật</div>
                </div>

            </div>

            <!-- Hotline quick contact -->
            <div class="bg-gradient-to-br from-amber-950/40 to-slate-900 border border-amber-500/30 rounded-3xl p-6 shadow-xl text-xs space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <div class="font-bold text-slate-100 text-sm">Tổng Đài Hỗ Trợ 24/7</div>
                        <div class="text-amber-400 font-bold text-lg">1900 8888</div>
                    </div>
                </div>
                <p class="text-slate-400 text-[11px]">
                    Hỗ trợ kiểm tra tồn kho tại showroom, đặt trước các phiên bản giới hạn hoặc yêu cầu thẩm định đồng hồ tại nhà.
                </p>
            </div>

        </div>

        <!-- Right: Contact Form -->
        <div class="lg:col-span-7">
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-8 shadow-xl space-y-6">
                <div>
                    <h2 class="text-xl font-serif font-bold text-white">Gửi Yêu Cầu Tư Vấn Trực Tuyến</h2>
                    <p class="text-xs text-slate-400 mt-1">Điền thông tin bên dưới, chuyên viên cao cấp của ChronoLux sẽ phản hồi trong 15 phút.</p>
                </div>

                <form action="{{ route('pages.contact.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Họ và tên *</label>
                            <input type="text" name="name" required placeholder="Nguyễn Văn A" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Số điện thoại liên hệ *</label>
                            <input type="tel" name="phone" required placeholder="0988 888 888" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email</label>
                            <input type="email" name="email" placeholder="example@gmail.com" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Thương hiệu quan tâm</label>
                            <select name="subject" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                                <option value="Rolex">Rolex (Thụy Sĩ)</option>
                                <option value="Omega">Omega (Thụy Sĩ)</option>
                                <option value="Patek Philippe">Patek Philippe (Thụy Sĩ)</option>
                                <option value="Hublot">Hublot (Thụy Sĩ)</option>
                                <option value="Seiko">Seiko (Nhật Bản)</option>
                                <option value="Tissot">Tissot (Thụy Sĩ)</option>
                                <option value="Khác">Tư vấn theo ngân sách</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">Nội dung cần hỗ trợ *</label>
                        <textarea name="message" rows="4" required placeholder="Vui lòng cho biết kích thước chu vi cổ tay hoặc nhu cầu đặc biệt của quý khách..." 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20">
                        Gửi Tin Nhắn Tư Vấn Ngay
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
