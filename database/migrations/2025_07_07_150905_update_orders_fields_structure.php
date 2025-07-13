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
        // Update orders table
        if (Schema::hasColumn('orders', 'total_amount') && !Schema::hasColumn('orders', 'total')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('total_amount', 'total');
            });
        }

        // Add new columns to orders if they don't exist
        if (!Schema::hasColumn('orders', 'city')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('city')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('email')->nullable();
                $table->text('notes')->nullable();
                $table->renameColumn('shipping_address', 'address');
            });
        }
        
        // Add product_name to order_items if it doesn't exist
        if (!Schema::hasColumn('order_items', 'product_name')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->string('product_name')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes to order_items table
        if (Schema::hasColumn('order_items', 'product_name')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('product_name');
            });
        }
        
        // Revert changes to orders table
        if (Schema::hasColumn('orders', 'city')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn(['city', 'postal_code', 'email', 'notes']);
                $table->renameColumn('address', 'shipping_address');
            });
        }
        
        if (Schema::hasColumn('orders', 'total') && !Schema::hasColumn('orders', 'total_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('total', 'total_amount');
            });
        }
    }
};
