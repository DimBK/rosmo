<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update Kenaikan Pangkat (and children)
        DB::table('service_requirements')
            ->where('slug', 'kenaikan-pangkat')
            ->orWhere('parent_id', 1)
            ->update(['regulation_source' => 'Undang-Undang Nomor 20 Tahun 2023 tentang ASN; Peraturan Pemerintah Nomor 11 Tahun 2017 jo. PP Nomor 17 Tahun 2020 tentang Manajemen PNS; Peraturan BKN Nomor 4 Tahun 2025 tentang Periodisasi Kenaikan Pangkat PNS.']);

        // Update Jabatan Fungsional (and children)
        DB::table('service_requirements')
            ->where('slug', 'jabatan-fungsional')
            ->orWhere('parent_id', 24)
            ->update(['regulation_source' => 'Peraturan Menteri PANRB Nomor 1 Tahun 2023 tentang Jabatan Fungsional; Peraturan BKN Nomor 3 Tahun 2023.']);
    }

    public function down(): void
    {
        DB::table('service_requirements')
            ->where('slug', 'kenaikan-pangkat')
            ->orWhere('parent_id', 1)
            ->update(['regulation_source' => 'Undang-Undang Nomor 20 Tahun 2023 tentang ASN, Peraturan Pemerintah Nomor 11 Tahun 2017 jo. PP Nomor 17 Tahun 2020 tentang Manajemen PNS, Peraturan BKN Nomor 4 Tahun 2025 tentang Periodisasi Kenaikan Pangkat PNS.']);

        DB::table('service_requirements')
            ->where('slug', 'jabatan-fungsional')
            ->orWhere('parent_id', 24)
            ->update(['regulation_source' => 'Peraturan Menteri PANRB Nomor 1 Tahun 2023 tentang Jabatan Fungsional, Peraturan BKN Nomor 3 Tahun 2023.']);
    }
};
