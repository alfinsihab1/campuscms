<!-- Navbar-->
<header class="app-header">
  <a class="app-header__logo" href="/" target="_blank">
    <!-- <img width="160" src="{{asset('assets/images/logo/campusnet.webp')}}"> -->
  </a>
  <!-- Sidebar toggle button-->
  <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav ml-auto ml-md">
    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="{{ route('member.profile') }}"><i class="fa fa-cog fa-lg"></i> Profil</a></li>
        <li><a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('form-logout').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
        <form id="form-logout" method="post" action="{{ route('member.logout') }}">
            {{ csrf_field() }}
        </form>
      </ul>
    </li>
  </ul>
</header>