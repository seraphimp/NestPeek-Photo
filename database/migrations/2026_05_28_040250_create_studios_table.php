<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('country')->default('Philippines');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->json('amenities')->nullable();   // ["Parking", "Wifi", "Dressing Room", "AC"]
            $table->json('equipment_available')->nullable();
            $table->decimal('studio_area_sqm', 8, 2)->nullable();
            $table->integer('max_capacity')->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('half_day_rate', 10, 2)->nullable();
            $table->decimal('full_day_rate', 10, 2)->nullable();
            $table->string('currency', 3)->default('PHP');
            $table->json('operating_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};