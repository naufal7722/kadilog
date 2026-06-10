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
        Schema::create('rutes', function (Blueprint $table) {
            $table->id('kode_rute');
            $table->unsignedBigInteger('kode_pelabuhan_asal');
            $table->unsignedBigInteger('kode_pelabuhan_tujuan');
            $table->json('titik_transit')->nullable();
            
            $table->foreign('kode_pelabuhan_asal')->references('kode_pelabuhan')->on('pelabuhans')->onDelete('cascade');
            $table->foreign('kode_pelabuhan_tujuan')->references('kode_pelabuhan')->on('pelabuhans')->onDelete('cascade');
            
            $table->decimal('jarak', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
