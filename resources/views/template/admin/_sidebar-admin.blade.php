    <!-- Sidebar Menu -->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <ul class="app-menu">
        <li class="my-3 d-flex align-items-center justify-content-between justify-content-lg-center">
          <a class="app-nav__item menu-btn-green d-block d-lg-none" href="#" data-toggle="sidebar" style=><i class="fa fa-times" style="font-size: 1.5em"></i></a>
          <a class="h4 text-uppercase" href="{{ route('site.home') }}" target="_blank">
            <img class="a-app_logo" src="{{asset('assets/images/logo/'.setting('site.logo'))}}">
            <div class="wrap-b-app_logo"><img class="b-app_logo" src="{{asset('assets/images/icon/'.setting('site.icon'))}}"></div>
          </a>
          <a class="d-block d-lg-none" href="#"></a>
        </li>
        <hr>
        @if(has_access('DashboardController::admin', Auth::user()->role, false))
        <li><a class="app-menu__item {{ Request::path() == 'admin' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @endif

        @if(has_access('UserController::index', Auth::user()->role, false) || has_access('VisitorController::index', Auth::user()->role, false) || has_access('MediaController::index', Auth::user()->role, false) || has_access('RekeningController::index', Auth::user()->role, false) || has_access('DefaultRekeningController::index', Auth::user()->role, false) || has_access('KomisiController::index', Auth::user()->role, false) || has_access('WithdrawalController::index', Auth::user()->role, false) || has_access('PelatihanController::transaction', Auth::user()->role, false) || has_access('EmailController::index', Auth::user()->role, false))
        <div class="app-menu-title"><span class="font-weight-bold" style="color: var(--primary)">Data</span></div>
        @endif

        @if(has_access('UserController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), '/admin/user')) || is_int(strpos(Request::url(), route('admin.user.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('UserController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.user.index'))) && !is_int(strpos(Request::url(), route('admin.user.kelompok.index'))) && !is_int(strpos(Request::url(), route('admin.user.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.user.index') }}"><i class="icon fa fa-circle-o"></i> Data User</a></li>
            @endif
            @if(has_access('KategoriUserController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.user.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.user.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
            @if(has_access('KelompokController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.user.kelompok.index'))) ? 'active' : '' }}" href="{{ route('admin.user.kelompok.index') }}"><i class="icon fa fa-circle-o"></i> Kelompok</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if(has_access('StatistikController::member', Auth::user()->role, false) || has_access('StatistikController::device', Auth::user()->role, false) || has_access('StatistikController::location', Auth::user()->role, false) || has_access('StatistikController::finance', Auth::user()->role, false) || has_access('StatistikController::byTanggal', Auth::user()->role, false) || has_access('StatistikController::byKelompok', Auth::user()->role, false) || has_access('VisitorController::index', Auth::user()->role, false) || has_access('VisitorController::topVisitor', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), '/admin/statistik')) || is_int(strpos(Request::url(), route('admin.visitor.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Statistik</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('StatistikController::member', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.member'))) ? 'active' : '' }}" href="{{ route('admin.statistik.member') }}"><i class="icon fa fa-circle-o"></i> Member</a></li>
            @endif
            @if(has_access('StatistikController::device', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.device'))) ? 'active' : '' }}" href="{{ route('admin.statistik.device') }}"><i class="icon fa fa-circle-o"></i> Perangkat</a></li>
            @endif
            @if(has_access('StatistikController::location', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.location'))) ? 'active' : '' }}" href="{{ route('admin.statistik.location') }}"><i class="icon fa fa-circle-o"></i> Lokasi</a></li>
            @endif
            @if(has_access('StatistikController::finance', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.finance'))) ? 'active' : '' }}" href="{{ route('admin.statistik.finance') }}"><i class="icon fa fa-circle-o"></i> Keuangan</a></li>
            @endif
            @if(has_access('StatistikController::byTanggal', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.by-tanggal'))) ? 'active' : '' }}" href="{{ route('admin.statistik.by-tanggal') }}"><i class="icon fa fa-circle-o"></i> Berdasarkan Tanggal</a></li>
            @endif
            @if(has_access('StatistikController::byKelompok', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.statistik.by-kelompok'))) ? 'active' : '' }}" href="{{ route('admin.statistik.by-kelompok') }}"><i class="icon fa fa-circle-o"></i> Berdasarkan Kelompok</a></li>
            @endif
            @if(has_access('VisitorController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.visitor.index'))) && !is_int(strpos(Request::url(), route('admin.visitor.top'))) ? 'active' : '' }}" href="{{ route('admin.visitor.index') }}"><i class="icon fa fa-circle-o"></i> Visitor</a></li>
            @endif
            @if(has_access('VisitorController::topVisitor', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.visitor.top'))) ? 'active' : '' }}" href="{{ route('admin.visitor.top') }}"><i class="icon fa fa-circle-o"></i> Top Visitor</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('MediaController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.media.index'))) ? 'active' : '' }}" href="{{ route('admin.media.index') }}"><i class="app-menu__icon fa fa-image"></i><span class="app-menu__label">Media</span></a></li>
        @endif
        
        @if(has_access('RekeningController::index', Auth::user()->role, false) || has_access('PlatformController::index', Auth::user()->role, false) || has_access('DefaultRekeningController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.rekening.index'))) || is_int(strpos(Request::url(), route('admin.platform.index'))) || is_int(strpos(Request::url(), route('admin.default-rekening.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-id-card"></i><span class="app-menu__label">Rekening</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('RekeningController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.rekening.index'))) ? 'active' : '' }}" href="{{ route('admin.rekening.index') }}"><i class="icon fa fa-circle-o"></i> Data Rekening</a></li>
            @endif
            @if(has_access('PlatformController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.platform.index'))) ? 'active' : '' }}" href="{{ route('admin.platform.index') }}"><i class="icon fa fa-circle-o"></i> Platform</a></li>
            @endif
            @if(has_access('DefaultRekeningController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.default-rekening.index'))) ? 'active' : '' }}" href="{{ route('admin.default-rekening.index') }}"><i class="icon fa fa-circle-o"></i> Default Rekening</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('KomisiController::index', Auth::user()->role, false) || has_access('WithdrawalController::index', Auth::user()->role, false) || has_access('PelatihanController::transaction', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), '/admin/transaksi')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">Transaksi</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('KomisiController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.komisi.index'))) ? 'active' : '' }}" href="{{ route('admin.komisi.index') }}"><i class="icon fa fa-circle-o"></i> Komisi</a></li>
            @endif
            @if(has_access('WithdrawalController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.withdrawal.index'))) ? 'active' : '' }}" href="{{ route('admin.withdrawal.index') }}"><i class="icon fa fa-circle-o"></i> Withdrawal</a></li>
            @endif
            @if(has_access('PelatihanController::transaction', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.pelatihan.transaction'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.transaction') }}"><i class="icon fa fa-circle-o"></i> Pelatihan</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('EmailController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.email.index'))) ? 'active' : '' }}" href="{{ route('admin.email.index') }}"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Email</span></a></li>
        @endif

        @if(has_access('ReportController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.report.index'))) ? 'active' : '' }}" href="{{ route('admin.report.index') }}"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Report</span></a></li>
        @endif
        
        @if(has_access('FileController::index', Auth::user()->role, false))
          <div class="app-menu-title"><span class="font-weight-bold" style="color: var(--primary)">Materi</span></div>
          @foreach(array_kategori_folder() as $kategori)
            @if(status_kategori_folder($kategori->slug_kategori))
            <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori]))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori]) }}"><i class="app-menu__icon fa {{ $kategori->icon_kategori }}"></i><span class="app-menu__label">{{ $kategori->prefix_kategori.' '.$kategori->folder_kategori }}</span></a></li>
            @endif
          @endforeach
        @endif

        @if(has_access('HalamanController::index', Auth::user()->role, false) || has_access('BlogController::index', Auth::user()->role, false) || has_access('AcaraController::index', Auth::user()->role, false) || has_access('ProgramController::index', Auth::user()->role, false) || has_access('PelatihanController::index', Auth::user()->role, false) || has_access('KarirController::index', Auth::user()->role, false) || has_access('PsikologController::index', Auth::user()->role, false) || has_access('PopupController::index', Auth::user()->role, false))
        <div class="app-menu-title"><span class="font-weight-bold" style="color: var(--primary)">Konten</span></div>
        @endif

        @if(has_access('HalamanController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.halaman.index'))) ? 'active' : '' }}" href="{{ route('admin.halaman.index') }}"><i class="app-menu__icon fa fa-newspaper-o"></i><span class="app-menu__label">Halaman</span></a></li>
        @endif

        @if(has_access('BlogController::index', Auth::user()->role, false) || has_access('KategoriArtikelController::index', Auth::user()->role, false) || has_access('TagController::index', Auth::user()->role, false) || has_access('KontributorController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.blog.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Artikel</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('BlogController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.index'))) && !is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) && !is_int(strpos(Request::url(), route('admin.blog.tag.index'))) && !is_int(strpos(Request::url(), route('admin.blog.kontributor.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.index') }}"><i class="icon fa fa-circle-o"></i> Data Artikel</a></li>
            @endif
            @if(has_access('KategoriArtikelController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
            @if(has_access('TagController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.tag.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.tag.index') }}"><i class="icon fa fa-circle-o"></i> Tag</a></li>
            @endif
            @if(has_access('KontributorController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.kontributor.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.kontributor.index') }}"><i class="icon fa fa-circle-o"></i> Kontributor</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('AcaraController::index', Auth::user()->role, false) || has_access('KategoriAcaraController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.acara.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Acara</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('AcaraController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.acara.index'))) && !is_int(strpos(Request::url(), route('admin.acara.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.acara.index') }}"><i class="icon fa fa-circle-o"></i> Data Acara</a></li>
            @endif
            @if(has_access('KategoriAcaraController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.acara.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.acara.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('ProgramController::index', Auth::user()->role, false) || has_access('KategoriProgramController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.program.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-paper-plane"></i><span class="app-menu__label">Program</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('ProgramController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.program.index'))) && !is_int(strpos(Request::url(), route('admin.program.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.program.index') }}"><i class="icon fa fa-circle-o"></i> Data Program</a></li>
            @endif
            @if(has_access('KategoriProgramController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.program.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.program.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('PelatihanController::index', Auth::user()->role, false) || has_access('KategoriPelatihanController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.pelatihan.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Pelatihan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('PelatihanController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.pelatihan.index'))) && !is_int(strpos(Request::url(), route('admin.pelatihan.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.index') }}"><i class="icon fa fa-circle-o"></i> Data Pelatihan</a></li>
            @endif
            @if(has_access('KategoriPelatihanController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.pelatihan.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('KarirController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.karir.index'))) ? 'active' : '' }}" href="{{ route('admin.karir.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i><span class="app-menu__label">Karir</span></a></li>
        @endif

        @if(has_access('PsikologController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.psikolog.index'))) ? 'active' : '' }}" href="{{ route('admin.psikolog.index') }}"><i class="app-menu__icon fa fa-skyatlas"></i><span class="app-menu__label">Psikolog</span></a></li>
        @endif

        @if(has_access('PopupController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.pop-up.index'))) ? 'active' : '' }}" href="{{ route('admin.pop-up.index') }}"><i class="app-menu__icon fa fa-info-circle"></i><span class="app-menu__label">Pop-Up</span></a></li>
        @endif

        @if(has_access('SertifikatController::indexTrainer', Auth::user()->role, false) || has_access('SertifikatController::indexParticipant', Auth::user()->role, false) || has_access('SignatureController::index', Auth::user()->role, false) || has_access('AbsensiController::index', Auth::user()->role, false))
        <div class="app-menu-title"><span class="font-weight-bold" style="color: var(--primary)">Lainnya</span></div>
        @endif

        @if(has_access('SertifikatController::indexTrainer', Auth::user()->role, false) || has_access('SertifikatController::indexParticipant', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.sertifikat.trainer.index'))) || is_int(strpos(Request::url(), route('admin.sertifikat.peserta.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-certificate"></i><span class="app-menu__label">E-Sertifikat</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('SertifikatController::indexTrainer', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.sertifikat.trainer.index'))) ? 'active' : '' }}" href="{{ route('admin.sertifikat.trainer.index') }}"><i class="icon fa fa-circle-o"></i> Trainer</a></li>
            @endif
            @if(has_access('SertifikatController::indexParticipant', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.sertifikat.peserta.index'))) ? 'active' : '' }}" href="{{ route('admin.sertifikat.peserta.index') }}"><i class="icon fa fa-circle-o"></i> Peserta</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('SignatureController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.signature.index'))) ? 'active' : '' }}" href="{{ route('admin.signature.index') }}"><i class="app-menu__icon fa fa-tint"></i><span class="app-menu__label">Tandatangan Digital</span></a></li>
        @endif

        @if(has_access('AbsensiController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.absensi.index'))) ? 'active' : '' }}" href="{{ route('admin.absensi.index') }}"><i class="app-menu__icon fa fa-clipboard"></i><span class="app-menu__label">Absensi Online</span></a></li>
        @endif

      </ul>
    </aside>
