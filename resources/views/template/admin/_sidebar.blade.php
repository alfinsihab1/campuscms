
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
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor'))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.blog.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Artikel</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.index'))) && !is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) && !is_int(strpos(Request::url(), route('admin.blog.tag.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.index') }}"><i class="icon fa fa-circle-o"></i> Data Artikel</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.tag.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.tag.index') }}"><i class="icon fa fa-circle-o"></i> Tag</a></li>
          </ul>
        </li>
        @endif
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor'))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.program.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Program</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.program.index'))) && !is_int(strpos(Request::url(), route('admin.program.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.program.index') }}"><i class="icon fa fa-circle-o"></i> Data Program</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.program.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.program.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
          </ul>
        </li>
        @endif
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor'))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.karir.index'))) ? 'active' : '' }}" href="{{ route('admin.karir.index') }}"><i class="app-menu__icon fa fa-handshake-o"></i><span class="app-menu__label">Karir</span></a></li>
        @endif
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-learning']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-learning']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Learning</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-library']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-library']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Library</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-competence']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-competence']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Competence</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-course']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-course']) }}"><i class="app-menu__icon fa fa-video-camera"></i><span class="app-menu__label">Materi E-Course</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.pelatihan.index'))) ? 'active' : '' }}" href="{{ route('admin.pelatihan.index') }}"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Pelatihan</span></a></li>
        @if(Auth::user()->role == role('it') || Auth::user()->role == role('manager'))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.slider.index'))) || is_int(strpos(Request::url(), route('admin.fitur.index'))) || is_int(strpos(Request::url(), route('admin.mitra.index'))) || is_int(strpos(Request::url(), route('admin.mentor.index'))) || is_int(strpos(Request::url(), route('admin.testimoni.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-desktop"></i><span class="app-menu__label">Konten Situs</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.slider.index'))) ? 'active' : '' }}" href="{{ route('admin.slider.index') }}"><i class="icon fa fa-circle-o"></i> Slider</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.fitur.index'))) ? 'active' : '' }}" href="{{ route('admin.fitur.index') }}"><i class="icon fa fa-circle-o"></i> Fitur</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.mitra.index'))) ? 'active' : '' }}" href="{{ route('admin.mitra.index') }}"><i class="icon fa fa-circle-o"></i> Mitra</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.mentor.index'))) ? 'active' : '' }}" href="{{ route('admin.mentor.index') }}"><i class="icon fa fa-circle-o"></i> Mentor</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.testimoni.index'))) ? 'active' : '' }}" href="{{ route('admin.testimoni.index') }}"><i class="icon fa fa-circle-o"></i> Testimoni</a></li>
          </ul>
        </li>
        @endif
      </ul>
    </aside>