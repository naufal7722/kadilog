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
        Schema::create('tracking_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kode_detail_order');
            $table->foreign('kode_detail_order')->references('kode_detail_order')->on('detail_orders')->onDelete('cascade');
            $table->unsignedBigInteger('kode_status_delivery');
            $table->foreign('kode_status_delivery')->references('kode_status_delivery')->on('status_deliveries')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->string('koordinat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_histories');
    }
};
