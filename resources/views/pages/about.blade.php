@extends('layouts.app')

@section('body_class', 'about-page')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});">
      <div class="container position-relative">
        <h1>Tentang Kami</h1>
        <p>Peraturan Menteri Kehutanan Nomor 1 Tahun 2024 tentang Organisasi dan Tata Kerja Kementerian Kehutanan</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">About</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel About Section -->
    <section id="travel-about" class="travel-about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto text-center mb-5">
            <div class="intro-content" data-aos="fade-up" data-aos-delay="200">
              <h2>Biro Sumber Daya Manusia dan Organisasi</h2>
              <!-- <p class="lead">Born from a love of exploration and discovery, we've spent the last decade turning wanderlust into life-changing experiences for adventurous souls around the globe.</p> -->
            </div>
          </div>
        </div>

        <div class="row align-items-center mb-5">

          <div class="col-lg-12" data-aos="slide-left" data-aos-delay="400">
            <div class="story-content">
              <div class="story-badge">
                <i class="bi bi-compass"></i>
                <span>Tugas dan Fungsi</span>
              </div>
              <h3>Tugas</h3>
              <p class="justified-text">Mempunyai tugas penyiapan  koordinasi  perencanaan,  pengadaan, pengangkatan  pegawai,  perpanjangan  perjanjian  masa  kerja, pembinaan dan pelaksanaan penempatan kembali, penataan, kenaikan pangkat, pengembangan karier, manajemen talenta, mutasi,  cuti,  perceraian,  promosi,  pemensiunan, pemberhentian,  pemutusan  hubungan  perjanjian  kerja,  pemberian  penghargaan,  sanksi  disiplin,  tugas  dan  izin belajar  pegawai,  penilaian  kinerja  aparatur  sipil  negara, pengelolaan  dan  pembinaan  jabatan  pimpinan  tinggi  dan jabatan administrasi, serta pengelolaan data dan informasi.</p>

              <h3>Fungsi</h3>
              <p class="justified-text">Mempunyai fungsi penyiapan koordinasi perencanaan, pengadaan dan pengangkatan aparatur sipil negara;  pelaksanaan pengelolaan dan pembinaan jabatan pimpinan tinggi, jabatan administrasi, dan jabatan fungsional; penyiapan pembinaan, pengembangan karir, tugas dan izin belajar pegawai, promosi, dan manajemen talenta; pelaksanaan urusan penilaian kinerja, evaluasi kinerja, dan perpanjangan perjanjian masa kerja aparatur sipil negara di lingkup Kementerian; pengelolaan data dan informasi sumber daya manusia; pelaksanaan penataan pegawai, penempatan kembali, kenaikan pangkat, kenaikan jabatan, mutasi, cuti, dan perceraian; pelaksanaan urusan pensiun, pemberhentian, dan pemutusan hubungan perjanjian kerja aparatur sipil negara; pelaksanaan urusan pemberian penghargaan dan sanksi disiplin; penyiapan bahan pembinaan, penataan dan evaluasi organisasi, dan tata laksana; penyiapan bahan pembinaan pelayanan publik lingkup Kementerian; fasilitasi reformasi birokrasi Kementerian; dan pelaksanaan urusan tata usaha dan rumah tangga biro.</p>

              <div class="mission-box">
                <div class="mission-icon">
                  <i class="bi bi-book"></i>
                </div>
                <div class="mission-text">
                  <h4>Regulasi</h4>
                  <p >Peraturan Menteri Kehutanan Nomor 1 Tahun 2024 tentang Organisasi dan Tata Kerja Kementerian Kehutanan</p>
                  <a href="https://peraturan.bpk.go.id/Details/320587/permenhut-no-1-tahun-2024" class="contact-link">Download Peraturan</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="features-grid" data-aos="fade-up" data-aos-delay="200">
              <div class="section-header text-center mb-5">
                <h3>Tim Kerja Kami</h3>
                <p>Berdasarkan tugas dan fungsi</p>
              </div>

              <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-people"></i>
                      </div>
                      <h4>Pengelolaan Perencanaan Pengadaan, Pemensiunan, dan Pemberhentian Pegawai</h4>
                      <p>Bagian Administrasi Kepegawaian</p>
                    </div>
                    <div class="feature-back">
                      <p>penyiapan koordinasi perencanaan, pengadaan,pengangkatan pegawai, perpanjangan perjanjian masa kerja,pemensiunan, pemberhentian, pemutusan hubungan perjanjian kerja</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-heart-pulse"></i>
                      </div>
                      <h4>Pengelolaan Jabatan Pimpinan Tinggi, Administrator, Pengawas dan  Disiplin </h4>
                      <p>Bagian Administrasi Kepegawaian</p>
                    </div>
                    <div class="feature-back">
                      <p>pengembangan karier, manajemen talenta, promosi, sanksi disiplin,pengelolaan dan pembinaan jabatan pimpinan tinggi dan jabatan administrasi</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-recycle"></i>
                      </div>
                      <h4>Pengelolaan Kepangkatan, Kinerja, dan Penghargaan </h4>
                      <p>Bagian Administrasi Kepegawaian</p>
                    </div>
                    <div class="feature-back">
                      <p>pembinaan dan pelaksanaan penempatan kembali, penataan,kenaikan pangkat,mutasi, cuti, perceraian, pemberian penghargaan, tugas dan izin belajar pegawai, penilaian kinerja aparatur sipil negara, </p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-sliders"></i>
                      </div>
                      <h4>Pengelolaan Data dan Informasi Kepegawaian  </h4>
                      <p>Bagian Administrasi Kepegawaian</p>
                    </div>
                    <div class="feature-back">
                      <p>pengelolaan data dan informasi</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                      </div>
                      <h4>Penataan Organisasi, Ketetatalaksanaan dan Reformasi Birokrasi</h4>
                      <p>Bagian Pengelolaan Jabatan Fungsional, Organisasi, dan Tata Laksana</p>
                    </div>
                    <div class="feature-back">
                      <p>memfasilitasi reformasi birokrasi Kementerian, pembinaan pelayanan publik lingkup Kementerian, penataan dan evaluasi organisasi dan tata laksana</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-star"></i>
                      </div>
                      <h4>Pengelolaan Administrasi Jabatan Fungsional</h4>
                      <p>Bagian Pengelolaan Jabatan Fungsional, Organisasi, dan Tata Laksana</p>
                    </div>
                    <div class="feature-back">
                      <p>melaksanakan pengelolaan dan pembinaan jabatan fungsional</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel About Section -->

  </main>
@endsection
