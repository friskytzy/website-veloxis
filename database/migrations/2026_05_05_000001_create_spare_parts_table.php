<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('category')->index();
            $table->string('part_brand')->index();
            $table->string('motor_brand')->index();
            $table->json('compatible_models');
            $table->string('compatible_years');
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->string('image_url');
            $table->text('description');
            $table->json('specifications')->nullable();
            $table->string('badge')->default('Ready Stock');
            $table->string('status')->default('active')->index();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};
