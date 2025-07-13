<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Gear;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gear', function (Blueprint $table) {
            // Make size and color nullable
            $table->string('size')->nullable()->change();
            $table->string('color')->nullable()->change();
            
            // Add category_id foreign key
            $table->unsignedBigInteger('category_id')->nullable()->after('category');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
        
        // Update existing records to set category_id based on category string
        $gears = Gear::all();
        foreach ($gears as $gear) {
            $category = Category::where('name', $gear->category)->where('type', 'gear')->first();
            if ($category) {
                $gear->category_id = $category->id;
                $gear->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gear', function (Blueprint $table) {
            // Revert changes - make size and color required
            $table->string('size')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            
            // Remove category_id foreign key
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
