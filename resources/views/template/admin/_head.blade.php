<!-- Main CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/css/main.css') }}">
<!-- JQUery UI -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
<!-- Icon -->
<link rel="shortcut icon" href="{{ asset('assets/images/icon/'.setting('site.icon')) }}">
<!-- darkmode -->
<script>
  // if (window.location.protocol === 'http:') {
  //   window.location.protocol = 'https:';
  // }
  // If `prefers-color-scheme` is not supported, fall back to light mode.
  // In this case, light.css will be downloaded with `highest` priority.
  if (!window.matchMedia('(prefers-color-scheme)').matches) {
    document.documentElement.style.display = 'none';
    document.head.insertAdjacentHTML(
        'beforeend',
        '<link rel="stylesheet" href="{{ asset('assets/css/light.css') }}" onload="document.documentElement.style.display = ``">'
    );
  }
</script>