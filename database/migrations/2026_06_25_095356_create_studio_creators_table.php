<?php
// database/migrations/2026_06_22_xxxxxx_create_studio_creators_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('studio_creators', function (Blueprint $table) {
            $table->id();

            // Foreign key to studios table
            $table->foreignId('studio_id')
                ->constrained('studios')
                ->onDelete('cascade');

            // Foreign key to users table (creators are users)
            $table->foreignId('creator_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Role in the studio
            $table->enum('role', ['owner', 'admin', 'member'])->default('member');

            // When they joined the studio
            $table->timestamp('joined_at')->nullable();

            // Status of membership
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');

            // Optional: permissions JSON field for granular permissions
            $table->json('permissions')->nullable();

            // Timestamps (created_at, updated_at)
            $table->timestamps();

            // Unique constraint to prevent duplicate entries
            $table->unique(['studio_id', 'creator_id']);

            // Indexes for faster queries
            $table->index('studio_id');
            $table->index('creator_id');
            $table->index('role');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studio_creators');
    }
};
