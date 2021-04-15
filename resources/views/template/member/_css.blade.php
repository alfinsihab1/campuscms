<style type="text/css">
    /* Breadcrumb */
    .app-title {padding: 20px;}

    /* Sidebar */
    .app-menu__item {padding: 8px 15px;}
    .treeview.is-expanded .treeview-menu {margin-bottom: .5rem;}

    /* Navbar */
    .app-nav .app-nav__item .badge {position: absolute; right: 0; bottom: 8px; font-size: 75%;}

    /* Button */
    .btn-theme-1 {background-color: {{ setting('site.primary_color') }}!important; border-color: background: {{ setting('site.primary_color') }}!important; color: #fff;}
    .btn-theme-1:hover {background-color: #e0852f!important; border-color: #e0852f!important; color: #fff;}

    /* Badge */
    .badge {font-size: 87.5%;}

    /* Table */
    #dataTable td {padding: .5rem;}
    #dataTable thead tr th {text-align: center; vertical-align: middle;}
    #dataTable tbody tr td:first-child, #dataTable tbody tr td:last-child {text-align: center;}
    #dataTable td .btn-group a.btn:first-child {border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;}
    #dataTable td .btn-group a.btn:last-child {border-top-right-radius: .25rem; border-bottom-right-radius: .25rem;}
    #dataTable td a.btn {width: 36px;}
    div.dataTables_wrapper div.dataTables_processing {background-color: #eeeeee;}

    /* List Group */
    .list-group-item.active {background-color: {{ setting('site.primary_color') }}; border-color: {{ setting('site.primary_color') }};}

    /* Image Overlay */
    .image-overlay {cursor: pointer; position: absolute; top: 0; bottom: 0; left: 0; right: 0; height: 100%; width: 100%; opacity: 0; transition: .5s ease; background-color: rgba(0,0,0,.6); border-radius: 50%;}
    .image-overlay span {color: white; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center; font-weight: bold;}
    .image-overlay:hover {opacity: 1;}

    /* Modal Image */
    #modal-image .modal-body {height: 80vh; overflow-y: auto;}
    .dropzone-wrapper {height: 150px; border: 2px dashed {{ setting('site.primary_color') }};}
    .dropzone-wrapper:hover {background-color: {{ setting('site.primary_color') }}66; transition: .3s ease-in;}
    .dropzone-desc {text-align: center; font-weight: bold;}
    .dropzone, .dropzone:focus {position: absolute; width: 100%; height: 150px; outline: none!important; cursor: pointer; opacity: 0;}
    .btn-choose-image {cursor: pointer; opacity: .7;}
    .btn-choose-image:hover {opacity: 1; transition: .3s ease-in;}

    /* Modal Croppie */
    #modal-croppie .modal-dialog {max-width: 100%; margin-left: 1rem; margin-right: 1rem;}
    #modal-croppie .modal-body .table-responsive {max-height: calc(100vh - 250px); overflow-y: auto;}

    /* Quill Editor */
    #editor {height: 300px;}
    .ql-button-html:after {content: "<>";}
    .ql-editor {white-space: normal!important;}
    .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6, .ql-editor p {margin-bottom: 1rem!important;}

    /* Bootstrap Tagsinput */
    .bootstrap-tagsinput {width: 100%!important;}
    .bootstrap-tagsinput .tag {padding: 1px 2px; border-radius: 4px; background-color: {{ setting('site.primary_color') }}!important;}
    .tt-menu {background-color: #fff!important; width: 100%; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15)!important}
    .tt-suggestion {padding: .5rem; cursor: pointer;}
    .tt-suggestion:hover {background-color: #e5e5e5;}

    /* Sortable */
    .sortable .sortable-item {cursor: move!important;}
    .sortable .sortable-item.card {border: 1px solid #bebebe!important;}

    /* Change Primary */
    ::selection {background-color: {{ setting('site.primary_color') }}!important;}
    ::-moz-selection {background-color: {{ setting('site.primary_color') }}!important;}
    a {color: {{ setting('site.primary_color') }};}
    .page-link {color: {{ setting('site.primary_color') }};}
    .page-link:hover {color: {{ setting('site.secondary_color') }};}
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {background-color: {{ setting('site.primary_color') }}!important;}
    .material-half-bg .cover {background-color: {{ setting('site.primary_color') }}!important;}
    .app-sidebar__toggle:focus, .app-sidebar__toggle:hover {background-color: {{ setting('site.secondary_color') }}!important;}
    .text-primary {color: {{ setting('site.primary_color') }}!important;}
    .btn-primary {background-color: {{ setting('site.primary_color') }}!important; border-color: {{ setting('site.primary_color') }}!important;}
    .btn-primary:hover {background-color: {{ setting('site.secondary_color') }}!important; border-color: {{ setting('site.secondary_color') }}!important;}
    .page-item.active .page-link {background-color: {{ setting('site.primary_color') }}!important; border-color: {{ setting('site.primary_color') }}!important;}
    .form-control:focus {border-color: {{ setting('site.primary_color') }}!important;}
    .animated-checkbox input[type="checkbox"]:checked + .label-text:before {color: {{ setting('site.primary_color') }}!important;}
    .widget-small.primary.coloured-icon .icon {background-color: {{ setting('site.primary_color') }}!important;}
    .dropdown-item.active, .dropdown-item:active {background-color: {{ setting('site.primary_color') }}!important;}
    .progress-bar {background-color: {{ setting('site.primary_color') }}!important;}
    .btn-outline-primary {color: {{ setting('site.primary_color') }}; background-color: transparent; background-image: none; border-color: {{ setting('site.primary_color') }};}
    .btn-outline-primary:hover {color: #FFF; background-color: {{ setting('site.primary_color') }}; border-color: {{ setting('site.primary_color') }};}
    .btn-outline-primary:not(:disabled):not(.disabled):active, .btn-outline-primary:not(:disabled):not(.disabled).active, .show > .btn-outline-primary.dropdown-toggle {color: #FFF; background-color: {{ setting('site.primary_color') }}; border-color: {{ setting('site.primary_color') }};}

    .login-content .login-box {min-height: 430px;}
    .treeview.is-expanded [data-toggle='treeview'] {border-left-color: #fdd100!important;}
    .treeview-item .icon {margin-right: 10px;}
    .btn .icon, .btn .fa {margin-right: 0; width: 14px;}
    .app-header {background-color: #555!important;}
    .app-menu {border-top: 1px solid #bbb;}
    .app-menu__submenu {margin-top: 2rem; padding: 8px 15px;}
    .app-menu__submenu .app-menu__label {color: #fff; font-size: 1rem; font-weight: bold; text-transform: uppercase;}
    .tab-content {border-top: 1px solid {{ setting('site.primary_color') }};}
    .separator {width: 100%; margin: 1rem; border-top: 1px solid #ddd;}
    .hidden-date {display: none;}
    .cr-boundary {border: 3px dashed #bebebe;}

    /*baonk here*/
    :root{ 
        --primary: #58A7DA; 
        --primary-dark: #799DB4; 
        --border-light: rgba(2555,255,255,.5); 
        --shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        --transition: .25s ease;
        --font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji"!important;
    }
    body{color: var(--dark)!important}
    .rounded-1{border-radius: .5em!important}
    .rounded-2{border-radius: 1em!important}
    .rounded-3{border-radius: 1.5em!important}
    .rounded-4{border-radius: 2em!important}
    .rounded-5{border-radius: 2.5em!important}
    .shadow-sm{box-shadow: var(--shadow)}
    .text-decoration-none{text-decoration: none!important}
    .widget-small .icon{border-radius: .25em}
    .tile, .dropdown-menu, .widget-small{border-radius: .5em}
    .tile, .app-title, .widget-small, .dropdown-menu, .tile-topik {box-shadow: var(--shadow)!important}
    .card, .tile-topik{border: unset!important; border-radius: .5em!important}
    .app-title{margin-top: 0em; margin-right: 0em; margin-left: 0em; border-radius: .5em}
    .app-header{background-color: var(--white)!important; box-shadow: var(--shadow)}
    .app-content{background-color: var(--light)!important}
    .app-menu {border-top: 1px solid transparent; margin: 0 .75em}
    .app-nav__item{color: var(--dark)!important}
    .app-sidebar{box-shadow: unset!important; background-color: #fff}
    .app-sidebar__toggle, .app-nav__item{color: var(--gray)!important; transition: var(--transition)!important}
    .app-sidebar__toggle:focus, .app-sidebar__toggle:hover, .app-nav__item:hover, .app-nav__item:focus {background-color: transparent!important; color: var(--primary-dark)!important}
    .app-menu__item{color: var(--gray); border-radius: .5em; margin-bottom: .5em}
    .app-menu__item.active, .app-menu__item:hover, .app-menu__item:focus, .treeview.is-expanded [data-toggle='treeview'] {background: var(--primary); border-left-color: transparent!important; color: var(--white); border-radius: .5em; box-shadow: var(--shadow)}
    .app-sidebar__user{color: var(--gray)}
    .treeview-menu{background: var(--light); border-radius: .5em}
    .treeview-item{color: var(--gray)}
    .treeview-item.active, .treeview-item:hover, .treeview-item:focus{background: rgba(0,0,0,.2);}
    .app-sidebar__user-avatar{transition: var(--transition)}

    @media (min-width: 768px){
    .sidebar-mini.sidenav-closed .treeview:hover .app-menu__item {background: var(--primary); border-left-color: transparent!important; color: var(--white)}
    .sidebar-mini.sidenav-closed .app-menu__item:hover{border-radius: .5em 0 0 .5em}
    .sidebar-mini.sidenav-closed .treeview-item:hover .app-menu__item{border-radius: .5em 0 0 .5em!important}
    .sidebar-mini.sidenav-closed .app-menu__label{background-color: var(--primary); color: var(--white);border-radius: 0 .5em .5em 0!important}
    .sidebar-mini.sidenav-closed .app-sidebar{width: 72px}
    .sidebar-mini.sidenav-closed .app-content{margin-left: 72px}
    .sidebar-mini.sidenav-closed .app-sidebar__user-avatar{width: 52px; height: 52px}
    .sidebar-mini.sidenav-closed .treeview-menu{margin: -7px 0.75em 0.75em; background: var(--white); box-shadow: var(--shadow); border-radius: .5em}
    .sidebar-mini.sidenav-closed .treeview-menu .treeview-item{color: var(--gray)}
    }

    @media(max-width: 767px){
        .app-header__logo {display: none;}
    }

    @media(min-width: 768px){
        .app-header__logo {background-color: var(--white)!important; font-family: 'Lato'; text-transform: uppercase;}
    }
    @media (max-width: 767px){
        .app-header__logo {display: block}
        .app-header__logo img {vertical-align: sub;}
    }
</style>