<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requirements', function (Blueprint $table) {
            $table->string('regulation_source', 500)->nullable()->after('not_included');
        });

        // Seed default sources
        // 1. Kenaikan Pangkat & its children
        DB::table('service_requirements')
            ->where('slug', 'kenaikan-pangkat')
            ->orWhere('parent_id', 1)
            ->update(['regulation_source' => 'Undang-Undang Nomor 20 Tahun 2023 tentang ASN, Peraturan Pemerintah Nomor 11 Tahun 2017 jo. PP Nomor 17 Tahun 2020 tentang Manajemen PNS, Peraturan BKN Nomor 4 Tahun 2025 tentang Periodisasi Kenaikan Pangkat PNS.']);

        // 2. Pensiunan dan Pemberhentian & its children
        DB::table('service_requirements')
            ->where('slug', 'pensiunan-dan-pemberhentian')
            ->orWhere('parent_id', 6)
            ->update(['regulation_source' => 'Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara (ASN).']);

        // 3. PMK
        DB::table('service_requirements')
            ->where('slug', 'peninjauan-masa-kerja')
            ->update(['regulation_source' => 'Peraturan BKN Nomor 3 Tahun 2023 tentang Angka Kredit, Kenaikan Pangkat, dan Jenjang Jabatan Fungsional.']);

        // 4. Pencantuman Gelar
        DB::table('service_requirements')
            ->where('slug', 'pencantuman-gelar')
            ->update(['regulation_source' => 'Peraturan BKN Nomor 3 Tahun 2023 tentang Angka Kredit, Kenaikan Pangkat, dan Jenjang Jabatan Fungsional.']);

        // 5. Tugas Belajar
        DB::table('service_requirements')
            ->where('slug', 'tugas-belajar')
            ->update(['regulation_source' => 'Surat Edaran Menteri PANRB Nomor 28 Tahun 2021 tentang Pengembangan Kompetensi PNS Melalui Jalur Pendidikan.']);

        // 6. Tanda Kehormatan Presiden
        DB::table('service_requirements')
            ->where('slug', 'tanda-kehormatan')
            ->update(['regulation_source' => 'Undang-Undang Nomor 20 Tahun 2009 tentang Gelar, Tanda Jasa, dan Tanda Kehormatan.']);

        // 7. Sumpah/Janji PNS
        DB::table('service_requirements')
            ->where('slug', 'sumpah-janji-pns')
            ->update(['regulation_source' => 'Peraturan Pemerintah Nomor 11 Tahun 2017 jo. PP Nomor 17 Tahun 2020 tentang Manajemen PNS.']);

        // 8. CLTN
        DB::table('service_requirements')
            ->where('slug', 'cuti-luar-tanggungan-negara')
            ->update(['regulation_source' => 'Peraturan BKN Nomor 7 Tahun 2021 tentang Perubahan atas Peraturan BKN Nomor 24 Tahun 2017 tentang Tata Cara Pemberian Cuti PNS.']);

        // 9. Izin Perceraian
        DB::table('service_requirements')
            ->where('slug', 'izin-perceraian')
            ->update(['regulation_source' => 'Peraturan Pemerintah Nomor 10 Tahun 1983 jo. PP Nomor 45 Tahun 1990 tentang Izin Perkawinan dan Perceraian bagi PNS.']);

        // 10. Jabatan Fungsional & its children
        DB::table('service_requirements')
            ->where('slug', 'jabatan-fungsional')
            ->orWhere('parent_id', 24)
            ->update(['regulation_source' => 'Peraturan Menteri PANRB Nomor 1 Tahun 2023 tentang Jabatan Fungsional, Peraturan BKN Nomor 3 Tahun 2023.']);
    }

    public function down(): void
    {
        Schema::table('service_requirements', function (Blueprint $table) {
            $table->dropColumn('regulation_source');
        });
    }
};
