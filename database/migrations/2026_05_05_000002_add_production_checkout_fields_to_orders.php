<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->unique()->after('id');
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('courier')->nullable()->after('phone');
            $table->unsignedInteger('subtotal')->default(0)->after('courier');
            $table->unsignedInteger('shipping_cost')->default(0)->after('subtotal');
            $table->unsignedInteger('discount')->default(0)->after('shipping_cost');
            $table->string('payment_method')->nullable()->after('discount');
            $table->string('payment_provider')->nullable()->after('payment_method');
            $table->string('payment_status')->default('waiting_payment')->after('payment_provider');
            $table->string('external_payment_id')->nullable()->after('payment_status');
            $table->string('tracking_number')->nullable()->after('external_payment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'customer_name',
                'courier',
                'subtotal',
                'shipping_cost',
                'discount',
                'payment_method',
                'payment_provider',
                'payment_status',
                'external_payment_id',
                'tracking_number',
            ]);
        });
    }
};
