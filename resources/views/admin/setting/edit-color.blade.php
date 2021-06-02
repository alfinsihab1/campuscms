@extends('faturcms::template.admin.main')

@section('title', 'Pengaturan '.$kategori->kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pengaturan '.$kategori->kategori,
        'items' => [
            ['text' => 'Pengaturan', 'url' => route('admin.setting.index')],
            ['text' => $kategori->kategori, 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="heading">
                <h5>Warna</h5>
            </div>
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
                    </div>
                    @endif
                    <form id="form" method="post" action="{{ route('admin.setting.update', ['category' => $kategori->slug]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            @foreach($setting as $data)
                            <div class="col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        {{ $data->setting_name }}
                                        <span class="text-danger">{{ is_int(strpos($data->setting_rules, 'required')) ? '*' : '' }}</span>
                                        <br>
                                        <span class="small text-muted">{{ $data->setting_key }}</span>
                                    </label>
                                    <div class="">
                                        <input type="text" name="setting[{{ str_replace($kategori->prefix, '', $data->setting_key) }}]" class="form-control {{ $errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)) ? 'is-invalid' : '' }} colorpicker" value="{{ $data->setting_value }}">
                                        @if($errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)))
                                        <div class="small text-danger mt-1">{{ ucfirst($errors->first('setting.'.str_replace($kategori->prefix, '', $data->setting_key))) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"></label>
                            <div class="">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
            <div class="dark-mode">
                <div class="heading">
                    <h5>Tema</h5>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card img-radio <?php echo $theme=="light" ? 'active' : ''; ?>" id="light">
                            <div class="card-body p-0">
                                <img src="https://github.githubassets.com/images/modules/settings/color_modes/light_preview.svg" style="border-radius: .25rem .25rem 0 0; width: 100%" >
                            </div>
                            <div class="card-footer">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" id="light" name="theme" value="light" <?php echo $theme=="light" ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="light">
                                    Default Light
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card img-radio <?php echo $theme=="dark" ? 'active' : ''; ?>" id="dark">
                            <div class="card-body p-0">
                                <img src="https://github.githubassets.com/images/modules/settings/color_modes/dark_preview.svg" style="border-radius: .25rem .25rem 0 0; width: 100%" id="dark" class="img-radio">
                            </div>
                            <div class="card-footer">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" id="dark" name="theme" value="dark" <?php echo $theme=="dark" ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="dark">
                                    Default Dark
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card img-radio <?php echo $theme=="dimmed" ? 'active' : ''; ?>" id="dimmed">
                            <div class="card-body p-0">
                                <img src="https://github.githubassets.com/images/modules/settings/color_modes/dark_dimmed_preview.svg" style="border-radius: .25rem .25rem 0 0; width: 100%" id="dimmed" class="img-radio">
                            </div>
                            <div class="card-footer">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" id="dimmed" name="theme" value="dimmed" <?php echo $theme=="dimmed" ? 'checked' : ''; ?>>
                                  <label class="form-check-label" for="dimmed">
                                    Dark Dimmed
                                  </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('assets/plugins/colorpicker/jquery-ascolor.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/colorpicker/jquery-asgradient.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/colorpicker/jquery-ascolorpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/colorpicker/jquery-minicolors.min.js') }}"></script>
<script type="text/javascript">
    
    // Colorpicker
    $(".colorpicker").each(function(){
        $(this).minicolors({
            control: $(this).attr('data-control') || 'hue',
            position: $(this).attr('data-position') || 'bottom left',
            change: function(value, opacity) {
                if (!value) return;
                var color = value;
                if (opacity) value += ', ' + opacity;
                if (typeof console === 'object') {
                    var id = $(this).attr("id");
                }
            },
            theme: 'bootstrap'
        });
    });
</script>
@endsection

@section('css-extra')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/colorpicker/jquery-minicolors.min.css') }}">
<style type="text/css">
    .card.img-radio, .form-check-label{cursor: pointer;}
    .card.img-radio{border: 2px solid transparent;}
    .card.img-radio.active{border: 2px solid blue;}
</style>
@endsection