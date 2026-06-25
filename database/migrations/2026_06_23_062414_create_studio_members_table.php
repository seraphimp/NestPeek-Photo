<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studio_members', function (Blueprint $table) {
            $table->id();

            // Studio relationship
            $table->foreignId('studio_id')
                ->constrained('studios')
                ->onDelete('cascade');

            // Creator/User relationship
            $table->foreignId('creator_profile_id')
                ->constrained('creator_profiles')
                ->onDelete('cascade');

            // Role in the studio (owner, admin, member)
            $table->enum('role', ['owner', 'admin', 'member'])
                ->default('member');

            // Whether the member is featured in the studio page
            $table->boolean('is_featured')->default(false);

            // When they joined
            $table->timestamp('joined_at')->nullable();

            $table->timestamps();

            // Unique constraint to prevent duplicates
            $table->unique(['studio_id', 'creator_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studio_members');
    }
};
