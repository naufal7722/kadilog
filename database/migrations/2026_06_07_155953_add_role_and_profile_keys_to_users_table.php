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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('konsumen');
            $table->unsignedBigInteger('kode_konsumen')->nullable();
            $table->unsignedBigInteger('kode_operator')->nullable();
            $table->unsignedBigInteger('kode_supplier')->nullable();

            $table->foreign('kode_konsumen')->references('kode_konsumen')->on('konsumens')->onDelete('set null');
            $table->foreign('kode_operator')->references('kode_operator')->on('operators')->onDelete('set null');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kode_konsumen']);
            $table->dropForeign(['kode_operator']);
            $table->dropForeign(['kode_supplier']);
            $table->dropColumn(['role', 'kode_konsumen', 'kode_operator', 'kode_supplier']);
        });
    }
};
