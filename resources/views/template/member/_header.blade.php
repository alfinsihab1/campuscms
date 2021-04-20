<!-- Navbar-->
<header class="app-header">
  <a class="app-header__logo" href="{{ route('site.home') }}" target="_blank">
    Member Area
    <!-- <img width="160" src="{{asset('assets/images/logo/campusnet.webp')}}"> -->
  </a>
  <!-- Sidebar toggle button-->
  <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav ml-auto ml-md">
    <!-- User Menu -->
    <li class="dropdown" data-toggle="tooltip" title="Akun"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="{{ route('member.profile') }}"><i class="fa fa-cog fa-lg"></i> Profil</a></li>
        @if(has_access('SignatureController::input', Auth::user()->role, false))
        <li><a class="dropdown-item" href="{{ route('member.signature.input') }}"><i class="fa fa-tint fa-lg"></i> Tandatangan</a></li>
        @endif
        <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        <form id="form-logout" method="post" action="{{ route('member.logout') }}">
            {{ csrf_field() }}
        </form>
      </ul>
    </li>
    <!-- /User Menu -->
  </ul>
</header>