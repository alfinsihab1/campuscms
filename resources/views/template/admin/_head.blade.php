
    <meta name="description" content="{{ setting('site.name') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ setting('site.name') }}">
    <meta property="og:title" content="{{ setting('site.name') }}">
    <meta property="og:url" content="{{ URL::to('/') }}">
    <meta property="og:image" content="{{ asset('assets/images/logo/'.setting('site.icon')) }}">
    <meta property="og:description" content="{{ setting('site.name') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/'.setting('site.icon')) }}">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Magnify Popup -->
    <link href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
    <!-- Croppie -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
    <!-- Quill JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">