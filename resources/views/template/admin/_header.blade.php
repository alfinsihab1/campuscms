<!-- Navbar-->
<header class="app-header">
  <a class="app-header__logo" href="/" target="_blank">
    <!-- <img width="160" src="{{asset('assets/images/logo/campusnet.webp')}}"> -->
  </a>
  <!-- Sidebar toggle button-->
  <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav ml-auto ml-md">
    <!-- Setting Menu-->
    <li><a class="app-nav__item" href="{{ route('admin.rolepermission.index') }}" data-toggle="tooltip" title="Role Permission"><i class="fa fa-exclamation-triangle fa-lg"></i></a></li>
    <!-- Notification Menu-->
    <li class="dropdown">
      <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Show notifications">
        <i class="fa fa-bell fa-lg"></i>
        @if(count_notif_all() > 0)
        <span class="badge badge-info">{{ count_notif_all() }}</span>
        @endif
      </a>
      <ul class="app-notification dropdown-menu dropdown-menu-right">
        <li class="app-notification__title">Kamu punya <strong>{{ count_notif_all() }}</strong> pemberitahuan baru.</li>
        <div class="app-notification__content">
          <li>
            <a class="app-notification__item" href="{{ route('admin.komisi.index') }}"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-success"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
              <div>
                <p class="app-notification__message">Verifikasi Komisi</p>
                <p class="app-notification__meta">{{ count_notif_komisi() }} pemberitahuan baru</p>
              </div>
            </a>
          </li>
          <li>
            <a class="app-notification__item" href="{{ route('admin.withdrawal.index') }}"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-warning"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
              <div>
                <p class="app-notification__message">Pengambilan Komisi</p>
                <p class="app-notification__meta">{{ count_notif_withdrawal() }} pemberitahuan baru</p>
              </div>
            </a>
          </li>
          <li>
            <a class="app-notification__item" href="{{ route('admin.pelatihan.transaction') }}"><span class="app-notification__icon"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x text-primary"></i><i class="fa fa-money fa-stack-1x fa-inverse"></i></span></span>
              <div>
                <p class="app-notification__message">Pembayaran Pelatihan</p>
                <p class="app-notification__meta">{{ count_notif_pelatihan() }} pemberitahuan baru</p>
              </div>
            </a>
          </li>
        </div>
        <!-- <li class="app-notification__footer"><a href="#">See all notifications.</a></li> -->
      </ul>
    </li>
    <!-- /Notification Menu-->
    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-cog fa-lg"></i> Profil</a></li>
        @if(Auth::user()->role == role('manager') || Auth::user()->role == role('mentor'))
        <li><a class="dropdown-item" href="{{ route('admin.signature.input') }}"><i class="fa fa-tint fa-lg"></i> Tandatangan</a></li>
        @endif
        <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        <form id="form-logout" method="post" action="{{ route('admin.logout') }}">
            {{ csrf_field() }}
        </form>
      </ul>
    </li>
    <!-- /User Menu-->
  </ul>
</header>