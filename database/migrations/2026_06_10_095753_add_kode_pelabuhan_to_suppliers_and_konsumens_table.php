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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_pelabuhan')->nullable()->after('no_hp_pic');
            $table->foreign('kode_pelabuhan')->references('kode_pelabuhan')->on('pelabuhans')->onDelete('set null');
        });

        Schema::table('konsumens', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_pelabuhan')->nullable()->after('nama_pic_konsumen');
            $table->foreign('kode_pelabuhan')->references('kode_pelabuhan')->on('pelabuhans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['kode_pelabuhan']);
            $table->dropColumn('kode_pelabuhan');
        });

        Schema::table('konsumens', function (Blueprint $table) {
            $table->dropForeign(['kode_pelabuhan']);
            $table->dropColumn('kode_pelabuhan');
        });
    }
};
