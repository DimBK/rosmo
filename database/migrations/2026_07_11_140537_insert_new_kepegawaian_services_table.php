<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Peninjauan Masa Kerja (PMK) PNS
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Peninjauan Masa Kerja (PMK) PNS',
            'slug' => 'peninjauan-masa-kerja',
            'content' => '<p>Peninjauan Masa Kerja (PMK) adalah proses peninjauan kembali masa kerja yang telah dijalani oleh seorang PNS sebelum diangkat menjadi CPNS. Masa kerja yang dapat ditinjau meliputi masa kerja di instansi pemerintah, BUMN, BUMD, atau lembaga/swasta berbadan hukum tertentu sesuai dengan ketentuan peraturan kepegawaian yang berlaku.</p>',
            'highlights' => '<ol><li>Masa kerja pada instansi pemerintah/BUMN/BUMD dihitung penuh (100%).</li><li>Masa kerja pada perusahaan/lembaga swasta berbadan hukum dihitung setengah (50%) dengan maksimal peninjauan 8 tahun.</li><li>Hanya diajukan setelah yang bersangkutan resmi diangkat menjadi PNS (100%).</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari Kepala Instansi/Kepala Biro Kepegawaian.</li><li>Salinan sah SK CPNS dan SK PNS.</li><li>Salinan sah SK Kenaikan Pangkat terakhir (jika ada).</li><li>Salinan sah Ijazah dan Transkrip Nilai yang digunakan saat pengangkatan CPNS.</li><li>Bukti Surat Keputusan (SK) pengangkatan dan pemberhentian dari tempat kerja sebelumnya yang memuat masa kerja asli secara sah.</li><li>Surat Keterangan Pengalaman Kerja asli dari pimpinan perusahaan/lembaga (swasta) atau pejabat berwenang (pemerintah).</li><li>Surat Keterangan bahwa tempat kerja swasta sebelumnya berbadan hukum resmi.</li></ol>',
            'not_included' => '<ol><li>Surat Tanda Lulus Ujian Dinas (STLUD).</li><li>SK Jabatan Fungsional/Struktural (kecuali untuk validasi masa tugas relevan).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Pencantuman Gelar Akademik
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Pencantuman Gelar Akademik PNS',
            'slug' => 'pencantuman-gelar',
            'content' => '<p>Layanan Pencantuman Gelar Akademik diberikan kepada PNS yang telah menyelesaikan pendidikan formal (Diploma, Sarjana, Magister, Doktor) baik melalui program izin belajar maupun tugas belajar. Gelar akademik yang sah akan dicantumkan dalam database kepegawaian nasional (SIASN) dan SK Kenaikan Pangkat berikutnya.</p>',
            'highlights' => '<ol><li>Program studi dan perguruan tinggi minimal terakreditasi B (atau Baik Sekali) saat kelulusan.</li><li>Pendidikan yang ditempuh harus relevan dengan tugas pokok dan fungsi instansi/jabatan PNS yang bersangkutan.</li><li>Pemberian persetujuan dilakukan secara digital melalui sistem aplikasi SIASN BKN.</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari pimpinan instansi/BKPSDM.</li><li>Salinan sah SK Pangkat Terakhir.</li><li>Salinan sah SK Tugas Belajar (TB) atau SK Izin Belajar (IB).</li><li>Asli dan salinan sah Ijazah serta Transkrip Nilai kelulusan terbaru.</li><li>Surat Keterangan Akreditasi Program Studi saat kelulusan (bila tidak tertera di ijazah/transkrip).</li><li>Salinan sah SK Jabatan Terakhir.</li><li>Penilaian Kinerja (SKP) 1 tahun terakhir dengan predikat minimal Baik.</li></ol>',
            'not_included' => '<ol><li>Ujian Penyesuaian Kenaikan Pangkat (UPKP) (kecuali jika mengajukan penyesuaian ijazah/golongan ruang).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Layanan Tugas Belajar
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Layanan Tugas Belajar (Penerbitan, Perpanjangan, & Pencabutan SK)',
            'slug' => 'tugas-belajar',
            'content' => '<p>Layanan Tugas Belajar memfasilitasi PNS yang terpilih untuk menempuh pendidikan tingkat lanjut (D3, S1/D4, S2, S3) yang dibiayai oleh negara atau sponsor resmi. Layanan ini mencakup Penerbitan SK Tugas Belajar awal, Perpanjangan SK Tugas Belajar (bila membutuhkan tambahan waktu studi resmi), serta Pencabutan/Pengaktifan Kembali setelah menyelesaikan masa studi.</p>',
            'highlights' => '<ol><li>Penerbitan SK TB: Masa kerja minimal 1 tahun sebagai PNS; usia maksimal disesuaikan jenjang (S1/S2/S3).</li><li>Perpanjangan SK TB: Diajukan paling lambat 6 bulan sebelum SK Tugas Belajar awal berakhir dengan rekomendasi promotor/kampus.</li><li>Pencabutan SK TB: Diajukan segera setelah lulus (wisuda) atau jika mahasiswa dinyatakan Drop Out/tidak dapat menyelesaikan studi.</li></ol>',
            'included' => '<ol><li>Surat pengantar instansi dan surat rekomendasi atasan langsung.</li><li>Surat Jaminan Pembiayaan (Sponsorship/Beasiswa) atau pernyataan pembiayaan mandiri.</li><li>Surat Penerimaan (Letter of Acceptance/LoA) dari Perguruan Tinggi yang dituju.</li><li>Penilaian Kinerja (SKP) bernilai Baik dalam 2 tahun terakhir.</li><li>Perjanjian ikatan dinas Tugas Belajar bermaterai.</li><li>Laporan Kemajuan Studi (Progress Report) dan Surat Keterangan Perpanjangan dari kampus (khusus Perpanjangan).</li><li>Salinan sah Ijazah/Kelulusan atau Transkrip Nilai akhir (khusus Pencabutan/Pengaktifan kembali).</li></ol>',
            'not_included' => '<ol><li>Surat Izin Belajar (karena izin belajar tidak dibebaskan dari tugas jabatan sehari-hari).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Fasilitas Penganugrahan Tanda Kehormatan Presiden
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Fasilitas Penganugrahan Tanda Kehormatan Presiden',
            'slug' => 'tanda-kehormatan',
            'content' => '<p>Layanan fasilitasi penganugrahan Tanda Kehormatan Satyalancana Karya Satya oleh Presiden Republik Indonesia diberikan kepada PNS sebagai penghargaan atas kesetiaan, pengabdian, kecakapan, kejujuran, dan disiplin secara terus-menerus selama kurun waktu 10, 20, atau 30 tahun.</p>',
            'highlights' => '<ol><li>Satyalancana Karya Satya X Tahun (Perunggu): Mengabdi terus menerus minimal 10 tahun.</li><li>Satyalancana Karya Satya XX Tahun (Perak): Mengabdi terus menerus minimal 20 tahun.</li><li>Satyalancana Karya Satya XXX Tahun (Emas): Mengabdi terus menerus minimal 30 tahun.</li><li>PNS yang bersangkutan tidak pernah dijatuhi hukuman disiplin tingkat sedang atau berat.</li></ol>',
            'included' => '<ol><li>Surat Pengantar dari Kepala Instansi/Kepala Biro Kepegawaian.</li><li>Daftar riwayat hidup kepegawaian ringkas khusus tanda kehormatan.</li><li>Salinan sah SK CPNS dan SK PNS.</li><li>Salinan sah SK Pangkat dan SK Jabatan Terakhir.</li><li>Surat Pernyataan tidak pernah dijatuhi hukuman disiplin tingkat sedang atau berat dari Inspektorat/Kepala Instansi.</li><li>Salinan sah Piagam/SK Satyalancana Karya Satya sebelumnya (jika mengusulkan tingkat berikutnya).</li></ol>',
            'not_included' => '<ol><li>Dokumen riwayat kesehatan medis mendalam.</li><li>Sertifikat pelatihan teknis/fungsional.</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Permohonan Pengambilan Sumpah/Janji PNS
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Permohonan Pengambilan Sumpah/Janji PNS',
            'slug' => 'sumpah-janji-pns',
            'content' => '<p>Pengambilan Sumpah/Janji PNS adalah kewajiban konstitusional bagi setiap Calon Pegawai Negeri Sipil (CPNS) sesaat setelah diangkat secara penuh menjadi Pegawai Negeri Sipil (PNS 100%). Sumpah/janji diucapkan di hadapan pejabat yang berwenang menurut agamanya masing-masing.</p>',
            'highlights' => '<ol><li>Wajib diikuti oleh seluruh CPNS yang telah menerima SK PNS 100% dan belum pernah diambil sumpahnya.</li><li>Prosesi dipandu oleh Pejabat Pembina Kepegawaian atau pejabat yang ditunjuk dan disaksikan oleh Rohaniwan resmi agama terkait.</li><li>Setiap peserta akan mendapatkan berita acara sumpah resmi yang ditandatangani oleh saksi-saksi dan rohaniwan.</li></ol>',
            'included' => '<ol><li>Surat Permohonan Pengambilan Sumpah/Janji PNS dari unit kerja.</li><li>Salinan sah SK CPNS.</li><li>Salinan sah SK PNS (100%).</li><li>Formulir biodata peserta sumpah yang memuat keterangan agama yang dianut.</li><li>Surat Keterangan Sehat dari Dokter Pemerintah.</li></ol>',
            'not_included' => '<ol><li>SK Kenaikan Pangkat (karena sumpah dilakukan di awal karier PNS).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 6. Cuti Luar Tanggungan Negara (CLTN) PNS
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Cuti Luar Tanggungan Negara (CLTN) PNS (Pemberian, Perpanjangan, & Pengaktifan)',
            'slug' => 'cuti-luar-tanggungan-negara',
            'content' => '<p>Cuti di Luar Tanggungan Negara (CLTN) dapat diberikan kepada PNS yang telah mengabdi minimal 5 tahun secara terus-menerus karena adanya alasan-alasan pribadi yang mendesak. Layanan ini mencakup: Pemberian CLTN awal (maksimal 3 tahun), Perpanjangan CLTN (maksimal 1 tahun), serta Pengaktifan Kembali PNS setelah masa CLTN selesai (wajib diajukan sebelum masa cuti habis).</p>',
            'highlights' => '<ol><li>CLTN diberikan tanpa menerima penghasilan dari negara dan masa cuti tidak dihitung sebagai masa kerja kepegawaian.</li><li>Alasan sah: Mendampingi suami/istri tugas negara/belajar, program keturunan, mendampingi anak/keluarga sakit keras, dll.</li><li>Pengaktifan Kembali: PNS wajib melapor dan mengajukan pengaktifan kembali paling lambat 1 (satu) bulan sebelum masa CLTN berakhir. Jika tidak melapor, PNS diberhentikan dengan hormat sebagai PNS.</li></ol>',
            'included' => '<ol><li>Surat Permohonan tertulis PNS bermaterai dengan mencantumkan alasan yang sah.</li><li>Salinan sah SK Pangkat terakhir dan SK CPNS/PNS.</li><li>Surat Pengantar dari Kepala Instansi.</li><li>Dokumen pendukung alasan cuti (misal: SK tugas belajar pasangan, surat dokter spesialis, akta nikah, dll).</li><li>Laporan persetujuan dari BKN (Pertimbangan Teknis/Pertek CLTN).</li><li>Surat Permohonan Pengaktifan Kembali setelah CLTN berakhir (khusus layanan Pengaktifan).</li><li>Surat Keterangan Bebas Temuan Keuangan/BMN.</li></ol>',
            'not_included' => '<ol><li>Daftar Penilaian Kinerja (SKP) selama masa cuti berjalan (karena PNS berstatus dibebaskan sementara).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 7. Izin Perceraian (PNS Gol. III-IV & PPPK Gol. IX Keatas)
        DB::table('service_requirements')->insert([
            'parent_id' => null,
            'title' => 'Izin Perceraian (PNS Gol. III-IV & PPPK Gol. IX Keatas)',
            'slug' => 'izin-perceraian',
            'content' => '<p>Berdasarkan Peraturan Pemerintah Nomor 10 Tahun 1983 jo. PP Nomor 45 Tahun 1990, setiap Pegawai Negeri Sipil (khususnya Golongan III dan IV) serta Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Golongan IX ke atas yang akan melakukan perceraian, baik sebagai penggugat maupun tergugat, wajib memperoleh izin tertulis atau surat keterangan terlebih dahulu dari Pejabat Pembina Kepegawaian (PPK).</p>',
            'highlights' => '<ol><li>Wajib diajukan secara tertulis melalui saluran hierarki atasan sebelum mendaftarkan gugatan ke Pengadilan Agama/Negeri.</li><li>Atasan langsung wajib melakukan mediasi/pembinaan damai terlebih dahulu sebelum meneruskan surat permohonan.</li><li>Melanggar ketentuan izin perceraian dapat berakibat pada penjatuhan hukuman disiplin tingkat berat.</li></ol>',
            'included' => '<ol><li>Surat Permohonan Izin Cerai tertulis bermaterai dengan mencantumkan alasan-alasan yang kuat.</li><li>Surat Pengantar dari Kepala Organisasi Perangkat Daerah (OPD)/Unit Kerja.</li><li>Salinan sah Berita Acara Pemeriksaan (BAP) mediasi oleh atasan langsung/tim pemeriksa.</li><li>Salinan sah SK CPNS, SK PNS (atau SK PPPK bagi PPPK).</li><li>Salinan sah SK Pangkat Terakhir.</li><li>Kutipan Akta Nikah (asli dan salinan sah).</li><li>Dokumen bukti pendukung gugatan perceraian (misal: surat pernyataan pisah ranjang, surat keterangan saksi dari kelurahan, dll).</li></ol>',
            'not_included' => '<ol><li>Putusan Pengadilan (karena izin harus dikantongi SEBELUM putusan pengadilan atau proses persidangan dimulai).</li></ol>',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('service_requirements')->whereIn('slug', [
            'peninjauan-masa-kerja',
            'pencantuman-gelar',
            'tugas-belajar',
            'tanda-kehormatan',
            'sumpah-janji-pns',
            'cuti-luar-tanggungan-negara',
            'izin-perceraian',
        ])->delete();
    }
};
