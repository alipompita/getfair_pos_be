<?php

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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->foreignId('shop_id')->constrained('shops', 'id')->onDelete('cascade');
            $table->foreignId('subscription_type_id')->constrained('subscription_types', 'id')->onDelete('cascade');
            $table->enum('status', ['active', 'expired', 'suspended', 'canceled', 'revoked', 'pending'])->default('pending');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
