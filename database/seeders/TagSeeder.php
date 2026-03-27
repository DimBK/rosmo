<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Rosmo Kemenhut', 'SDM Kehutanan', 'Bakti Rimbawan', 'ASN', 
            'Pengembangan Karir ASN', 'Penilaian Kinerja Pegawai', 'Diklat', 
            'Reformasi Birokrasi Kemenhut', 'Analisis Beban Kerja', 'BerAKHLAK', 
            'Seleksi CPNS Kemenhut', 'Penerimaan PPPK Kehutanan', 'SIMPEG', 
            'CASN', 'Seleksi JPT', 'Pengadaan Pegawai', 'Kenaikan Pangkat'
        ];
        
        foreach ($tags as $tag) {
            \App\Models\Tag::firstOrCreate(['name' => $tag]);
        }
    }
}
