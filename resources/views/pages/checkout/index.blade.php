@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng | ChronoLux')

@section('content')

<div class="bg-slate-100 min-h-screen py-8 sm:py-12 text-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header: Thanh toán đơn hàng (Chuẩn Ảnh Mẫu 2) -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-sans tracking-tight">Thanh toán đơn hàng</h1>
        </div>

        <!-- Thông báo Đặt hàng thành công nếu có (Chuẩn Ảnh Mẫu 2) -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-[#d1e7dd] border border-[#badbcc] text-[#0f5132] font-semibold text-sm flex items-center gap-2.5 shadow-xs">
                <i class="fa-solid fa-circle-check text-base text-[#0f5132]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 font-semibold text-sm flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- CỘT TRÁI: Thông tin giao hàng (Chuẩn Ảnh Mẫu 2) -->
                <div class="lg:col-span-7 bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
                    <h2 class="text-xl font-bold text-slate-900 pb-2 border-b border-slate-100">Thông tin giao hàng</h2>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên *</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', '') }}" required placeholder="Nhập họ và tên người nhận" 
                            class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#198754] focus:outline-none transition">
                        @error('customer_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại *</label>
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone', '') }}" required placeholder="Nhập số điện thoại nhận hàng" 
                            class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#198754] focus:outline-none transition">
                        @error('customer_phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                            <span>Tỉnh / Thành *</span>
                            <span class="text-[11px] text-[#198754] font-medium"><i class="fa-solid fa-truck-fast"></i> GHN API</span>
                        </label>
                        <select id="province_select" name="province_id" required 
                            class="w-full bg-white border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:border-[#198754] focus:outline-none cursor-pointer">
                            <option value="">-- Chọn Tỉnh / Thành phố --</option>
                            @if(isset($provinces) && is_array($provinces))
                                @foreach($provinces as $p)
                                    <option value="{{ $p['ProvinceID'] }}" data-name="{{ $p['ProvinceName'] }}" {{ old('province_id') == $p['ProvinceID'] ? 'selected' : '' }}>
                                        {{ $p['ProvinceName'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <input type="hidden" name="city" id="city_name_input" value="{{ old('city', '') }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Quận / Huyện *</label>
                        <select id="district_select" name="to_district_id" required disabled 
                            class="w-full bg-white border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:border-[#198754] focus:outline-none cursor-pointer disabled:bg-[#e9ecef] disabled:opacity-75">
                            <option value="">-- Chọn Tỉnh/Thành trước --</option>
                        </select>
                        <input type="hidden" name="district" id="district_name_input" value="{{ old('district') }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Phường / Xã *</label>
                        <select id="ward_select" name="to_ward_code" required disabled 
                            class="w-full bg-white border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:border-[#198754] focus:outline-none cursor-pointer disabled:bg-[#e9ecef] disabled:opacity-75">
                            <option value="">-- Chọn Quận/Huyện trước --</option>
                        </select>
                        <input type="hidden" name="ward" id="ward_name_input" value="{{ old('ward', '') }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ chi tiết *</label>
                        <input type="text" name="shipping_address" id="shipping_address_input" value="{{ old('shipping_address', '') }}" required placeholder="Nhập số nhà, tên đường, thôn/xóm..." 
                            class="w-full bg-white border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:border-[#198754] focus:outline-none transition">
                        @error('shipping_address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Lựa chọn Hình Thức Thanh Toán (MoMo / Chuyển khoản VietQR / COD) -->
                    <div class="pt-3 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Hình thức thanh toán *</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-[#ced4da] bg-white cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="payment_method" value="momo" id="radio_payment_momo" checked class="text-[#198754] focus:ring-[#198754]">
                                <div>
                                    <div class="font-bold text-sm text-slate-800 flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full bg-[#d82d8b] text-white flex items-center justify-center text-[10px] font-bold">M</span>
                                        <span>Ví điện tử MoMo (MoMo Demo)</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500">Cổng thanh toán MoMo Sandbox Demo tự động xác nhận đơn hàng.</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3 rounded-lg border border-[#ced4da] bg-white cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="payment_method" value="banking" id="radio_payment_banking" class="text-[#198754] focus:ring-[#198754]">
                                <div>
                                    <div class="font-bold text-sm text-slate-800">📱 Chuyển khoản VietQR (Quét mã tự động 24/7)</div>
                                    <div class="text-[11px] text-slate-500">Mã VietQR Techcombank tự động cập nhật số tiền để quét thanh toán nhanh.</div>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3 rounded-lg border border-[#ced4da] bg-white cursor-pointer hover:bg-slate-50 transition">
                                <input type="radio" name="payment_method" value="cod" id="radio_payment_cod" class="text-[#198754] focus:ring-[#198754]">
                                <div>
                                    <div class="font-bold text-sm text-slate-800">💵 Thanh toán trực tiếp khi nhận hàng (COD)</div>
                                    <div class="text-[11px] text-slate-500">Kiểm tra đồng hồ, tem bảo hành chính hãng trước khi trả tiền.</div>
                                </div>
                            </label>

                            <!-- VietQR Preview Box khi chọn Chuyển khoản -->
                            <div id="vietqr_preview_box" class="hidden mt-3 p-4 rounded-xl bg-[#f0f9ff] border border-[#bae6fd] space-y-3">
                                <div class="flex items-center justify-between pb-2 border-b border-sky-200">
                                    <span class="text-xs font-bold text-[#0369a1] flex items-center gap-1.5">
                                        <i class="fa-solid fa-qrcode text-base"></i> Quét mã VietQR Chuyển Khoản
                                    </span>
                                    <span class="text-[10px] bg-white text-[#0369a1] px-2 py-0.5 rounded font-bold border border-sky-300">Hỗ trợ 40+ Ngân hàng</span>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <img id="vietqr_preview_img" src="{{ $vietQrPreviewUrl ?? 'https://img.vietqr.io/image/TCB-19036789999999-compact2.png' }}" alt="VietQR" class="w-36 h-36 rounded-lg bg-white p-2 border border-sky-200 shadow-xs">
                                    <div class="text-xs text-slate-700 space-y-1.5 flex-1">
                                        <div><strong>Ngân hàng:</strong> Techcombank (TCB)</div>
                                        <div><strong>Số tài khoản:</strong> <span class="font-mono font-bold text-[#0284c7]">{{ $accountNo ?? '19036789999999' }}</span></div>
                                        <div><strong>Chủ tài khoản:</strong> {{ $accountName ?? 'CHRONOLUX VIETNAM' }}</div>
                                        <div><strong>Số tiền:</strong> <span id="vietqr_amount_text" class="font-bold text-[#dc3545]">{{ number_format($total, 0, ',', '.') }} VNĐ</span></div>
                                        <div class="text-[10px] text-slate-500 italic">* Sau khi bấm Xác Nhận Đặt Hàng, đơn sẽ được ghi nhận và hiển thị hóa đơn thanh toán chi tiết.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Inputs Lưu Trữ Dữ Liệu GHN -->
                    <input type="hidden" name="shipping_fee" id="shipping_fee_input" value="0">
                    <input type="hidden" name="shipping_distance" id="shipping_distance_input" value="0">
                    <input type="hidden" id="total_price_input" value="{{ max(0, $subtotal - $discount) }}">
                </div>

                <!-- CỘT PHẢI: Chi tiết giỏ hàng & Tính tiền GHN (Chuẩn Ảnh Mẫu 2) -->
                <div class="lg:col-span-5 bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
                    <h2 class="text-xl font-bold text-slate-900 pb-2 border-b border-slate-100">Chi tiết giỏ hàng</h2>

                    <!-- Danh sách sản phẩm (Chuẩn Ảnh Mẫu 2) -->
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-baseline py-2 text-sm border-b border-slate-100">
                                <span class="font-normal text-slate-800 leading-snug">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span class="font-normal text-slate-900 whitespace-nowrap ml-3">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Bảng tính tiền & Phí vận chuyển GHN (Chuẩn Ảnh Mẫu 2) -->
                    <div class="space-y-3 pt-3 border-t border-slate-200 text-sm">
                        <div class="flex justify-between items-center text-slate-800">
                            <span>Tiền hàng:</span>
                            <strong class="font-bold text-slate-900">{{ number_format($subtotal, 0, ',', '.') }} VNĐ</strong>
                        </div>

                        <div class="flex justify-between items-center text-slate-800">
                            <span>Phí vận chuyển:</span>
                            <strong id="shipping_fee_text" class="font-bold text-slate-900">53.900 VNĐ</strong>
                        </div>

                        <!-- Thẻ hiển thị khoảng cách km & lộ trình từ GHN -->
                        <div id="shipping_info_box" class="p-3 rounded-lg bg-[#e8f5e9] border border-[#c8e6c9] text-xs text-[#2e7d32] space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="font-medium"><i class="fa-solid fa-route"></i> Khoảng cách vận chuyển:</span>
                                <strong id="distance_text" class="font-bold">~15 km</strong>
                            </div>
                            <div class="flex justify-between items-center text-[11px] text-[#388e3c]">
                                <span>Thời gian giao hàng:</span>
                                <span id="leadtime_text">Hỏa tốc trong ngày (2 - 4 giờ)</span>
                            </div>
                        </div>

                        <!-- Tổng thanh toán màu đỏ nổi bật (Chuẩn Ảnh Mẫu 2) -->
                        <div class="border-t border-slate-300 pt-4 flex justify-between items-baseline">
                            <span class="text-base font-bold text-slate-900">Tổng thanh toán:</span>
                            <span id="final_total_text" class="text-2xl font-black text-[#dc3545]">
                                {{ number_format($total + 53900, 0, ',', '.') }} VNĐ
                            </span>
                        </div>
                    </div>

                    <!-- Nút Xác Nhận Đặt Hàng Màu Xanh Lá (Chuẩn Ảnh Mẫu 2) -->
                    <div class="pt-4">
                        <button type="submit" id="submit_order_btn" class="w-full py-3.5 px-4 bg-[#198754] hover:bg-[#157347] text-white font-bold text-base rounded-lg shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-check"></i>
                            <span>Xác Nhận Đặt Hàng</span>
                        </button>
                    </div>

                    <div class="text-[11px] text-slate-400 text-center leading-relaxed pt-2">
                        Cam kết 100% đồng hồ chính hãng ChronoLux, bảo hành 5 năm toàn diện.
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: TÍCH HỢP TÍNH CƯỚC GHN THEO ĐỊA CHỈ & KHOẢNG CÁCH (KM)        -->
<!-- ========================================================================= -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById('province_select');
    const districtSelect = document.getElementById('district_select');
    const wardSelect = document.getElementById('ward_select');
    const shippingFeeText = document.getElementById('shipping_fee_text');
    const finalTotalText = document.getElementById('final_total_text');
    const totalPriceInput = document.getElementById('total_price_input');
    const shippingFeeInput = document.getElementById('shipping_fee_input');
    const shippingDistanceInput = document.getElementById('shipping_distance_input');
    const cityNameInput = document.getElementById('city_name_input');
    const districtNameInput = document.getElementById('district_name_input');

    const shippingInfoBox = document.getElementById('shipping_info_box');
    const distanceText = document.getElementById('distance_text');
    const leadtimeText = document.getElementById('leadtime_text');

    const radioMomo = document.getElementById('radio_payment_momo');
    const radioBanking = document.getElementById('radio_payment_banking');
    const radioCod = document.getElementById('radio_payment_cod');
    const vietqrPreviewBox = document.getElementById('vietqr_preview_box');
    const vietqrAmountText = document.getElementById('vietqr_amount_text');
    const vietqrPreviewImg = document.getElementById('vietqr_preview_img');
    const wardNameInput = document.getElementById('ward_name_input');

    function togglePaymentPreview() {
        if (radioBanking && radioBanking.checked) {
            if (vietqrPreviewBox) vietqrPreviewBox.classList.remove('hidden');
        } else {
            if (vietqrPreviewBox) vietqrPreviewBox.classList.add('hidden');
        }
    }

    if (radioMomo) radioMomo.addEventListener('change', togglePaymentPreview);
    if (radioBanking) radioBanking.addEventListener('change', togglePaymentPreview);
    if (radioCod) radioCod.addEventListener('change', togglePaymentPreview);

    const districtsUrl = "{{ route('locations.districts', ['provinceId' => '__PROVINCE__']) }}";
    const wardsUrl = "{{ route('locations.wards', ['districtId' => '__DISTRICT__']) }}";
    const provincesUrl = "{{ route('locations.provinces') }}";
    const feeUrl = "{{ route('locations.fee') }}";

    // Tiền hàng gốc từ giỏ hàng
    const subtotal = parseInt(totalPriceInput ? totalPriceInput.value : 0) || 0;

    // Phí mặc định ban đầu hiển thị theo mẫu (53.900 VNĐ)
    let currentFee = 53900;
    updateTotals(currentFee);

    // 1. Tải danh sách Tỉnh/Thành phố từ API GHN (nếu chưa có trong DOM hoặc cập nhật thêm)
    if (provinceSelect.options.length <= 1) {
        fetch(provincesUrl)
            .then(res => res.json())
            .then(res => {
                if (res.data && Array.isArray(res.data)) {
                    let options = '<option value="">-- Chọn Tỉnh / Thành phố --</option>';
                    res.data.sort((a, b) => a.ProvinceName.localeCompare(b.ProvinceName));
                    res.data.forEach(p => {
                        options += `<option value="${p.ProvinceID}" data-name="${p.ProvinceName}">${p.ProvinceName}</option>`;
                    });
                    provinceSelect.innerHTML = options;
                }
            })
            .catch(err => {
                console.error("Lỗi kết nối GHN:", err);
            });
    }

    // Hàm load Quận/Huyện (khi người dùng tự chọn Tỉnh/Thành)
    function loadDistricts(provinceId) {
        districtSelect.innerHTML = '<option value="">-- Đang tải Quận/Huyện... --</option>';
        districtSelect.disabled = true;
        wardSelect.innerHTML = '<option value="">-- Chọn Quận/Huyện trước --</option>';
        wardSelect.disabled = true;

        const selectedOption = provinceSelect.options[provinceSelect.selectedIndex];
        if (selectedOption && cityNameInput) {
            cityNameInput.value = selectedOption.getAttribute('data-name') || selectedOption.text;
        }

        fetch(districtsUrl.replace('__PROVINCE__', provinceId))
            .then(res => res.json())
            .then(res => {
                if (res.data && Array.isArray(res.data)) {
                    let options = '<option value="">-- Chọn Quận / Huyện --</option>';
                    res.data.sort((a, b) => a.DistrictName.localeCompare(b.DistrictName));
                    res.data.forEach(d => {
                        options += `<option value="${d.DistrictID}" data-name="${d.DistrictName}">${d.DistrictName}</option>`;
                    });
                    districtSelect.innerHTML = options;
                    districtSelect.disabled = false;
                } else {
                    districtSelect.innerHTML = '<option value="">-- Không tải được quận/huyện --</option>';
                }
            })
            .catch(err => {
                console.error("Lỗi load quận huyện:", err);
                districtSelect.disabled = false;
            });
    }

    // Hàm load Phường/Xã (khi người dùng tự chọn Quận/Huyện)
    function loadWards(districtId) {
        wardSelect.innerHTML = '<option value="">-- Đang tải Phường/Xã... --</option>';
        wardSelect.disabled = true;

        const selectedOption = districtSelect.options[districtSelect.selectedIndex];
        if (selectedOption && districtNameInput) {
            districtNameInput.value = selectedOption.getAttribute('data-name') || selectedOption.text;
        }

        fetch(wardsUrl.replace('__DISTRICT__', districtId))
            .then(res => res.json())
            .then(res => {
                if (res.data && Array.isArray(res.data)) {
                    let options = '<option value="">-- Chọn Phường / Xã --</option>';
                    res.data.sort((a, b) => a.WardName.localeCompare(b.WardName));
                    res.data.forEach(w => {
                        options += `<option value="${w.WardCode}" data-name="${w.WardName}">${w.WardName}</option>`;
                    });
                    wardSelect.innerHTML = options;
                    wardSelect.disabled = false;
                } else {
                    wardSelect.innerHTML = '<option value="">-- Không tải được phường/xã --</option>';
                }
            })
            .catch(err => {
                console.error("Lỗi load phường xã:", err);
                wardSelect.disabled = false;
            });
    }

    // Hàm tính phí qua GHN
    function calculateFee(districtId, wardCode) {
        shippingFeeText.innerHTML = '<span class="text-slate-600 font-semibold"><i class="fa-solid fa-spinner fa-spin"></i> Đang tính cước GHN...</span>';

        fetch(feeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                province_id: parseInt(provinceSelect.value) || 0,
                to_district_id: parseInt(districtId),
                to_ward_code: wardCode
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.code === 200 && res.data) {
                const fee = parseInt(res.data.total) || 53900;
                updateTotals(fee);

                if (distanceText && res.data.distance_text) {
                    distanceText.innerText = res.data.distance_text;
                }
                if (leadtimeText && res.data.leadtime_text) {
                    leadtimeText.innerText = res.data.leadtime_text;
                }
                if (shippingDistanceInput && res.data.distance_km) {
                    shippingDistanceInput.value = res.data.distance_km;
                }
            } else {
                updateTotals(53900);
            }
        })
        .catch(err => {
            console.error("Lỗi tính phí:", err);
            updateTotals(53900);
        });
    }

    // 2. Sự kiện khi người dùng đổi Tỉnh/Thành
    provinceSelect.addEventListener('change', function () {
        if (!this.value) return;
        loadDistricts(this.value);
    });

    // 3. Sự kiện khi người dùng đổi Quận/Huyện
    districtSelect.addEventListener('change', function () {
        if (!this.value) return;
        loadWards(this.value);
    });

    // 4. Sự kiện khi người dùng đổi Phường/Xã
    wardSelect.addEventListener('change', function () {
        if (!this.value || !districtSelect.value) return;
        const selectedWardOption = wardSelect.options[wardSelect.selectedIndex];
        if (selectedWardOption && wardNameInput) {
            wardNameInput.value = selectedWardOption.getAttribute('data-name') || selectedWardOption.text;
        }
        calculateFee(districtSelect.value, this.value);
    });

    // 5. Cập nhật số tiền hiển thị
    function updateTotals(fee) {
        if (shippingFeeInput) {
            shippingFeeInput.value = fee;
        }

        shippingFeeText.innerText = new Intl.NumberFormat('vi-VN').format(fee) + ' VNĐ';

        const finalAmount = subtotal + fee;
        finalTotalText.innerText = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' VNĐ';

        if (vietqrAmountText) {
            vietqrAmountText.innerText = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' VNĐ';
        }
        if (vietqrPreviewImg) {
            vietqrPreviewImg.src = `https://img.vietqr.io/image/TCB-19036789999999-compact2.png?amount=${finalAmount}&addInfo=THANH+TOAN+DON+HANG&accountName=CHRONOLUX+VIETNAM`;
        }
    }
});
</script>

@endsection
