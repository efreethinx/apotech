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
        Schema::create('setting', function (Blueprint $table) {
            $table->id('id_setting');
            $table->string('nama_apotek');
            $table->string('nama_owner');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email_apotek')->unique();
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->integer('diskon_member');
            $table->string('path_logo');
            $table->string('path_kartu_member');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
