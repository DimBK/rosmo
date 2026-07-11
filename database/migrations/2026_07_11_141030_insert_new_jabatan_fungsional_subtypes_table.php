<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pengangkatan Pertama pada Jabatan Fungsional
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Pengangkatan Pertama pada Jabatan Fungsional',
            'slug' => 'jf-pengangkatan-pertama',
            'content' => '<p>Pengangkatan pertama merupakan pengangkatan untuk mengisi lowongan kebutuhan Jabatan Fungsional (JF) yang telah ditetapkan, khusus bagi Calon PNS (CPNS) setelah resmi diangkat menjadi PNS 100%. Berdasarkan Permenpan RB No. 1 Tahun 2023, pengangkatan pertama wajib dilaksanakan paling lama 1 (satu) tahun setelah PNS dilantik.</p>',
            'highlights' => '<ol><li>Berstatus PNS aktif (telah diambil sumpah PNS).</li><li>Memiliki kualifikasi pendidikan sesuai dengan formasi JF yang dilamar saat seleksi CPNS.</li><li>Tingkat golongan ruang paling rendah disesuaikan dengan jenjang JF yang dituju (misal Golongan III/a untuk JF Ahli Pertama).</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari Kepala Instansi/Kepala Biro Kepegawaian.</li><li>Salinan sah SK CPNS dan SK PNS.</li><li>Salinan sah Ijazah dan Transkrip Nilai yang digunakan saat melamar CPNS.</li><li>Penilaian Kinerja (SKP) minimal bernilai Baik selama masa percobaan/CPNS.</li><li>Surat Keterangan Sehat Jasmani dan Rohani.</li></ol>',
            'not_included' => '<ol><li>Sertifikat Uji Kompetensi (karena pengangkatan pertama langsung ditunjuk dari formasi kelulusan tanpa uji kompetensi tambahan).</li><li>Penetapan Angka Kredit (PAK) kumulatif lama.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Pengangkatan Dalam Jabatan Fungsional Melalui Jabatan Lain
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Pengangkatan JF Melalui Perpindahan dari Jabatan Lain',
            'slug' => 'jf-perpindahan-jabatan-lain',
            'content' => '<p>Mekanisme pengangkatan dalam JF melalui perpindahan dari jabatan lain (baik dari jabatan administrasi/struktural ke fungsional, maupun perpindahan antar-JF yang setara) merupakan jalur pengembangan karier untuk mengoptimalkan potensi PNS. Pengusulan wajib mengikuti ketentuan Permenpan RB No. 1 Tahun 2023 dan Peraturan BKN No. 3 Tahun 2023.</p>',
            'highlights' => '<ol><li>Tersedia lowongan kebutuhan (formasi) pada JF yang dituju.</li><li>Memiliki pengalaman dalam pelaksanaan tugas di bidang JF yang akan diduduki minimal 2 (dua) tahun.</li><li>Nilai predikat kinerja (SKP) minimal Baik dalam 2 (dua) tahun terakhir.</li><li>Usia maksimal: 53 tahun untuk JF Keterampilan, Ahli Pertama, Ahli Muda; 55 tahun untuk JF Ahli Madya; 60/63 tahun untuk JF Ahli Utama.</li><li>Wajib lulus Uji Kompetensi (Ukom) yang diselenggarakan instansi pembina JF terkait.</li></ol>',
            'included' => '<ol><li>Surat Usulan Perpindahan Jabatan dari Instansi Pengusul.</li><li>Rekomendasi Lulus Uji Kompetensi (asli/salinan sah) dari Instansi Pembina.</li><li>Salinan sah SK Pangkat Terakhir dan SK Jabatan Terakhir.</li><li>Salinan sah SKP 2 tahun terakhir.</li><li>Salinan sah Ijazah terakhir yang relevan dengan JF yang dituju.</li><li>Surat Pernyataan memiliki pengalaman di bidang JF terkait minimal 2 tahun dari Pejabat Tinggi Pratama.</li></ol>',
            'not_included' => '<ol><li>Surat Pernyataan Bebas Temuan Keuangan (kecuali dipersyaratkan khusus oleh instansi asal).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Kenaikan Jabatan Fungsional
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Kenaikan Jabatan Fungsional (Kenaikan Jenjang)',
            'slug' => 'jf-kenaikan-jenjang',
            'content' => '<p>Kenaikan Jabatan Fungsional (alih jenjang secara vertikal) diberikan kepada pejabat fungsional yang telah memenuhi persyaratan angka kredit kumulatif yang ditentukan dari hasil konversi predikat kinerja tahunan, serta lulus uji kompetensi kenaikan jenjang jabatan.</p>',
            'highlights' => '<ol><li>Tersedia lowongan kebutuhan (formasi) pada jenjang JF yang lebih tinggi.</li><li>Memenuhi Angka Kredit Kumulatif minimal yang dipersyaratkan untuk kenaikan jenjang.</li><li>Predikat kinerja (SKP) minimal Baik dalam 1 (satu) tahun terakhir.</li><li>Wajib lulus Uji Kompetensi (Ukom) kenaikan jenjang jabatan.</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari Biro Kepegawaian/BKPSDM.</li><li>Salinan sah SK Jabatan Fungsional terakhir.</li><li>Salinan sah SK Kenaikan Pangkat terakhir.</li><li>Sertifikat Kelulusan Uji Kompetensi Kenaikan Jenjang (asli/salinan sah).</li><li>Laporan Hasil Konversi Angka Kredit (PAK Konversi) berdasarkan predikat kinerja tahun terakhir.</li><li>Salinan sah SKP 2 tahun terakhir.</li></ol>',
            'not_included' => '<ol><li>DUPAK (Daftar Usulan Penetapan Angka Kredit) fisik (karena sudah dihapus dan diganti dengan konversi kinerja e-Kinerja/SIASN).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Perpindahan Jabatan Fungsional Kategori Keterampilan ke Keahlian
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Perpindahan JF Kategori Keterampilan ke Keahlian',
            'slug' => 'jf-keterampilan-ke-keahlian',
            'content' => '<p>Perpindahan JF dari kategori Keterampilan ke kategori Keahlian (alih kategori) ditujukan bagi pejabat fungsional kategori keterampilan yang telah menyelesaikan pendidikan formal minimal Sarjana (S1) atau Diploma IV yang relevan dengan rumpun JF-nya dan ingin meningkatkan karier ke jenjang keahlian.</p>',
            'highlights' => '<ol><li>Telah memiliki ijazah S1/D4 yang relevan dengan JF keahlian yang dituju.</li><li>Wajib lulus Uji Kompetensi (Ukom) alih kategori Keterampilan ke Keahlian.</li><li>Tersedia formasi/lowongan kebutuhan pada JF Keahlian yang dituju di unit organisasi.</li><li>Pangkat/golongan ruang minimal disesuaikan dengan syarat golongan awal JF Keahlian Pertama (misal Gol. III/a).</li></ol>',
            'included' => '<ol><li>Surat Pengantar usulan alih kategori dari BKPSDM/Instansi.</li><li>Salinan sah Ijazah S1/D4 dan Transkrip Nilai yang telah diakreditasi/dicantumkan gelar akademiknya.</li><li>Sertifikat Kelulusan Uji Kompetensi Alih Kategori (Keterampilan ke Keahlian).</li><li>Salinan sah SK Kenaikan Pangkat terakhir dan SK Jabatan Fungsional terakhir.</li><li>Salinan sah SKP 2 tahun terakhir dengan predikat minimal Baik.</li><li>Surat Keterangan Ketersediaan Formasi JF Keahlian dari Bagian Organisasi/Kepegawaian.</li></ol>',
            'not_included' => '<ol><li>Surat Izin Mengemudi Dinas atau berkas non-akademik lainnya.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Pemberhentian dan Pengangkatan Kembali Jabatan Fungsional
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Pemberhentian dan Pengangkatan Kembali Jabatan Fungsional',
            'slug' => 'jf-pemberhentian-pengangkatan-kembali',
            'content' => '<p>Pejabat Fungsional dapat diberhentikan sementara dari jabatannya karena alasan tertentu (seperti diangkat menjadi Pejabat Struktural/JPT, menjalani Cuti Luar Tanggungan Negara, atau ditugaskan penuh di luar JF). Layanan Pengangkatan Kembali memfasilitasi PNS tersebut untuk kembali menduduki JF lamanya setelah alasan pemberhentian berakhir.</p>',
            'highlights' => '<ol><li>Pemberhentian: Dilakukan apabila pejabat fungsional tidak lagi memenuhi syarat jabatan atau ditugaskan dalam jabatan lain.</li><li>Pengangkatan Kembali: Menggunakan angka kredit terakhir yang dimiliki sebelum diberhentikan ditambah angka kredit dari predikat kinerja selama masa tugas non-JF (bila relevan/diatur khusus).</li><li>Masa pengusulan pengangkatan kembali disesuaikan dengan berakhirnya masa tugas jabatan lain/CLTN/tugas belajar.</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari Kepala Instansi/OPD.</li><li>Salinan sah SK Pemberhentian dari Jabatan Fungsional sebelumnya.</li><li>Salinan sah SK Pengangkatan dalam Jabatan Struktural / dokumen berakhirnya masa tugas/CLTN.</li><li>Salinan sah SK Pangkat terakhir dan SK Jabatan terakhir.</li><li>Penilaian Kinerja (SKP) selama menduduki jabatan non-JF terakhir (minimal Baik).</li><li>Laporan PAK Terakhir (sebelum diberhentikan).</li></ol>',
            'not_included' => '<ol><li>Uji Kompetensi Ulang (kecuali jika terjadi kenaikan jenjang saat pengangkatan kembali atau masa jeda melampaui batas tertentu).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Pelantikan Jabatan Fungsional
        DB::table('service_requirements')->insert([
            'parent_id' => 24,
            'title' => 'Pelantikan Jabatan Fungsional',
            'slug' => 'jf-pelantikan',
            'content' => '<p>Setiap PNS yang diangkat ke dalam Jabatan Fungsional (baik melalui pengangkatan pertama, perpindahan jabatan, penyesuaian/inpassing, maupun promosi) wajib dilantik dan mengangkat sumpah/janji jabatan menurut agamanya masing-masing sebelum melaksanakan tugas jabatannya secara sah.</p>',
            'highlights' => '<ol><li>Merupakan syarat mutlak keabsahan administrasi dan pembayaran tunjangan jabatan fungsional.</li><li>Pelantikan dipimpin oleh Pejabat Pembina Kepegawaian (PPK) atau pejabat lain yang didelegasikan secara sah.</li><li>Peserta yang dilantik akan menandatangani Berita Acara Pelantikan dan Surat Pernyataan Menduduki Jabatan (SPMJ).</li></ol>',
            'included' => '<ol><li>Surat Undangan Pelantikan resmi dari Biro Kepegawaian/BKPSDM.</li><li>Salinan sah Surat Keputusan (SK) Pengangkatan dalam Jabatan Fungsional yang bersangkutan.</li><li>Formulir kesediaan pelantikan dan sumpah jabatan.</li><li>Dokumen identitas diri (KTP/NIP) dan pasfoto formal terbaru.</li></ol>',
            'not_included' => '<ol><li>Dokumen penilaian kinerja (karena pelantikan merupakan upacara seremonial pengesahan SK yang sudah terbit).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('service_requirements')->whereIn('slug', [
            'jf-pengangkatan-pertama',
            'jf-perpindahan-jabatan-lain',
            'jf-kenaikan-jenjang',
            'jf-keterampilan-ke-keahlian',
            'jf-pemberhentian-pengangkatan-kembali',
            'jf-pelantikan',
        ])->delete();
    }
};
