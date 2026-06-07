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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('kode_order')->primary();
            $table->string('kode_supplier');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers')->onDelete('cascade');
            $table->string('isi_produk');
            $table->decimal('berat', 10, 2);
            $table->string('dimensi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kemasan')->nullable();
            $table->boolean('es')->default(false);
            $table->date('pengiriman_awal')->nullable();
            $table->date('pengiriman_tujuan')->nullable();
            $table->string('kode_konsumen');
            $table->foreign('kode_konsumen')->references('kode_konsumen')->on('konsumens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
