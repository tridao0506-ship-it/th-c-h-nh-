<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchStoreTest extends TestCase
{
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('CHRONOLUX');
    }

    public function test_products_catalog_loads_and_filters(): void
    {
        $response = $this->get('/dong-ho');
        $response->assertStatus(200);
        $response->assertSee('Bộ Sưu Tập Đồng Hồ');

        // Test filter by brand
        $response = $this->get('/dong-ho?brand=Rolex');
        $response->assertStatus(200);
    }

    public function test_product_detail_page_loads(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->get('/dong-ho/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->name);
        $response->assertSee($product->sku);
    }

    public function test_cart_operations(): void
    {
        $product = Product::first();

        // 1. Add to cart
        $response = $this->post('/gio-hang/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $response->assertRedirect();
        $this->assertTrue(session()->has('cart'));

        // 2. View cart
        $response = $this->get('/gio-hang');
        $response->assertStatus(200);
        $response->assertSee($product->name);

        // 3. Apply valid voucher
        $response = $this->post('/gio-hang/voucher', [
            'voucher_code' => 'CHRONO10',
        ]);
        $response->assertRedirect('/gio-hang');
        $this->assertEquals('CHRONO10', session('voucher.code'));
    }

    public function test_checkout_and_order_tracking(): void
    {
        $product = Product::first();

        // Put item in cart
        $this->post('/gio-hang/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        // Submit checkout
        $response = $this->post('/thanh-toan', [
            'customer_name' => 'Nguyễn Văn Test',
            'customer_phone' => '0912345678',
            'customer_email' => 'test@example.com',
            'shipping_address' => '123 Phố Tràng Tiền',
            'city' => 'Hà Nội',
            'payment_method' => 'cod',
            'notes' => 'Giao trong giờ hành chính',
        ]);

        $order = Order::where('customer_phone', '0912345678')->first();
        $this->assertNotNull($order);

        $response->assertRedirect('/thanh-toan/thanh-cong/' . $order->order_code);

        // Success page
        $successResponse = $this->get('/thanh-toan/thanh-cong/' . $order->order_code);
        $successResponse->assertStatus(200);
        $successResponse->assertSee($order->order_code);

        // Track order
        $trackResponse = $this->get('/tra-cuu-don-hang?q=' . $order->order_code);
        $trackResponse->assertStatus(200);
        $trackResponse->assertSee($order->customer_name);
    }

    public function test_admin_dashboard_and_orders(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Tổng Doanh Thu');

        $response = $this->get('/admin/don-hang');
        $response->assertStatus(200);

        $response = $this->get('/admin/san-pham');
        $response->assertStatus(200);
    }

    public function test_informational_pages(): void
    {
        $this->get('/gioi-thieu')->assertStatus(200);
        $this->get('/lien-he')->assertStatus(200);
        $this->get('/chinh-sach-bao-hanh')->assertStatus(200);
    }
}
