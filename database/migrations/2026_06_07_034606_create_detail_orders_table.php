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
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->string('kode_detail_order')->primary();
            
            $table->string('kode_supplier');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers')->onDelete('cascade');
            
            $table->string('kode_order');
            $table->foreign('kode_order')->references('kode_order')->on('orders')->onDelete('cascade');
            
            $table->string('kode_rute');
            $table->foreign('kode_rute')->references('kode_rute')->on('rutes')->onDelete('cascade');
            
            $table->decimal('total_jarak', 10, 2)->default(0);
            
            $table->string('kode_status_delivery');
            $table->foreign('kode_status_delivery')->references('kode_status_delivery')->on('status_deliveries')->onDelete('cascade');
            
            $table->string('koordinat')->nullable();
            
            $table->string('kode_operator');
            $table->foreign('kode_operator')->references('kode_operator')->on('operators')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
