<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('service_requirements')
            ->where('slug', 'peninjauan-masa-kerja')
            ->update(['title' => 'Peninjauan Masa Kerja (PMK)']);

        DB::table('service_requirements')
            ->where('slug', 'pencantuman-gelar')
            ->update(['title' => 'Pencantuman Gelar']);

        DB::table('service_requirements')
            ->where('slug', 'tugas-belajar')
            ->update(['title' => 'Tugas Belajar (SK TB)']);

        DB::table('service_requirements')
            ->where('slug', 'tanda-kehormatan')
            ->update(['title' => 'Tanda Kehormatan Presiden']);

        DB::table('service_requirements')
            ->where('slug', 'sumpah-janji-pns')
            ->update(['title' => 'Sumpah/Janji PNS']);

        DB::table('service_requirements')
            ->where('slug', 'cuti-luar-tanggungan-negara')
            ->update(['title' => 'Cuti Luar Tanggungan Negara (CLTN)']);

        DB::table('service_requirements')
            ->where('slug', 'izin-perceraian')
            ->update(['title' => 'Izin Perceraian']);
    }

    public function down(): void
    {
        DB::table('service_requirements')
            ->where('slug', 'peninjauan-masa-kerja')
            ->update(['title' => 'Peninjauan Masa Kerja (PMK) PNS']);

        DB::table('service_requirements')
            ->where('slug', 'pencantuman-gelar')
            ->update(['title' => 'Pencantuman Gelar Akademik PNS']);

        DB::table('service_requirements')
            ->where('slug', 'tugas-belajar')
            ->update(['title' => 'Layanan Tugas Belajar (Penerbitan, Perpanjangan, & Pencabutan SK)']);

        DB::table('service_requirements')
            ->where('slug', 'tanda-kehormatan')
            ->update(['title' => 'Fasilitas Penganugrahan Tanda Kehormatan Presiden']);

        DB::table('service_requirements')
            ->where('slug', 'sumpah-janji-pns')
            ->update(['title' => 'Permohonan Pengambilan Sumpah/Janji PNS']);

        DB::table('service_requirements')
            ->where('slug', 'cuti-luar-tanggungan-negara')
            ->update(['title' => 'Cuti Luar Tanggungan Negara (CLTN) PNS (Pemberian, Perpanjangan, & Pengaktifan)']);

        DB::table('service_requirements')
            ->where('slug', 'izin-perceraian')
            ->update(['title' => 'Izin Perceraian (PNS Gol. III-IV & PPPK Gol. IX Keatas)']);
    }
};
