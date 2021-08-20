
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

        @if(has_access('DashboardController::member', Auth::user()->role, false))
        <li><a class="app-menu__item {{ Request::path() == 'member' ? 'active' : '' }}" href="{{ route('member.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @endif

        @if(has_access('UserController::profile', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.profile'))) ? 'active' : '' }}" href="{{ route('member.profile') }}"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Profil</span></a></li>
        @endif

        @if(has_access('RekeningController::index', Auth::user()->role, false) || has_access('KomisiController::index', Auth::user()->role, false) || has_access('WithdrawalController::index', Auth::user()->role, false))
        <li class="treeview {{ strpos(Request::url(), '/member/transaksi') || strpos(Request::url(), '/member/rekening') || strpos(Request::url(), '/member/afiliasi') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">Afiliasi</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('RekeningController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.rekening.index'))) ? 'active' : '' }}" href="{{ route('member.rekening.index') }}"><i class="icon fa fa-circle-o"></i> Rekening Anda</a></li>
            @endif
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.afiliasi.carajualan'))) ? 'active' : '' }}" href="{{ route('member.afiliasi.carajualan') }}"><i class="icon fa fa-circle-o"></i> Cara Jualan</a></li>
            @if(has_access('KomisiController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.komisi.index'))) ? 'active' : '' }}" href="{{ route('member.komisi.index') }}"><i class="icon fa fa-circle-o"></i> Komisi</a></li>
            @endif
            @if(has_access('WithdrawalController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.withdrawal.index'))) ? 'active' : '' }}" href="{{ route('member.withdrawal.index') }}"><i class="icon fa fa-circle-o"></i> Withdrawal</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if(has_access('FileController::index', Auth::user()->role, false))
          @foreach(array_kategori_folder() as $kategori)
            @if(status_kategori_folder($kategori->slug_kategori))
            <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => $kategori->slug_kategori]))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori]) }}"><i class="app-menu__icon fa {{ $kategori->icon_kategori }}"></i><span class="app-menu__label">{{ $kategori->prefix_kategori.' '.$kategori->folder_kategori }}</span></a></li>
            @endif
          @endforeach
        @endif

        @if(has_access('PelatihanController::index', Auth::user()->role, false) || has_access('PelatihanController::trainer', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('member.pelatihan.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Pelatihan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('PelatihanController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.pelatihan.index'))) && !is_int(strpos(Request::url(), route('member.pelatihan.trainer'))) ? 'active' : '' }}" href="{{ route('member.pelatihan.index') }}"><i class="icon fa fa-circle-o"></i> Pelatihan Tersedia</a></li>
            @endif
            @if(has_access('PelatihanController::trainer', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.pelatihan.trainer'))) ? 'active' : '' }}" href="{{ route('member.pelatihan.trainer') }}"><i class="icon fa fa-circle-o"></i> Pelatihan Kamu</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('SertifikatController::indexTrainer', Auth::user()->role, false) || has_access('SertifikatController::indexParticipant', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('member.sertifikat.trainer.index'))) || is_int(strpos(Request::url(), route('member.sertifikat.peserta.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-certificate"></i><span class="app-menu__label">E-Sertifikat</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('SertifikatController::indexTrainer', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.sertifikat.trainer.index'))) ? 'active' : '' }}" href="{{ route('member.sertifikat.trainer.index') }}"><i class="icon fa fa-circle-o"></i> Trainer</a></li>
            @endif
            @if(has_access('SertifikatController::indexParticipant', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.sertifikat.peserta.index'))) ? 'active' : '' }}" href="{{ route('member.sertifikat.peserta.index') }}"><i class="icon fa fa-circle-o"></i> Peserta</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('SignatureController::input', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.signature.input'))) ? 'active' : '' }}" href="{{ route('member.signature.input') }}"><i class="app-menu__icon fa fa-tint"></i><span class="app-menu__label">Tandatangan Digital</span></a></li>
        @endif

      </ul>
    </aside>