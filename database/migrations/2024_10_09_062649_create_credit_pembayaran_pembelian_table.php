<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('credit_pembayaran_pembelian', function (Blueprint $table) {
            $table->id('id_credit');
            $table->unsignedBigInteger('id_pembelian');
            $table->dateTime('tanggal_bayar');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_pembayaran_pembelian');
    }
};
