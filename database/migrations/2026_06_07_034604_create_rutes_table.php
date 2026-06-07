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
            $table->string('kode_rute')->primary();
            $table->string('kode_pelabuhan');
            $table->foreign('kode_pelabuhan')->references('kode_pelabuhan')->on('pelabuhans')->onDelete('cascade');
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
