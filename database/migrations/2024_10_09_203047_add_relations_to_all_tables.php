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
        Schema::table('obat', function (Blueprint $table) {
            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('id_satuan')
                  ->references('id_satuan')
                  ->on('satuan')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
        
        Schema::table('stok_obat', function (Blueprint $table) {
            $table->foreign('id_obat')
                  ->references('id_obat')
                  ->on('obat')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        
        Schema::table('stok_opname', function (Blueprint $table) {
            $table->foreign('id_obat')
                  ->references('id_obat')
                  ->on('obat')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('penjualan', function (Blueprint $table) {
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');

            $table->foreign('id_member')
                  ->references('id_member')
                  ->on('member')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
        
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->foreign('id_penjualan')
                  ->references('id_penjualan')
                  ->on('penjualan')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_obat')
                  ->references('id_obat')
                  ->on('obat')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('pembelian', function (Blueprint $table) {
            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
        
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->foreign('id_pembelian')
                  ->references('id_pembelian')
                  ->on('pembelian')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_obat')
                  ->references('id_obat')
                  ->on('obat')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
        
        Schema::table('credit_pembayaran_pembelian', function (Blueprint $table) {
            $table->foreign('id_pembelian')
                  ->references('id_pembelian')
                  ->on('pembelian')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('histori_stok_obat', function (Blueprint $table) {
            $table->foreign('id_pembelian_detail')
                  ->references('id_pembelian_detail')
                  ->on('pembelian_detail')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('id_penjualan_detail')
                  ->references('id_penjualan_detail')
                  ->on('penjualan_detail')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropForeign('obat_id_kategori_foreign');
            $table->dropForeign('obat_id_satuan_foreign');
        });

        Schema::table('stok_obat', function (Blueprint $table) {
            $table->dropForeign('stok_obat_id_obat_foreign');
        });

        Schema::table('stok_opname', function (Blueprint $table) {
            $table->dropForeign('stok_opname_id_obat_foreign');
        });

        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropForeign('penjualan_id_user_foreign');
            $table->dropForeign('penjualan_id_member_foreign');
        });

        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->dropForeign('penjualan_detail_id_penjualan_foreign');
            $table->dropForeign('penjualan_detail_id_obat_foreign');
        });

        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropForeign('pembelian_id_supplier_foreign');
        });

        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->dropForeign('pembelian_detail_id_pembelian_foreign');
            $table->dropForeign('pembelian_detail_id_obat_foreign');
        });

        Schema::table('credit_pembayaran_pembelian', function (Blueprint $table) {
            $table->dropForeign('credit_pembayaran_pembelian_id_pembelian_foreign');
        });

        Schema::table('histori_stok_obat', function (Blueprint $table) {
            $table->dropForeign('histori_stok_obat_id_pembelian_detail_foreign');
            $table->dropForeign('histori_stok_obat_id_penjualan_detail_foreign');
        });
    }
};
