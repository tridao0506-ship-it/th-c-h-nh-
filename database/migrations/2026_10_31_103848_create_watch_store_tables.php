<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('country')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('brand');
            $table->enum('gender', ['men', 'women', 'unisex'])->default('men');
            $table->decimal('price', 15, 0); // VND
            $table->decimal('original_price', 15, 0)->nullable();
            $table->integer('stock')->default(10);
            $table->string('movement')->default('Automatic'); // Bộ máy
            $table->string('dial_size')->nullable(); // Kích thước mặt (e.g. 40mm)
            $table->string('case_material')->nullable(); // Chất liệu vỏ
            $table->string('strap_material')->nullable(); // Chất liệu dây
            $table->string('water_resistance')->nullable(); // Kháng nước
            $table->string('glass_type')->nullable(); // Kính Sapphire
            $table->string('power_reserve')->nullable(); // Trữ cót
            $table->integer('warranty_years')->default(5); // Số năm bảo hành
            $table->string('origin')->default('Thụy Sĩ'); // Xuất xứ
            $table->string('image');
            $table->json('gallery')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new')->default(false);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('reviews_count')->default(0);
            $table->integer('sold_count')->default(0);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('shipping_address');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('payment_method')->default('cod'); // cod, banking
            $table->string('payment_status')->default('pending'); // pending, paid
            $table->string('order_status')->default('pending'); // pending, processing, shipping, completed, cancelled
            $table->decimal('subtotal', 15, 0);
            $table->decimal('discount_amount', 15, 0)->default(0);
            $table->string('voucher_code')->nullable();
            $table->decimal('shipping_fee', 15, 0)->default(0);
            $table->decimal('total_amount', 15, 0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->string('product_image')->nullable();
            $table->decimal('price', 15, 0);
            $table->integer('quantity');
            $table->decimal('total', 15, 0);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->integer('rating')->default(5);
            $table->text('comment');
            $table->boolean('is_verified_buyer')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('status')->default('new'); // new, read, replied
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
