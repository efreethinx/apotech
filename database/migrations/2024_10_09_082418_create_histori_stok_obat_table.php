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
        Schema::create('histori_stok_obat', function (Blueprint $table) {
            $table->id('id_histori');
            $table->unsignedBigInteger('id_pembelian_detail');
            $table->unsignedBigInteger('id_penjualan_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_stok_obat');
    }
};
