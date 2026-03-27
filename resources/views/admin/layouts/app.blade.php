<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'ROSMO Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.css') }}" />
    @stack('styles')
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <p>
                    {{ Auth::user()->name }}
                    <small>Admin</small>
                  </p>
                </li>
                <li class="user-footer">
                  <a href="{{ url('/') }}" class="btn btn-default btn-flat" target="_blank">Lihat Web</a>
                  <form action="{{ route('logout') }}" method="POST" class="float-end">
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat">Sign out</button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">ROSMO Admin</span>
          </a>
        </div>
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
              <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
              <li class="nav-header">CMS & KONTEN</li>
              <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Pengaturan & SEO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.team_members.index') }}" class="nav-link {{ request()->routeIs('admin.team_members.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-person-lines-fill"></i>
                  <p>Tim Kami</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-images"></i>
                  <p>Galeri</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-folder2-open"></i>
                  <p>Media Library</p>
                </a>
              </li>

              <li class="nav-header">BERITA & POSTINGAN</li>
              <li class="nav-item">
                <a href="{{ route('admin.news.index') }}" class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-newspaper"></i>
                  <p>Berita</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-megaphone"></i>
                  <p>Pengumuman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.service_requirements.index') }}" class="nav-link {{ request()->routeIs('admin.service_requirements.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-clipboard-check"></i>
                  <p>Persyaratan Layanan</p>
                </a>
              </li>
              @if(auth()->user()->role === 'super_admin')
              <li class="nav-header">ADMINISTRATION</li>
              <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-people"></i>
                  <p>Manajemen Pengguna</p>
                </a>
              </li>
              @endif
            </ul>
          </nav>
        </div>
      </aside>
      
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">@yield('page_title', 'Dashboard')</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </main>
      
      <footer class="app-footer">
        <strong>Copyright &copy; {{ date('Y') }} ROSMO Admin.</strong>
      </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    @stack('scripts')
  </body>
</html>