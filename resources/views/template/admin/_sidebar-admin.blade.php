
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

        @if(has_access('DashboardController::admin', Auth::user()->role, false))
        <li><a class="app-menu__item {{ Request::path() == 'admin' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @endif

        @if(has_access('UserController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.user.index'))) ? 'active' : '' }}" href="{{ route('admin.user.index') }}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User</span></a></li>
        @endif
        
        @if(has_access('RoleController::index', Auth::user()->role, false) || has_access('RolePermissionController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.role.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-key"></i><span class="app-menu__label">Role</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('RoleController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.role.index'))) && !is_int(strpos(Request::url(), route('admin.rolepermission.index'))) ? 'active' : '' }}" href="{{ route('admin.role.index') }}"><i class="icon fa fa-circle-o"></i> Data Role</a></li>
            @endif
            @if(has_access('RolePermissionController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.rolepermission.index'))) ? 'active' : '' }}" href="{{ route('admin.rolepermission.index') }}"><i class="icon fa fa-circle-o"></i> Role Permission</a></li>
            @endif
          </ul>
        </li>
        @endif

        @if(has_access('CommandController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.command.index'))) ? 'active' : '' }}" href="{{ route('admin.command.index') }}"><i class="app-menu__icon fa fa-terminal"></i><span class="app-menu__label">Terminal</span></a></li>
        @endif
        
        @if(has_access('SettingController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.setting.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Pengaturan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'general']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'general']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Umum</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'logo']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'logo']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Logo</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'icon']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'icon']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Icon</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'price']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'price']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Harga</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'color']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'color']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Warna</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'certificate']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'certificate']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Sertifikat</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'view']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'view']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Halaman</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'receivers']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'receivers']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Penerima Notifikasi</a></li>
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.setting.edit', ['category' => 'referral']))) ? 'active' : '' }}" href="{{ route('admin.setting.edit', ['category' => 'referral']) }}"><i class="app-menu__icon fa fa-circle-o"></i> Referral</a></li>
          </ul>
        </li>
        @endif
        
        @if(has_access('RekeningController::index', Auth::user()->role, false) || has_access('DefaultRekeningController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.rekening.index'))) || is_int(strpos(Request::url(), route('admin.default-rekening.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-id-card"></i><span class="app-menu__label">Rekening</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('RekeningController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.rekening.index'))) ? 'active' : '' }}" href="{{ route('admin.rekening.index') }}"><i class="icon fa fa-circle-o"></i> Data Rekening</a></li>
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

        @if(has_access('FileController::index', Auth::user()->role, false))
          @if(status_kategori_folder('e-learning'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-learning']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-learning']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Learning</span></a></li>
          @endif
          @if(status_kategori_folder('e-library'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-library']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-library']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Library</span></a></li>
          @endif
          @if(status_kategori_folder('e-competence'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-competence']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-competence']) }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Materi E-Competence</span></a></li>
          @endif
          @if(status_kategori_folder('e-course'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'e-course']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'e-course']) }}"><i class="app-menu__icon fa fa-video-camera"></i><span class="app-menu__label">Materi E-Course</span></a></li>
          @endif
          @if(status_kategori_folder('script'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'script']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'script']) }}"><i class="app-menu__icon fa fa-file-text-o"></i><span class="app-menu__label">Kumpulan Copywriting</span></a></li>
          @endif
          @if(status_kategori_folder('tools'))
          <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.filemanager.index', ['kategori' => 'tools']))) ? 'active' : '' }}" href="{{ route('admin.filemanager.index', ['kategori' => 'tools']) }}"><i class="app-menu__icon fa fa-wrench"></i><span class="app-menu__label">Kumpulan Tools</span></a></li>
          @endif
        @endif

        @if(has_access('HalamanController::index', Auth::user()->role, false))
        <li><a class="app-menu__item {{ is_int(strpos(Request::url(), route('admin.halaman.index'))) ? 'active' : '' }}" href="{{ route('admin.halaman.index') }}"><i class="app-menu__icon fa fa-newspaper-o"></i><span class="app-menu__label">Halaman</span></a></li>
        @endif

        @if(has_access('BlogController::index', Auth::user()->role, false) || has_access('KategoriArtikelController::index', Auth::user()->role, false) || has_access('TagController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.blog.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil"></i><span class="app-menu__label">Artikel</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('BlogController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.index'))) && !is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) && !is_int(strpos(Request::url(), route('admin.blog.tag.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.index') }}"><i class="icon fa fa-circle-o"></i> Data Artikel</a></li>
            @endif
            @if(has_access('KategoriArtikelController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.kategori.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.kategori.index') }}"><i class="icon fa fa-circle-o"></i> Kategori</a></li>
            @endif
            @if(has_access('TagController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.blog.tag.index'))) ? 'active' : '' }}" href="{{ route('admin.blog.tag.index') }}"><i class="icon fa fa-circle-o"></i> Tag</a></li>
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

        @if(has_access('SliderController::index', Auth::user()->role, false) || has_access('DeskripsiController::index', Auth::user()->role, false) || has_access('FiturController::index', Auth::user()->role, false) || has_access('MitraController::index', Auth::user()->role, false) || has_access('MentorController::index', Auth::user()->role, false) || has_access('TestimoniController::index', Auth::user()->role, false))
        <li class="treeview {{ is_int(strpos(Request::url(), route('admin.slider.index'))) || is_int(strpos(Request::url(), route('admin.deskripsi.index'))) || is_int(strpos(Request::url(), route('admin.fitur.index'))) || is_int(strpos(Request::url(), route('admin.mitra.index'))) || is_int(strpos(Request::url(), route('admin.mentor.index'))) || is_int(strpos(Request::url(), route('admin.testimoni.index'))) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-desktop"></i><span class="app-menu__label">Konten Situs</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            @if(has_access('SliderController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.slider.index'))) ? 'active' : '' }}" href="{{ route('admin.slider.index') }}"><i class="icon fa fa-circle-o"></i> Slider</a></li>
            @endif
            @if(has_access('DeskripsiController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.deskripsi.index'))) ? 'active' : '' }}" href="{{ route('admin.deskripsi.index') }}"><i class="icon fa fa-circle-o"></i> Deskripsi</a></li>
            @endif
            @if(has_access('FiturController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.fitur.index'))) ? 'active' : '' }}" href="{{ route('admin.fitur.index') }}"><i class="icon fa fa-circle-o"></i> Fitur</a></li>
            @endif
            @if(has_access('MitraController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.mitra.index'))) ? 'active' : '' }}" href="{{ route('admin.mitra.index') }}"><i class="icon fa fa-circle-o"></i> Mitra</a></li>
            @endif
            @if(has_access('MentorController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.mentor.index'))) ? 'active' : '' }}" href="{{ route('admin.mentor.index') }}"><i class="icon fa fa-circle-o"></i> Mentor</a></li>
            @endif
            @if(has_access('TestimoniController::index', Auth::user()->role, false))
            <li><a class="treeview-item {{ is_int(strpos(Request::url(), route('admin.testimoni.index'))) ? 'active' : '' }}" href="{{ route('admin.testimoni.index') }}"><i class="icon fa fa-circle-o"></i> Testimoni</a></li>
            @endif
          </ul>
        </li>
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