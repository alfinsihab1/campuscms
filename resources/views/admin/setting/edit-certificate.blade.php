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
                        @foreach($setting as $data)
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                {{ $data->setting_name }}
                                <span class="text-danger">{{ is_int(strpos($data->setting_rules, 'required')) ? '*' : '' }}</span>
                                <br>
                                <span class="small text-muted">{{ $data->setting_key }}</span>
                            </label>
                            <div class="col-md-10">
                                <input type="text" name="setting[{{ str_replace($kategori->prefix, '', $data->setting_key) }}]" class="form-control {{ $errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)) ? 'is-invalid' : '' }} {{ is_int(strpos($data->setting_key, 'color')) ? 'colorpicker' : '' }}" value="{{ $data->setting_value }}">
                                @if($errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('setting.'.str_replace($kategori->prefix, '', $data->setting_key))) }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
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

@endsection