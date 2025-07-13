<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bike;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('category');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
        
        // Update existing records to set category_id based on category string
        $bikes = Bike::all();
        foreach ($bikes as $bike) {
            $category = Category::where('name', $bike->category)->where('type', 'bike')->first();
            if ($category) {
                $bike->category_id = $category->id;
                $bike->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
