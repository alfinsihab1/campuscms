@extends('faturcms::template.admin.main')

@section('title', 'Edit Subscriber')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Subscriber',
        'items' => [
            ['text' => 'Subscriber', 'url' => '#'],
            ['text' => 'Edit Subscriber', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.subscriber.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $subscriber->id_subscriber }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">API Key</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" value="{{ $subscriber->subscriber_key }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="email" name="subscriber_email" class="form-control {{ $errors->has('subscriber_email') ? 'is-invalid' : '' }}" value="{{ $subscriber->subscriber_email }}">
                                @if($errors->has('subscriber_email'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('subscriber_email')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">URL <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="subscriber_url" class="form-control {{ $errors->has('subscriber_url') ? 'is-invalid' : '' }}" value="{{ $subscriber->subscriber_url }}">
                                <div class="small text-muted mt-1">Contoh: https://example.com</div> 
                                @if($errors->has('subscriber_url'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('subscriber_url')) }}</div>
                                @endif
                            </div>
                        </div>
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