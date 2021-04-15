
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
        
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'e-learning']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'e-learning']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Learning</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'e-library']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'e-library']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Library</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'e-competence']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'e-competence']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Competence</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'e-course']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'e-course']) }}"><i class="app-menu__icon fa fa-video-camera"></i><span class="app-menu__label">Materi E-Course</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'script']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'script']) }}"><i class="app-menu__icon fa fa-file-text-o"></i><span class="app-menu__label">Kumpulan Copywriting</span></a></li>
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.filemanager.index', ['kategori' => 'tools']))) ? 'active' : '' }}" href="{{ route('member.filemanager.index', ['kategori' => 'tools']) }}"><i class="app-menu__icon fa fa-wrench"></i><span class="app-menu__label">Kumpulan Tools</span></a></li>

        <li class="treeview {{ is_int(strpos(Request::url(), route('member.pelatihan.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-graduation-cap"></i><span class="app-menu__label">Pelatihan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.pelatihan.index'))) && !is_int(strpos(Request::url(), route('member.pelatihan.trainer'))) ? 'active' : '' }}" href="{{ route('member.pelatihan.index') }}"><i class="icon fa fa-circle-o"></i> Pelatihan Tersedia</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.pelatihan.trainer'))) ? 'active' : '' }}" href="{{ route('member.pelatihan.trainer') }}"><i class="icon fa fa-circle-o"></i> Pelatihan Kamu</a></li>
          </ul>
        </li>

        <li class="treeview {{ is_int(strpos(Request::url(), route('member.sertifikat.trainer.index'))) || is_int(strpos(Request::url(), route('member.sertifikat.peserta.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-certificate"></i><span class="app-menu__label">E-Sertifikat</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.sertifikat.trainer.index'))) ? 'active' : '' }}" href="{{ route('member.sertifikat.trainer.index') }}"><i class="icon fa fa-circle-o"></i> Trainer</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('member.sertifikat.peserta.index'))) ? 'active' : '' }}" href="{{ route('member.sertifikat.peserta.index') }}"><i class="icon fa fa-circle-o"></i> Peserta</a></li>
          </ul>
        </li>

        @if(Auth::user()->role == role('trainer'))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('member.signature.input'))) ? 'active' : '' }}" href="{{ route('member.signature.input') }}"><i class="app-menu__icon fa fa-tint"></i><span class="app-menu__label">Tandatangan Digital</span></a></li>
        @endif

      </ul>
    </aside>