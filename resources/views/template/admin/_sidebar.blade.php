
    <!-- Sidebar Menu -->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
<!--       <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar" width="60" src="{{ image('assets/images/user/'.Auth::user()->foto, 'user') }}">
        <div>
          <p class="app-sidebar__user-name">{{ Auth::user()->nama_user }}</p>
          <p class="app-sidebar__user-designation">{{ role(Auth::user()->role) }}</p>
        </div>
      </div> -->
      <ul class="app-menu">
        <li><a class="app-menu__item {{ Request::path() == 'admin' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager'))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.user.index'))) ? 'active' : '' }}" href="{{ route('admin.user.index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span></a></li>
        @endif
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('finance'))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.rekening.index'))) ? 'active' : '' }}" href="{{ route('admin.rekening.index') }}"><i class="app-menu__icon fa fa-id-card"></i><span class="app-menu__label">Rekening</span></a></li>
        @endif
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('finance'))
        <li class="treeview {{ strpos(Request::url(), '/admin/transaksi') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">Transaksi</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.komisi.index'))) ? 'active' : '' }}" href="{{ route('admin.komisi.index') }}"><i class="icon fa fa-circle-o"></i> Komisi</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.withdrawal.index'))) ? 'active' : '' }}" href="{{ route('admin.withdrawal.index') }}"><i class="icon fa fa-circle-o"></i> Withdrawal</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.pelatihan.transaction'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.transaction') }}"><i class="icon fa fa-circle-o"></i> Pelatihan</a></li>
          </ul>
        </li>
        @endif
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.email.index'))) ? 'active' : '' }}" href="{{ route('admin.email.index') }}"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Email</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.pelatihan.index'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.index') }}"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Pelatihan</span></a></li>
      </ul>
    </aside>