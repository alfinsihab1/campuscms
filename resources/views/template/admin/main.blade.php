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
        @include('faturcms::template.admin._header')
        @include('faturcms::template.admin._sidebar')
        @yield('content')
        @include('faturcms::template.admin._js')
        @yield('js-extra')
    </body>
</html>