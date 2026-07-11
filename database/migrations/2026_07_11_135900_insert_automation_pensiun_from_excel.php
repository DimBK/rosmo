<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Delete existing items with parent_id = 6 to prevent duplicate inserts
        DB::table('service_requirements')->where('parent_id', 6)->delete();

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun BUP (Mencapai Batas Usia Pensiun)',
            'slug' => 'pensiun-bup',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun BUP (Mencapai Batas Usia Pensiun) di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => '<ol><li>Pejabat Administrasi : 58 Tahun</li><li>Pejabat Pimpinan Tinggi : 60 Tahun</li><li>Pejabat Fungsional (Sesuai dengan ketentuan/ peraturan perundangan)</li></ol>',
            'included' => '<ol><li>Pas Foto PNS formal, terbaru, berwarna dan berlatar belakangan merah atau biru</li><li>Permohonan Pribadi PNS yang ditujukan kepada Menteri Kehutanan ditanda tangan
diatas meterai</li><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Jabatan Terakhir</li><li>SKP 1 tahun terakhir</li><li>Daftar Susunan Keluarga dari Kelurahan/ Kecamatan setempat</li><li>KTP PNS</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li><li>Kartu Keluarga</li></ol>',
            'not_included' => '<ol><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li><li>Akta Nikah PNS</li><li>Akta Cerai</li><li>Akta Kelahiran Anak Kandung PNS</li><li>Halaman depan buku tabungan PNS yang memuat nama dan nomor rekening</li><li>NPWP PNS</li><li>Berita Acara Pelantikan dan ijazah terakhir untuk Golongan IV/c ke atas</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun Anumerta (Janda/Duda/Anak/Orang Tua PNS Tewas)',
            'slug' => 'pensiun-anumerta',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun Anumerta (Janda/Duda/Anak/Orang Tua PNS Tewas) di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Pas Foto Janda/ Duda/Anak/ Orang Tua PNS formal, terbaru, berwarna dan berlatar belakang merah atau biru</li><li>Permohonan Pribadi Janda/ Duda/ Anak/ Orang Tua PNS yang ditujukan kepada Menteri Kehutanan</li><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Jabatan Terakhir</li><li>SKP 1 tahun terakhir</li><li>Surat Keterangan Kematian PNS</li><li>Surat Keterangan Duda/Janda/ anak/ orang tua dari Kelurahan/Kecamatan setempat</li><li>Daftar Susunan Keluarga dari Kelurahan/Kecamatan setempat</li><li>Laporan Kronologis Kejadian</li><li>Surat Perintah Tugas</li><li>Surat Keterangan Dokter/ Visum Et Repertum dari Rumah Sakit</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li><li>Kartu Keluarga</li></ol>',
            'not_included' => '<ol><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li><li>Surat Keputusan Tewas Sementara</li><li>Akta Nikah PNS</li><li>Akta Cerai</li><li>Akta Kelahiran Anak Kandung PNS</li><li>Akta lahir PNS yang tewas (jika pensiun orangtua)</li><li>Berita Acara Pemeriksaan/Laporan Polisi Kejadian</li><li>Halaman depan buku tabungan PNS yang memuat nama dan nomor rekening</li><li>KTP Janda/ Duda/ Anak/ Orang Tua</li><li>NPWP Janda/ Duda/ Orang Tua</li><li>Berita Acara Pelantikan dan ijazah terakhir untuk Golongan IV/c ke atas</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun Meninggal Dunia (Janda/Duda/Anak PNS)',
            'slug' => 'pensiun-meninggal-dunia',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun Meninggal Dunia (Janda/Duda/Anak PNS) di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Pas Foto PNS formal, terbaru, berwarna dan berlatar belakangan merah atau biru</li><li>Permohonan Pribadi Janda/ Duda/ Anak PNS yang ditujukan kepada Menteri
Kehutanan</li><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Jabatan Terakhir</li><li>SKP 1 tahun terakhir</li><li>Surat Keterangan Kematian PNS</li><li>Surat Keterangan Duda/Janda dari Kelurahan/Kecamatan setempat</li><li>Daftar Susunan Keluarga dari Kelurahan/Kecamatan setempat</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li><li>Kartu Keluarga</li></ol>',
            'not_included' => '<ol><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li><li>Akta Nikah PNS</li><li>Akta Cerai</li><li>Akta Kelahiran Anak Kandung PNS</li><li>Halaman depan buku tabungan PNS yang memuat nama dan nomor rekening</li><li>KTP Janda/ Duda/Anak</li><li>NPWP Janda/ Duda/ anak</li><li>Berita Acara Pelantikan dan ijazah terakhir untuk Golongan IV/c ke atas</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun Uzur (Tidak Cakap Jasmani/Rohani)',
            'slug' => 'pensiun-uzur',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun Uzur (Tidak Cakap Jasmani/Rohani) di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Pas Foto PNS formal, terbaru, berwarna dan berlatar belakang merah atau biru</li><li>Permohonan Pribadi PNS yang ditujukan kepada Menteri Kehutanan ditanda tangan diatas meterai</li><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Keputusan Jabatan Terakhir/ Surat Keputusan</li><li>SKP 1 tahun terakhir</li><li>Surat Keterangan Tim Penguji Kesehatan dari Rumah Sakit Pemerintah</li><li>Daftar Susunan Keluarga dari Kelurahan/Kecamatan setempat</li><li>KTP PNS</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li><li>Kartu Keluarga</li></ol>',
            'not_included' => '<ol><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li><li>Akta Nikah PNS</li><li>Akta Cerai</li><li>Akta Kelahiran Anak Kandung PNS</li><li>Halaman depan buku tabungan PNS yang memuat nama dan nomor rekening</li><li>NPWP PNS</li><li>Berita Acara Pelantikan dan ijazah terakhir untuk Golongan IV/c ke atas</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun APS Dengan Hak Pensiun (Pensiun Dini)',
            'slug' => 'pensiun-aps-dengan-hak',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun APS Dengan Hak Pensiun (Pensiun Dini) di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Pas Foto PNS formal, terbaru, berwarna dan berlatar belakangan merah atau biru</li><li>Permohonan Pribadi PNS yang ditujukan kepada Menteri Kehutanan ditanda tangan diatas meterai</li><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Jabatan Terakhir</li><li>SKP 1 tahun terakhir</li><li>Daftar Susunan Keluarga dari Kelurahan/ Kecamatan setempat</li><li>KTP PNS</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kartu Keluarga</li><li>Kenaikan Gaji Berkala Terakhir</li></ol>',
            'not_included' => '<ol><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li><li>Akta Nikah PNS</li><li>Akta Cerai</li><li>Akta Kelahiran Anak Kandung PNS</li><li>Halaman depan buku tabungan PNS yang memuat nama dan nomor rekening</li><li>NPWP PNS</li><li>Berita Acara Pelantikan dan ijazah terakhir untuk Golongan IV/c ke atas</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun APS Tanpa Hak Pensiun',
            'slug' => 'pensiun-aps-tanpa-hak',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun APS Tanpa Hak Pensiun di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Permohonan Pribadi PNS yang ditujukan kepada Menteri Kehutanan ditanda tangan diatas meterai</li><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>SKP 1 tahun terakhir</li><li>Surat Persetujuan dari Pasangan/ orang tua PNS</li><li>Surat Bebas Tanggungan BMN</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li></ol>',
            'not_included' => '<ol><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pensiun Meninggal Dunia Tanpa Ahli Waris',
            'slug' => 'pensiun-meninggal-dunia-tanpa-ahli-waris',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pensiun Meninggal Dunia Tanpa Ahli Waris di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>Surat Keputusan CPNS</li><li>Surat Keputusan PNS</li><li>Surat Keputusan Kenaikan Pangkat Terakhir</li><li>Surat Keterangan Kematian PNS</li><li>SKP 1 tahun terakhir</li><li>Surat Pernyataan Tidak Pernah Dijatuhi Hukuman Disiplin Tingkat Sedang/ Berat</li><li>Surat Pernyataan Tidak Sedang Menjalani Proses Pidana/ Pernah Dipidana</li><li>Kenaikan Gaji Berkala Terakhir</li></ol>',
            'not_included' => '<ol><li>Data Perorangan Calon Penerima Pensiun</li><li>Surat Keputusan Peninjauan Masa Kerja</li><li>Surat Cuti Diluar Tanggungan Negara</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Perpanjangan Masa Perjanjian Kerja PPPK',
            'slug' => 'perpanjangan-pppk',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Perpanjangan Masa Perjanjian Kerja PPPK di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>SK PPPK</li><li>Perjanjian Kerja</li><li>SKP 1 tahun terakhir</li><li>Kenaikan Gaji Berkala Terakhir</li><li>Rekomendasi Perpanjangan Masa Perjanjian Kerja dari Kepala Satker</li></ol>',
            'not_included' => null,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pemutusan Hubungan Kerja PPPK Karena Meninggal Dunia',
            'slug' => 'pppk-meninggal-dunia',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pemutusan Hubungan Kerja PPPK Karena Meninggal Dunia di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>SK PPPK</li><li>Surat Keterangan Kematian</li></ol>',
            'not_included' => null,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('service_requirements')->insert([
            'parent_id' => 6,
            'title' => 'Pemutusan Hubungan Kerja PPPK Karena Berhenti/Habis Kontrak',
            'slug' => 'pppk-berhenti-habis-kontrak',
            'content' => '<p>Layanan persyaratan administrasi kepegawaian untuk Pemutusan Hubungan Kerja PPPK Karena Berhenti/Habis Kontrak di lingkungan Kementerian Kehutanan.</p>',
            'highlights' => null,
            'included' => '<ol><li>SK PPPK</li><li>Perjanjian Kerja</li><li>SKP 1 tahun terakhir</li><li>Rekomendasi Pemberhentian PPPK dari Kepala Satker</li></ol>',
            'not_included' => null,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

    public function down(): void
    {
        DB::table('service_requirements')->where('parent_id', 6)->delete();
    }
};
