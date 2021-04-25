<!DOCTYPE html>
<html lang="en">
    <head>
        @include('faturcms::template.admin._meta')
        @include('faturcms::template.admin._head')
        @include('faturcms::template.admin._css')
        @yield('css-extra')
        <title>@yield('title') | {{ setting('site.name') }}</title>
    </head>
    <body class="app sidebar-mini">
        @if(Auth::user()->is_admin == 1)
            @include('faturcms::template.admin._header-admin')
            @include('faturcms::template.admin._sidebar-admin')
        @elseif(Auth::user()->is_admin == 0)
            @include('faturcms::template.admin._header-member')
            @include('faturcms::template.admin._sidebar-member')
        @endif
        @yield('content')
        @include('faturcms::template.admin._js')
        @yield('js-extra')
    </body>
</html>