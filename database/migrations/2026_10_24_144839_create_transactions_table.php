<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // Nomor Nota / Faktur Unik
            $table->decimal('total_amount', 12, 2);   // Total Belanja
            $table->decimal('pay_amount', 12, 2);     // Uang yang Dibayar Pembeli
            $table->decimal('change_amount', 12, 2);  // Uang Kembalian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};