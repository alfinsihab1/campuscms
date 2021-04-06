
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
        <li><a class="app-menu__item {{ Request::path() == 'member' ? 'active' : '' }}" href="{{ route('member.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview {{ strpos(Request::url(), '/member/transaksi') || strpos(Request::url(), '/member/rekening') || strpos(Request::url(), '/member/afiliasi') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">Afiliasi</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.rekening.index'))) ? 'active' : '' }}" href="{{ route('member.rekening.index') }}"><i class="icon fa fa-circle-o"></i> Rekening Anda</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.afiliasi.carajualan'))) ? 'active' : '' }}" href="{{ route('member.afiliasi.carajualan') }}"><i class="icon fa fa-circle-o"></i> Cara Jualan</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.komisi.index'))) ? 'active' : '' }}" href="{{ route('member.komisi.index') }}"><i class="icon fa fa-circle-o"></i> Komisi</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.withdrawal.index'))) ? 'active' : '' }}" href="{{ route('member.withdrawal.index') }}"><i class="icon fa fa-circle-o"></i> Withdrawal</a></li>
          </ul>
        </li>
      </ul>
    </aside>