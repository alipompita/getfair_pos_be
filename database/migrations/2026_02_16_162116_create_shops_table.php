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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->text('description');
            $table->foreignId('owned_by')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('subscription_status', ['active', 'expired', 'suspended', 'canceled', 'revoked', 'pending'])->default('pending');
            $table->dateTime('subscription_expiry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
