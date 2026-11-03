<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\GHNService;
use App\Services\GHNOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // ==========================================
    // AJAX LOCATION & TÍNH PHÍ GHN
    // ==========================================

    public function getProvinces(GHNService $ghn)
    {
        return response()->json($ghn->getProvinces());
    }

    public function getDistricts(int $provinceId, GHNService $ghn)
    {
        return response()->json($ghn->getDistricts($provinceId));
    }

    public function getWards(int $districtId, GHNService $ghn)
    {
        return response()->json($ghn->getWards($districtId));
    }

    public function getShippingFee(Request $request, GHNService $ghn)
    {
        $cart = session('cart', []);
        $totalWeight = 0;

        foreach ($cart as $item) {
            $totalWeight += ((int) ($item['weight'] ?? 300)) * (int) ($item['quantity'] ?? 1);
        }

        if ($totalWeight <= 0) {
            $totalWeight = 300; // Trọng lượng 1 hộp đồng hồ cao cấp chuẩn
        }

        $toDistrictId = (int) $request->input('to_district_id');
        $toWardCode = (string) $request->input('to_ward_code');
        $provinceId = (int) $request->input('province_id', 0);

        $fromDistrictId = (int) config('services.ghn.from_district_id', 1489); // Hoàn Kiếm, Hà Nội

        $res = $ghn->calculateFee([
            'service_type_id' => 2, // Gói chuẩn E-commerce của GHN
            'from_district_id' => $fromDistrictId,
            'to_district_id' => $toDistrictId,
            'to_ward_code' => $toWardCode,
            'weight' => $totalWeight,
            'length' => 15,
            'width' => 15,
            'height' => 10,
        ]);

        // Ước tính khoảng cách km từ kho gửi (Hoàn Kiếm, Hà Nội) đến địa chỉ nhận
        $distanceInfo = $this->calculateDistanceKm($provinceId, $toDistrictId);

        if (isset($res['code']) && $res['code'] === 200 && isset($res['data'])) {
            $res['data']['distance_km'] = $distanceInfo['km'];
            $res['data']['distance_text'] = $distanceInfo['text'];
            $res['data']['leadtime_text'] = $distanceInfo['leadtime'];
            $res['data']['from_location'] = 'Kho ChronoLux (68 Tràng Tiền, Quận Hoàn Kiếm, Hà Nội)';
        }

        return response()->json($res);
    }

    /**
     * Tính toán khoảng cách ước lượng (km) từ trung tâm Hà Nội đến điểm giao
     */
    protected function calculateDistanceKm(int $provinceId, int $toDistrictId): array
    {
        // Danh mục khoảng cách tương đối theo vùng địa lý tại Việt Nam
        // Kho gốc: Quận Hoàn Kiếm, Hà Nội
        $hanoiDistricts = [1482, 1484, 1485, 1486, 1488, 1489, 1490, 1491, 1492, 1493, 1494, 1495, 1496, 1542, 1442, 1450, 1452, 1454, 1530];
        
        if (in_array($toDistrictId, $hanoiDistricts) || $provinceId === 201 || $provinceId === 2002) {
            $km = rand(5, 18);
            return [
                'km' => $km,
                'text' => "Nội thành Hà Nội (~{$km} km)",
                'leadtime' => 'Hỏa tốc trong ngày (2 - 4 giờ)',
            ];
        }

        // Tỉnh lân cận đồng bằng sông Hồng
        $nearNorth = [202, 203, 204, 205, 206, 207, 208, 209, 210, 211];
        if (in_array($provinceId, $nearNorth)) {
            $km = rand(35, 120);
            return [
                'km' => $km,
                'text' => "Vùng lân cận Hà Nội (~{$km} km)",
                'leadtime' => 'Giao nhanh ngày mai (24 giờ)',
            ];
        }

        // Miền Trung
        $centralProvinces = [212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222];
        if (in_array($provinceId, $centralProvinces)) {
            $km = rand(280, 750);
            return [
                'km' => $km,
                'text' => "Tuyến Bắc - Trung (~{$km} km)",
                'leadtime' => '1 - 2 ngày làm việc',
            ];
        }

        // Miền Nam & TP.HCM & Miền Tây
        $km = rand(1550, 1850);
        return [
            'km' => $km,
            'text' => "Tuyến Bắc - Nam (~{$km} km)",
            'leadtime' => '2 - 3 ngày làm việc',
        ];
    }
}
