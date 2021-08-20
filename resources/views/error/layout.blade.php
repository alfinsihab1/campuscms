<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
</head>
<body>
<div class="bg-theme-1">
  <div class="d-flex justify-content-end align-items-center text-white h-100">
    <div class="container text-center">
      <div class="d-flex justify-content-center">
        <h1 data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="top-bottom">@yield('code')</h1>
<!--         <h1 data-aos="fade-up" data-aos-duration="1000" data-aos-anchor-placement="top-bottom">4</h1>
        <h1 data-aos="fade-up" data-aos-duration="1500" data-aos-anchor-placement="top-bottom" style="color: rgba(0,0,0,.2);">0</h1>
        <h1 data-aos="fade-up" data-aos-duration="2000" data-aos-anchor-placement="top-bottom">4</h1> -->
      </div>
      <h5 class="text-capitalize mb-4" data-aos="fade-up" data-aos-duration="2500">@yield('message')</h5> 
      <a data-aos="fade-up" data-aos-duration="3000" href="{{ route('site.home') }}" class="btn btn-theme text-uppercase btn-theme-1 me-2">Home</a>
    </div>
    <p class="position-absolute" style="top: 96%; transform: translate(-50%,-50%)!important; left: 50%!important;">Made with <i class="fa fa-heart" style="font-size: .8rem; color: rgba(230, 57, 70, 1)"></i></p>
  </div>
</div>
<style type="text/css">
  nav {display: none!important;}
  footer{display: none;}
  h1{font-size: 12rem}
  h1, h5, p {color: rgba(255,255,255,1);}
  .bg-theme-1{animation: changebg 7s infinite; height: 100vh}
  .btn-theme-1{background-color: rgba(0,0,0,.2); animation: animatebtn 7s infinite!important}
  @keyframes changebg {
    0% {background-color: {{ setting('site.color.primary_dark') }};}
    25%{background-color: {{ setting('site.color.secondary_dark') }};}
    50% {background-color: {{ setting('site.color.primary_dark') }};}
    74% {background-color: {{ setting('site.color.secondary_dark') }};}
    100% {background-color: {{ setting('site.color.primary_dark') }};}
  }
  @keyframes animatebtn {
    0% {width: 150px}
    25% {width: 200px}
    50% {width: 250px}
    75% {width: 200px}
    100% {width: 150px}
  }
</style>
</body>
</html>