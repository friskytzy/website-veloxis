<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Backup existing data
        $events = [];
        if (Schema::hasTable('events')) {
            $events = DB::table('events')->get();
        }
        
        // Step 2: Create a temporary table with the new structure
        Schema::create('events_new', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('location');
            $table->integer('max_participants')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('registration_link')->nullable();
            $table->timestamps();
        });
        
        // Step 3: Copy data from the old table to the new one
        foreach ($events as $event) {
            DB::table('events_new')->insert([
                'id' => $event->id,
                'title' => $event->title,
                'slug' => \Illuminate\Support\Str::slug($event->title),
                'description' => $event->description,
                'start_date' => $event->date,
                'location' => $event->location,
                'max_participants' => $event->max_participants,
                'image' => $event->image,
                'is_featured' => false,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at
            ]);
        }
        
        // Step 4: Drop the old table
        Schema::dropIfExists('events');
        
        // Step 5: Rename the new table to the old table name
        Schema::rename('events_new', 'events');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This would be complex to reverse accurately
        // The best approach is to restore from a backup if needed
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn(['slug', 'start_date', 'end_date', 'is_featured', 'registration_link']);
                $table->date('date')->after('description');
            });
        }
    }
}; 