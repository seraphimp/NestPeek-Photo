<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->morphs('available'); // creator_profiles or studios
            $table->date('date');
            $table->boolean('is_available')->default(true);
            $table->string('note')->nullable();
            $table->timestamps();
            $table->unique(['available_type', 'available_id', 'date']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
