<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ROSMO - Biro Sumber Daya Manusia dan Organisasi Kementerian Kehutanan</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">


  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="@yield('body_class', 'index-page')">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('assets/img/apple-touch-icon.png') }}" alt="Logo ROSMO">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          
          <li><a href="{{ url('about') }}">Profile</a></li>
          <li class="dropdown"><a href="#"><span>Informasi Publik</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Peraturan</a></li>
              <li><a href="#">Siaran Pers</a></li>
              <li class="dropdown"><a href="#"><span>Dokumen Publik</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Rencana Kerja</a></li>
                  <li><a href="#">Rencana Strategis</a></li>
                  <li><a href="#">Laporan Kinerja</a></li>
                  <li><a href="#">Reformasi Birokrasi</a></li>
                  <li><a href="#">SPIP</a></li>
                  <li><a href="#">Laporan Kepuasan</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown"><a href="#menu" class="{{ request()->is('layanan*') ? 'active' : '' }}"><span>Persyaratan Layanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                @forelse($serviceMenu ?? [] as $menu)
                  @if($menu->children->count() > 0)
                    <li class="dropdown"><a href="{{ route('services.details', $menu->slug) }}"><span>{{ $menu->title }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                      <ul>
                        @foreach($menu->children as $child)
                          <li><a href="{{ route('services.details', $child->slug) }}">{{ $child->title }}</a></li>
                        @endforeach
                      </ul>
                    </li>
                  @else
                    <li><a href="{{ route('services.details', $menu->slug) }}">{{ $menu->title }}</a></li>
                  @endif
                @empty
                    <li><a href="#">Belum ada layanan</a></li>
                @endforelse
              </ul>
          </li>
          <li><a href="{{ url('gallery') }}">Statistik</a></li>
          <li><a href="{{ url('blog') }}">Regulasi</a></li>
          <li class="dropdown"><a href="#"><span>More Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="{{ url('destination-details') }}">Destination Details</a></li>
              <li><a href="{{ url('tour-details') }}">Tour Details</a></li>
              <li><a href="{{ url('booking') }}">Booking</a></li>
              <li><a href="testimonials">Testimonials</a></li>
              <li><a href="{{ url('faq') }}">Frequently Asked Questions</a></li>
              <li><a href="{{ url('blog-details') }}">Blog Details</a></li>
              <li><a href="{{ url('terms') }}">Terms</a></li>
              <li><a href="{{ url('privacy') }}">Privacy</a></li>
              <li><a href="{{ url('404') }}">404</a></li>
            </ul>
          </li>
          <li><a href="{{ url('contact') }}">Hubungi Kami</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <form action="{{ url('search') }}" method="GET" class="d-flex align-items-center ms-xl-3 ms-2" id="nav-search-form">
        <div class="search-wrap d-flex align-items-center" style="background:#f1f1f1; border-radius:30px; padding:2px; transition: all 0.3s ease;">
            <input type="text" name="q" id="nav-search-input" placeholder="Ketik lalu Enter..." value="{{ request('q') }}" style="border:none; background:transparent; outline:none; font-size:14px; width:0; padding:0; opacity:0; transition: all 0.3s ease;">
            <button type="button" id="nav-search-btn" style="border:none; background:#051e23; color:white; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; cursor:pointer;">
              <i class="bi bi-search" style="font-weight:bold;"></i>
            </button>
        </div>
      </form>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const btn = document.getElementById('nav-search-btn');
          const input = document.getElementById('nav-search-input');
          const form = document.getElementById('nav-search-form');
          
          // If already has query, keep it open
          if (input.value.trim() !== '') {
              input.style.width = '160px';
              input.style.padding = '2px 10px 2px 15px';
              input.style.opacity = '1';
          }

          btn.addEventListener('click', function(e) {
            if (input.style.width === '0px' || input.style.width === '') {
              e.preventDefault();
              input.style.width = '160px';
              input.style.padding = '2px 10px 2px 15px';
              input.style.opacity = '1';
              input.focus();
            } else {
              if(input.value.trim() === '') {
                 e.preventDefault();
                 input.style.width = '0';
                 input.style.padding = '0';
                 input.style.opacity = '0';
              } else {
                 form.submit();
              }
            }
          });
        });
      </script>

    </div>
  </header>

  
    @yield('content')


  <footer id="footer" class="footer position-relative dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ url('/') }}" class="d-flex align-items-center">
            <span class="sitename">ROSMO</span>
          </a>
            <p class="mb-4">Website resmi Biro Sumber Daya Manusia dan Organisasi merupakan bagian dari penerapan Sistem Pemerintah Berbasis Elektronik (SPBE) sebagaimana diamanatkan Peraturan Presiden Nomor 95 Tahun 2018.</p>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Link Terkait</h4>
            <ul>
              <li><a href="https://casn.kehutanan.go.id/"><i class="bi bi-chevron-right"></i> CASN</a></li>
              <li><a href="https://seleksijpt.kehutanan.go.id/"><i class="bi bi-chevron-right"></i> Seleksi JPT</a></li>
              <li><a href="https://www.kehutanan.go.id/"><i class="bi bi-chevron-right"></i> PPID</a></li>
            </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
            <h4>Layanan Lainnya</h4>
            <ul>
              <li><a href="https://asndigital.bkn.go.id/"><i class="bi bi-chevron-right"></i> ASN Digital BKN</a></li>
              <li><a href="https://sscasn.bkn.go.id/"><i class="bi bi-chevron-right"></i> SSCASN BKN</a></li>
              <li><a href="https://support-siasn.bkn.go.id/"><i class="bi bi-chevron-right"></i> Helpdesk BKN</a></li>
              <li><a href="https://sikadirklhk.id/"><i class="bi bi-chevron-right"></i> Sikadir Kehutanan</a></li>
              <li><a href="https://siapp.setneg.go.id/"><i class="bi bi-chevron-right"></i> SIAPP Setneg</a></li>
            </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href="https://www.tiktok.com/@rosmo_kemenhut"><i class="bi bi-tiktok"></i></a>
            <a href="https://www.youtube.com/@rosmokehutanan"><i class="bi bi-youtube"></i></a>
            <a href="https://www.instagram.com/rosmo_kemenhut/" class="instagram"><i class="bi bi-instagram"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Biro SDMO Kementerian Kehutanan 2025</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>