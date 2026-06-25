<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->morphs('serviceable');  // creator_profiles or studios
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('category', [
                'wedding_package',
                'portrait_session',
                'event_coverage',
                'video_production',
                'photo_editing',
                'studio_rental',
                'coordination',
                'add_on',
                'other'
            ]);
            $table->decimal('price', 10, 2);
            $table->string('price_type')->default('fixed'); // fixed, per_hour, per_day, starting_from
            $table->string('currency', 3)->default('PHP');
            $table->integer('duration_hours')->nullable();
            $table->text('inclusions')->nullable();         // what's included
            $table->text('exclusions')->nullable();
            $table->integer('max_bookings_per_day')->default(1);
            $table->boolean('requires_deposit')->default(true);
            $table->decimal('deposit_amount', 10, 2)->nullable();
            $table->integer('deposit_percentage')->nullable();
            $table->integer('advance_booking_days')->default(30);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
