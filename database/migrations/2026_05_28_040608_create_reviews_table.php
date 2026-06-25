<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained();
            $table->foreignId('reviewer_id')->constrained('users'); // client
            $table->morphs('reviewable'); // creator_profiles or studios
            $table->integer('rating'); // 1-5
            $table->string('title')->nullable();
            $table->text('content');
            $table->integer('communication_rating')->nullable();
            $table->integer('quality_rating')->nullable();
            $table->integer('value_rating')->nullable();
            $table->integer('professionalism_rating')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_published')->default(true);
            $table->text('response')->nullable();       // creator's reply
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
