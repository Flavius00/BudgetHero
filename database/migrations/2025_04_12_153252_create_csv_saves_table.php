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
        if (Schema::hasTable('csv_saves')) {
            return;
        }
        Schema::create('csv_saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('transaction_date')->nullable();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->float('amount')->nullable();
            $table->boolean('is_income')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_saves');
    }
};
