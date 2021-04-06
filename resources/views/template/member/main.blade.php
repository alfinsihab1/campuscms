<!DOCTYPE html>
<html lang="en">
    <head>
        @include('faturcms::template.member._head')
        @include('faturcms::template.member._css')
        @yield('css-extra')
        <title>@yield('title') | {{ setting('site.name') }}</title>
    </head>
    <body class="app sidebar-mini">
        @include('faturcms::template.member._header')
        @include('faturcms::template.member._sidebar')
        @yield('content')
        @include('faturcms::template.member._js')
        @yield('js-extra')
    </body>
</html>