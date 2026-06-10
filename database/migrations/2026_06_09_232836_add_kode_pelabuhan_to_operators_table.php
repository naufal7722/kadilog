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
        Schema::table('operators', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_pelabuhan')->nullable()->after('kode_operator');
            $table->foreign('kode_pelabuhan')->references('kode_pelabuhan')->on('pelabuhans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->dropForeign(['kode_pelabuhan']);
            $table->dropColumn('kode_pelabuhan');
        });
    }
};
