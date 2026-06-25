<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique(); // NP-2024-001234
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('creator_profile_id')->nullable()->constrained();
            $table->foreignId('studio_id')->nullable()->constrained();
            $table->enum('status', [
                'pending',
                'confirmed',
                'deposit_paid',
                'in_progress',
                'completed',
                'cancelled',
                'refunded'
            ])->default('pending');
            $table->date('event_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('event_type')->nullable(); // Wedding, Birthday, Corporate
            $table->string('venue')->nullable();
            $table->text('notes')->nullable();
            $table->text('special_requests')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->decimal('amount_due', 10, 2);
            $table->string('payment_status')->default('unpaid'); // unpaid, deposit_paid, fully_paid
            $table->string('stripe_payment_intent')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
