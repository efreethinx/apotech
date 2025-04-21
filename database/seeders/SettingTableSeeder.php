<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting')->insert([
            'nama_apotek' => 'Apotek Sehat',
            'nama_owner' => 'Budi Santoso',
            'alamat' => 'Jl. Sehat No. 123, Jakarta',
            'no_telepon' => '081234567890',
            'email_apotek' => 'info@apoteksehat.com',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '22:00:00',
            'diskon_member' => 10,
            'path_logo' => 'img/logo.png',
            'path_kartu_member' => 'img/kartu_member.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
