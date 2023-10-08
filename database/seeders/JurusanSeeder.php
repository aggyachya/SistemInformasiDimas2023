<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusanData = [
            'Arsitektur',
            'Perencanaan Wilayah dan Kota',
            'Teknik Elektro',
            'Teknik Geodesi',
            'Teknik Geologi',
            'Teknik Industri',
            'Teknik Komputer',
            'Teknik Kimia',
            'Teknik Lingkungan',
            'Teknik Mesin',
            'Teknik Perkapalan',
            'Teknik Sipil',
        ];

        foreach ($jurusanData as $jurusan) {
            DB::table('jurusans')->insert([
                'nama_jurusan' => $jurusan,
            ]);
    }
}
}