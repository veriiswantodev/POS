<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'nama_perusahaan' => 'My Shop',
            'alamat' => 'Sidoarjo',
            'telepon' => '0857434399',
            'tipe_nota' => 1, // kecil
            'diskon' => 5,
            'path_logo' => '/images/logo.png',
            'path_kartu_member' => '/images/member.png'
        ]);
    }
}
