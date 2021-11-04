<header class="app-header align-items-center">
  <a class="app-sidebar__toggle menu-btn-primary d-block" href="#" data-toggle="sidebar"></a>
  <ul class="app-nav d-block">
    <li class="app-nav__item" style="line-height: 15px">
      <h5 class="d-inline-block text-truncate m-0" style="color: var(--primary)">@yield('title')</h5>
      <div class="m-0 text-muted small d-none d-md-block">
        <ul class="breadcrumb breadcrumb-nav mb-0 p-0 bg-transparent"></ul>
      </div>
    </li>
  </ul>
  @if( Request::path() != 'admin' )
  @if (Auth::user()->role==role('it'))
  <dark-mode-toggle
    hidden=""
    appearance="toggle"
    permanent=""
  ></dark-mode-toggle>
  <li hidden="" id="exp"></li>
  @endif
  @endif
  <ul class="app-nav ml-auto ml-md">
    @if(has_access('KomisiController::index', Auth::user()->role, false) || has_access('WithdrawalController::index', Auth::user()->role, false) || has_access('PelatihanController::transaction', Auth::user()->role, false))
    <li class="dropdown">
      <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications">
        <i class="fa fa-bell fa-lg" data-toggle="tooltip" title="Notifikasi"></i>
        @if(count_notif_admin() > 0)
        <span class="badge badge-pill badge-danger">{{ count_notif_admin() }}</span>
        @endif
      </a>
      <ul class="app-notification dropdown-menu dropdown-menu-right">
        <div class="card">
          <div class="card-header">
            <p class="m-0 font-weight-bold">Notifikasi</p>  
          </div>
          <div class="card-body">
            <div class="row">
              @if(has_access('KomisiController::index', Auth::user()->role, false))
              <div class="col-6 border-right border-bottom">
                <a class="dropdown-item" href="{{ route('admin.komisi.index') }}">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span>
                  </span>
                  <span class="badge badge-pill badge-danger position-absolute">{{ count_notif_komisi() }}</span>
                  <p class="app-notification__message">Verifikasi<br>Komisi</p>
                </a>
              </div>
              @endif
              @if(has_access('WithdrawalController::index', Auth::user()->role, false))
              <div class="col-6 border-bottom">
                <a class="dropdown-item" href="{{ route('admin.withdrawal.index') }}">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-warning"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                  <span class="badge badge-pill badge-danger position-absolute">{{ count_notif_withdrawal() }}</span>
                  <div>
                    <p class="app-notification__message">Pengambilan<br>Komisi</p>
                  </div>
                </a>
              </div>
              @endif
              @if(has_access('PelatihanController::transaction', Auth::user()->role, false))
              <div class="col-6 border-right">
                <a class="dropdown-item" href="{{ route('admin.pelatihan.transaction') }}">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
                  <span class="badge badge-pill badge-danger position-absolute">{{ count_notif_pelatihan() }}</span>
                  <div>
                    <p class="app-notification__message">Pembayaran<br>Pelatihan</p>
                  </div>
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </ul>
    </li>
    @endif
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg" data-toggle="tooltip" title="Akun"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <div class="card">
          <div class="card-header">
            <div class="media">
              <img width="50" height="50" class="rounded mr-3" src="{{ image('assets/images/user/'.Auth::user()->foto, 'user') }}">
              <div class="media-body">
                <p class="m-0 font-weight-bold">{{ Auth::user()->nama_user }}</p>
                <p class="m-0"><small><i class="fa fa-bookmark mr-2"></i>{{ role(Auth::user()->role) }}</small></p>
              </div>
            </div>  
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6 border-right">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-cog fa-stack-1x fa-inverse"></i></span></span>
                  <p class="m-0">Profil</p>
                </a>
              </div>
              @if(has_access('SignatureController::input', Auth::user()->role, false))
              <div class="col-6">
                <a class="dropdown-item" href="{{ route('admin.signature.input') }}">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-info"></i><i class="fa fa-tint fa-stack-1x fa-inverse"></i></span></span>
                  <p class="m-0">Tandatangan</p>
                </a>
              </div>
              @endif
              <div class="col-6">
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                  <span class="app-notification__icon p-0"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-danger"></i><i class="fa fa-sign-out fa-stack-1x fa-inverse"></i></span></span>
                  <p class="m-0">Keluar</p>
                </a>
                <form id="form-logout" method="post" action="{{ route('admin.logout') }}">
                    {{ csrf_field() }}
                </form>
              </div>
            </div>
          </div>
        </div>
      </ul>
    </li>
    @if(has_access('SettingController::edit', Auth::user()->role, false) || has_access('PackageController::index', Auth::user()->role, false) || has_access('PackageController::me', Auth::user()->role, false) || has_access('ArtisanController::index', Auth::user()->role, false) || has_access('RoleController::index', Auth::user()->role, false) || has_access('RolePermissionController::index', Auth::user()->role, false))
    <li class="" data-toggle="tooltip" title="Peralatan"><a class="app-nav__item menu-btn-red" href="#" data-toggle="modal" data-target="#startMenu"><div class="blob red"></div><i class="fa fa-th-large fa-lg"></i></a>
    @endif
    </li>
  </ul>
</header>

<!-- Modal Start Menu -->
<div class="modal fade" id="startMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-full modal-dialog-scrollable">
    <div class="modal-content ">
      <div class="container">
        <div class="modal-header align-items-center pl-0">
          <h5 class="modal-title" id="exampleModalLabel" style="color: var(--red)">Peralatan</h5>
          <button type="button" class="close menu-btn-green" data-dismiss="modal" aria-label="Close" style="padding: .5em .7em; border-radius: .5em">
            <span aria-hidden="true"><i class="fa fa-times"></i></span>
          </button>
        </div>
      </div>
      <div class="modal-body">
        <div class="container">
        @if(has_access('SettingController::edit', Auth::user()->role, false))
        <h5><i class="fa fa-thumb-tack"></i> Pintasan</h5>
        <div class="row mb-4">
          <div class="col-6 col-lg-3 mb-3">
            <a class="text-decoration-none" href="{{ route('admin.setting.edit', ['category' => 'general']) }}">
            <div class="card">
              <div class="card-body menu-btn-red rounded-1">
                <i class="fa fa-desktop" style="font-size: 2em"></i>
                <h5 class="m-0">Umum</h5>
                <p class="m-0"><small>Pengaturan Website</small></p>
              </div>
            </div>
            </a>
          </div>
          <div class="col-6 col-lg-3 mb-3">
            <a class="text-decoration-none" href="{{ route('admin.setting.edit', ['category' => 'logo']) }}">
            <div class="card">
              <div class="card-body menu-btn-green rounded-1">
                <i class="fa fa-picture-o" style="font-size: 2em"></i>
                <h5 class="m-0">Logo</h5>
                <p class="m-0"><small>Logo Website</small></p>
              </div>
            </div>
            </a>
          </div>
          <div class="col-6 col-lg-3 mb-3">
            <a class="text-decoration-none" href="{{ route('admin.setting.edit', ['category' => 'icon']) }}">
            <div class="card">
              <div class="card-body menu-btn-yellow rounded-1">
                <i class="fa fa-gamepad" style="font-size: 2em"></i>
                <h5 class="m-0">Icon</h5>
                <p class="m-0"><small>Icon Website</small></p>
              </div>
            </div>
            </a>
          </div>
          <div class="col-6 col-lg-3 mb-3">
            <a class="text-decoration-none" href="{{ route('admin.setting.edit', ['category' => 'price']) }}">
            <div class="card">
              <div class="card-body menu-btn-blue rounded-1">
                <i class="fa fa-money" style="font-size: 2em"></i>
                <h5 class="m-0">Harga</h5>
                <p class="m-0"><small>Pengaturan Harga</small></p>
              </div>
            </div>
            </a>
          </div>
        </div>
        @endif
        <h5><i class="fa fa-cog"></i> Lainnya</h5>
        <div class="row">
          @if(has_access('LogController::index', Auth::user()->role, false) || has_access('LogController::login', Auth::user()->role, false))
          <div class="col-12 col-lg mb-3">
            <div class="heading">
              <h5 class="m-0 font-weight-bold mb-3 d-flex align-items-center">
                <i class="fa fa-list menu-btn-blue p-3 mr-2 rounded-1"></i>
                <div>
                  <p class="m-0">Log</p>
                </div>
              </h5>
            </div>
            <div class="list-group list-group-flush">
              @if(has_access('LogController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.log.index') }}"><i class="fa fa-circle-o"></i> Data Log</a>
              @endif
              @if(has_access('LogController::login', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.log.login') }}"><i class="fa fa-circle-o"></i> Login Error</a>
              @endif
            </div>
          </div>
          @endif
          @if(has_access('RoleController::index', Auth::user()->role, false) || has_access('RolePermissionController::index', Auth::user()->role, false))
          <div class="col-12 col-lg mb-3">
            <div class="heading">
              <h5 class="m-0 font-weight-bold mb-3 d-flex align-items-center">
                <i class="fa fa-key menu-btn-green p-3 mr-2 rounded-1"></i>
                <div>
                  <p class="m-0">Role</p>
                </div>
              </h5>
            </div>
            <div class="list-group list-group-flush">
              @if(has_access('RoleController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.role.index') }}"><i class="fa fa-circle-o"></i> Data Role</a>
              @endif
              @if(has_access('RolePermissionController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.rolepermission.index') }}"><i class="fa fa-circle-o"></i> Role Permission</a>
              @endif
            </div>
          </div>
          @endif
          @if(has_access('PackageController::index', Auth::user()->role, false) || has_access('PackageController::me', Auth::user()->role, false) || has_access('ArtisanController::index', Auth::user()->role, false))
          <div class="col-12 col-lg mb-3">
            <div class="heading">
              <h5 class="m-0 font-weight-bold mb-3 d-flex align-items-center">
                <i class="fa fa-wrench menu-btn-red p-3 mr-2 rounded-1"></i>
                <div>
                  <p class="m-0">Sistem</p>
                </div>
              </h5>
            </div>
            <div class="list-group list-group-flush">
              @if(has_access('PackageController::me', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.package.me') }}"><i class="fa fa-circle-o"></i> My Package</a>
              @endif
              @if(has_access('PackageController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.package.index') }}"><i class="fa fa-circle-o"></i> Package</a>
              @endif
              @if(has_access('ArtisanController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.artisan.index') }}"><i class="fa fa-circle-o"></i> Artisan</a>
              @endif
            </div>
          </div>
          @endif
          @if(has_access('SettingController::edit', Auth::user()->role, false) || has_access('FolderKategoriController::index', Auth::user()->role, false))
          <div class="col-12 col-lg mb-3">
            <div class="heading">
              <h5 class="m-0 font-weight-bold mb-3 d-flex align-items-center">
                <i class="fa fa-cogs menu-btn-yellow p-3 mr-2 rounded-1"></i>
                <div>
                  <p class="m-0">Pengaturan</p>
                </div>
              </h5>
            </div>
            <div class="list-group list-group-flush">
              @if (Auth::user()->role==role('it'))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'color']) }}"><i class="fa fa-circle-o"></i> Warna</a>
              @endif
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'certificate']) }}"><i class="fa fa-circle-o"></i> Sertifikat</a>
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'view']) }}"><i class="fa fa-circle-o"></i> Halaman</a>
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'receivers']) }}"><i class="fa fa-circle-o"></i> Notifikasi</a>
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'referral']) }}"><i class="fa fa-circle-o"></i> Referral</a>
              <a class="list-group-item list-group-item-action" href="{{ route('admin.setting.edit', ['category' => 'server']) }}"><i class="fa fa-circle-o"></i> Server</a>
              @if(has_access('FolderKategoriController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.folder.kategori.index') }}"><i class="fa fa-circle-o"></i> Kategori Folder</a>
              @endif
            </div>
          </div>
          @endif
          @if(has_access('SliderController::index', Auth::user()->role, false) || has_access('DeskripsiController::index', Auth::user()->role, false) || has_access('FiturController::index', Auth::user()->role, false) || has_access('CabangController::index', Auth::user()->role, false) || has_access('MitraController::index', Auth::user()->role, false) || has_access('MentorController::index', Auth::user()->role, false) || has_access('TestimoniController::index', Auth::user()->role, false))
          <div class="col-12 col-lg mb-3">
            <div class="heading">
              <h5 class="m-0 font-weight-bold mb-3 d-flex align-items-center">
                <i class="fa fa-desktop menu-btn-blue p-3 mr-2 rounded-1"></i>
                <div>
                  <p class="m-0">Konten Situs</p>
                </div>
              </h5>
            </div>
            <div class="list-group list-group-flush">
              @if(has_access('SliderController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.slider.index') }}"><i class="fa fa-circle-o"></i> Slider</a>
              @endif
              @if(has_access('DeskripsiController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.deskripsi.index') }}"><i class="fa fa-circle-o"></i> Deskripsi</a>
              @endif
              @if(has_access('FiturController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.fitur.index') }}"><i class="fa fa-circle-o"></i> Fitur</a>
              @endif
              @if(has_access('CabangController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.cabang.index') }}"><i class="fa fa-circle-o"></i> Cabang</a>
              @endif
              @if(has_access('MitraController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.mitra.index') }}"><i class="fa fa-circle-o"></i> Mitra</a>
              @endif
              @if(has_access('MentorController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.mentor.index') }}"><i class="fa fa-circle-o"></i> Mentor</a>
              @endif
              @if(has_access('TestimoniController::index', Auth::user()->role, false))
              <a class="list-group-item list-group-item-action" href="{{ route('admin.testimoni.index') }}"><i class="fa fa-circle-o"></i>Testimoni</a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
