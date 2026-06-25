<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('brand_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('cover_photo')->nullable();
            $table->enum('specialization', [
                'wedding_photographer',
                'wedding_videographer',
                'portrait_photographer',
                'event_photographer',
                'event_videographer',
                'photo_editor',
                'video_editor',
                'wedding_coordinator',
                'photo_booth',
                'drone_operator',
                'lighting_specialist',
                'other'
            ])->default('wedding_photographer');
            $table->json('skills')->nullable();       // ["Drone", "Lightroom", "Adobe Premiere"]
            $table->json('equipment')->nullable();    // ["Sony A7IV", "DJI Mavic 3"]
            $table->json('styles')->nullable();       // ["Documentary", "Fine Art", "Cinematic"]
            $table->integer('years_experience')->default(0);
            $table->integer('total_bookings')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('PHP');
            $table->boolean('is_available')->default(true);
            $table->string('availability_note')->nullable();
            $table->json('service_areas')->nullable();  // cities/regions covered
            $table->boolean('travels_internationally')->default(false);
            $table->integer('profile_views')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
