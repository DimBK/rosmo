<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Kenaikan Pangkat Reguler
        DB::table('service_requirements')->insert([
            'parent_id' => 1,
            'title' => 'Kenaikan Pangkat Reguler',
            'slug' => 'kenaikan-pangkat-reguler',
            'content' => '<p>Kenaikan Pangkat Reguler diberikan kepada Pegawai Negeri Sipil (PNS) yang tidak menduduki jabatan struktural atau jabatan fungsional tertentu (seperti jabatan pelaksana). Kenaikan pangkat ini merupakan penghargaan atas prestasi kerja dan pengabdian PNS yang bersangkutan setelah memenuhi syarat masa kerja minimal yang ditentukan tanpa terikat pada jabatan tertentu.</p>',
            'highlights' => '<ol><li>Telah minimal 4 (empat) tahun dalam pangkat terakhir.</li><li>Setiap unsur penilaian prestasi kerja (SKP) sekurang-kurangnya bernilai baik dalam 2 (dua) tahun terakhir.</li><li>Pangkat yang diusulkan tidak melampaui pangkat atasan langsungnya.</li></ol>',
            'included' => '<ol><li>Salinan sah SK Kenaikan Pangkat terakhir.</li><li>Salinan sah SKP (Sasaran Kinerja Pegawai) beserta penilaian perilaku kerja 2 tahun terakhir.</li><li>Salinan sah Ijazah terakhir dan Transkrip Nilai (apabila ada peningkatan pendidikan/penyesuaian gelar).</li><li>Salinan sah Surat Tanda Lulus Ujian Dinas (STLUD) jika naik golongan dari II/d ke III/a (kecuali bagi yang dibebaskan sesuai ketentuan).</li></ol>',
            'not_included' => '<ol><li>SK Jabatan Fungsional atau SK Jabatan Struktural.</li><li>Penetapan Angka Kredit (PAK) bagi pejabat fungsional.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Kenaikan Pangkat Pilihan
        DB::table('service_requirements')->insert([
            'parent_id' => 1,
            'title' => 'Kenaikan Pangkat Pilihan',
            'slug' => 'kenaikan-pangkat-pilihan',
            'content' => '<p>Kenaikan Pangkat Pilihan diberikan kepada Pegawai Negeri Sipil yang menduduki jabatan struktural, jabatan fungsional tertentu, memiliki prestasi kerja luar biasa yang mendapat penghargaan negara, atau yang menyelesaikan pendidikan tugas belajar.</p>',
            'highlights' => '<ol><li>Menduduki jabatan struktural atau jabatan fungsional tertentu.</li><li>Telah minimal 4 tahun dalam pangkat terakhir (untuk struktural) atau minimal 2 tahun (untuk fungsional bila angka kredit mencukupi).</li><li>Predikat kinerja (SKP) bernilai minimal Baik dalam 2 tahun terakhir.</li><li>Memenuhi syarat kompetensi dan kualifikasi jabatan yang dituju.</li></ol>',
            'included' => '<ol><li>Salinan sah SK Kenaikan Pangkat terakhir.</li><li>Salinan sah SK Pengangkatan dalam Jabatan Struktural/Fungsional terakhir.</li><li>Salinan sah Surat Pernyataan Melaksanakan Tugas (SPMT) atau Berita Acara Pelantikan (untuk jabatan struktural).</li><li>Asli/salinan sah Penetapan Angka Kredit (PAK) kumulatif terbaru (untuk jabatan fungsional).</li><li>Salinan sah SKP 2 tahun terakhir.</li></ol>',
            'not_included' => '<ol><li>Surat Tanda Lulus Ujian Dinas (STLUD) karena syarat kelulusan diganti dengan uji kompetensi/PAK.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Kenaikan Pangkat Anumerta
        DB::table('service_requirements')->insert([
            'parent_id' => 1,
            'title' => 'Kenaikan Pangkat Anumerta',
            'slug' => 'kenaikan-pangkat-anumerta',
            'content' => '<p>Kenaikan Pangkat Anumerta diberikan sebagai penghargaan tertinggi dari negara bagi Pegawai Negeri Sipil yang dinyatakan tewas (meninggal dunia) dalam dan karena menjalankan tugas kewajiban jabatannya.</p>',
            'highlights' => '<ol><li>Diberikan langsung (berlaku mulai tanggal yang bersangkutan tewas) tanpa terikat masa kerja atau masa pangkat.</li><li>Telah dinyatakan tewas oleh instansi pembina berdasarkan pemeriksaan/keputusan resmi.</li><li>Meninggal karena kecelakaan atau serangan langsung saat bertugas demi kepentingan negara.</li></ol>',
            'included' => '<ol><li>Salinan sah SK Pangkat Terakhir.</li><li>Laporan kronologis kejadian tewas dari pimpinan unit kerja.</li><li>Visum et Repertum atau Surat Keterangan Kematian dari Dokter/Rumah Sakit pemerintah.</li><li>Berita Acara Kejadian dari pihak berwenang (misal Kepolisian jika kecelakaan lalu lintas kedinasan).</li></ol>',
            'not_included' => '<ol><li>Sasaran Kinerja Pegawai (SKP) tahunan (tidak bersifat wajib dalam keadaan anumerta).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Kenaikan Pangkat Pengabdian
        DB::table('service_requirements')->insert([
            'parent_id' => 1,
            'title' => 'Kenaikan Pangkat Pengabdian',
            'slug' => 'kenaikan-pangkat-pengabdian',
            'content' => '<p>Kenaikan Pangkat Pengabdian diberikan kepada Pegawai Negeri Sipil yang akan diberhentikan dengan hormat dengan hak pensiun karena mencapai Batas Usia Pensiun (BUP), meninggal dunia, atau mengalami cacat karena dinas sehingga tidak dapat bekerja lagi.</p>',
            'highlights' => '<ol><li>Memiliki masa kerja terus-menerus paling singkat 30 tahun (atau 20 tahun jika belum mencapai pangkat maksimal).</li><li>Penilaian kinerja (SKP) bernilai minimal Baik dalam 1 (satu) tahun terakhir.</li><li>Tidak pernah dijatuhi hukuman disiplin tingkat sedang atau berat dalam 1 (satu) tahun terakhir.</li></ol>',
            'included' => '<ol><li>Salinan sah SK Pangkat Terakhir.</li><li>Salinan sah SKP 1 tahun terakhir.</li><li>Surat Pernyataan dari Kepala Instansi bahwa yang bersangkutan tidak pernah dijatuhi hukuman disiplin sedang/berat dalam 1 tahun terakhir.</li><li>Surat Keterangan Kematian atau Surat Keterangan Cacat Dinas dari Tim Penguji Kesehatan (jika cacat dinas).</li></ol>',
            'not_included' => '<ol><li>Ujian Dinas atau Ujian Penyesuaian Ijazah.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('service_requirements')->whereIn('slug', [
            'kenaikan-pangkat-reguler',
            'kenaikan-pangkat-pilihan',
            'kenaikan-pangkat-anumerta',
            'kenaikan-pangkat-pengabdian',
        ])->delete();
    }
};
