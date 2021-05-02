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
                                @if($data->setting_key == 'site.google_maps' || $data->setting_key == 'site.google_analytics')
                                    <textarea name="setting[{{ str_replace($kategori->prefix, '', $data->setting_key) }}]" class="form-control {{ $errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)) ? 'is-invalid' : '' }}" rows="8">{!! html_entity_decode($data->setting_value) !!}</textarea>
                                @else
                                    <input type="text" name="setting[{{ str_replace($kategori->prefix, '', $data->setting_key) }}]" class="form-control {{ $errors->has('setting.'.str_replace($kategori->prefix, '', $data->setting_key)) ? 'is-invalid' : '' }}" value="{{ $data->setting_value }}">
                                @endif
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