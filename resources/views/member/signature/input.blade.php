@extends('faturcms::template.admin.main')

@section('title', 'Input Tandatangan Digital')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Input Tandatangan Digital',
        'items' => [
            ['text' => 'Tandatangan Digital', 'url' => '#'],
            ['text' => 'Input Tandatangan Digital', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Tulis tanda tangan Anda di bawah ini:</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="sig-canvas" width="500" height="250" style="width: 100%">
                                        Browser Anda tidak support, bro.
                                    </canvas>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-success" id="sig-submitBtn"><i class="fa fa-save mr-2"></i>Simpan</button>
                                    <button class="btn btn-sm btn-danger" id="sig-clearBtn"><i class="fa fa-times mr-2"></i>Bersihkan</button>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="form" method="post" action="{{ route('member.signature.update') }}" class="d-none">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="signature" id="sig-dataUrl">
                                        <img id="sig-image" class="d-none" src="" alt="Tandatangan Anda akan tampil disini!"/>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <form id="form-2" method="post" action="{{ route('member.signature.update') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="upload" value="1">
                                        <div class="form-group">
                                            <label>Atau upload tanda tangan Anda disini (Format PNG):</label>
                                            <br>
                                            <input type="file" name="foto" id="file" class="d-none" accept="image/png">
                                            <button class="btn btn-sm btn-secondary btn-browse-file"><i class="fa fa-folder-open mr-2"></i>Upload</button>
                                            <br>
                                            <img class="img-thumbnail mt-3 d-none" id="img-upload" style="max-height: 200px;">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-success" type="submit" disabled><i class="fa fa-save mr-2"></i>Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Tanda tangan Anda:</p>
                                    <img src="{{ $signature != null ? asset('assets/images/signature/'.$signature->signature) : '' }}" class="img-thumbnail {{ $signature != null ? '' : 'd-none' }}" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection

@section('js-extra')

<script type="text/javascript">

// Change file
$(document).on("change", "#file", function(){
    change_file(this, "signature", 2);
});

(function() {
  window.requestAnimFrame = (function(callback) {
    return window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      window.msRequestAnimaitonFrame ||
      function(callback) {
        window.setTimeout(callback, 1000 / 60);
      };
  })();

  var canvas = document.getElementById("sig-canvas");
  var ctx = canvas.getContext("2d");
  ctx.strokeStyle = "#222222";
  ctx.lineWidth = 5;

  var drawing = false;
  var mousePos = {
    x: 0,
    y: 0
  };
  var lastPos = mousePos;

  canvas.addEventListener("mousedown", function(e) {
    drawing = true;
    lastPos = getMousePos(canvas, e);
  }, false);

  canvas.addEventListener("mouseup", function(e) {
    drawing = false;
  }, false);

  canvas.addEventListener("mousemove", function(e) {
    mousePos = getMousePos(canvas, e);
  }, false);

  // Add touch event support for mobile
  canvas.addEventListener("touchstart", function(e) {

  }, false);

  canvas.addEventListener("touchmove", function(e) {
    var touch = e.touches[0];
    var me = new MouseEvent("mousemove", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchstart", function(e) {
    mousePos = getTouchPos(canvas, e);
    var touch = e.touches[0];
    var me = new MouseEvent("mousedown", {
      clientX: touch.clientX,
      clientY: touch.clientY
    });
    canvas.dispatchEvent(me);
  }, false);

  canvas.addEventListener("touchend", function(e) {
    var me = new MouseEvent("mouseup", {});
    canvas.dispatchEvent(me);
  }, false);

  function getMousePos(canvasDom, mouseEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: mouseEvent.clientX - rect.left,
      y: mouseEvent.clientY - rect.top
    }
  }

  function getTouchPos(canvasDom, touchEvent) {
    var rect = canvasDom.getBoundingClientRect();
    return {
      x: touchEvent.touches[0].clientX - rect.left,
      y: touchEvent.touches[0].clientY - rect.top
    }
  }

  function renderCanvas() {
    if (drawing) {
      ctx.moveTo(lastPos.x, lastPos.y);
      ctx.lineTo(mousePos.x, mousePos.y);
      ctx.stroke();
      lastPos = mousePos;
    }
  }

  // Prevent scrolling when touching the canvas
  document.body.addEventListener("touchstart", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchend", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);
  document.body.addEventListener("touchmove", function(e) {
    if (e.target == canvas) {
      e.preventDefault();
    }
  }, false);

  (function drawLoop() {
    requestAnimFrame(drawLoop);
    renderCanvas();
  })();

  function clearCanvas() {
    canvas.width = canvas.width;
  }

  // Set up the UI
  var sigText = document.getElementById("sig-dataUrl");
  var sigImage = document.getElementById("sig-image");
  var clearBtn = document.getElementById("sig-clearBtn");
  var submitBtn = document.getElementById("sig-submitBtn");
  clearBtn.addEventListener("click", function(e) {
    clearCanvas();
    sigText.value = "";
  }, false);
  submitBtn.addEventListener("click", function(e) {
    var dataUrl = canvas.toDataURL();
    sigText.value = dataUrl;
    document.getElementById("form").submit();
  }, false);
})();
</script>

@endsection

@section('css-extra')

<style type="text/css">
    #sig-canvas {border: 2px dotted #CCCCCC; border-radius: 15px; cursor: crosshair;}
</style>

@endsection