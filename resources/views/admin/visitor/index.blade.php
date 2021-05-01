@extends('faturcms::template.admin.main')

@section('title', 'Data Visitor')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Visitor',
        'items' => [
            ['text' => 'Visitor', 'url' => route('admin.visitor.index')],
            ['text' => 'Data Visitor', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <div></div>
                    <div>
                        <form method="get" action="{{ route('admin.visitor.index') }}">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <a href="#" class="btn btn-sm btn-secondary btn-date" data-toggle="tooltip" title="Pilih Tanggal"><i class="fa fa-calendar"></i></a>
                              </div>
                              <input type="text" name="tanggal" class="form-control form-control-sm" value="{{ $tanggal }}" readonly>
                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Filter"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Identitas User</th>
                                    <th width="80">Role</th>
                                    <th width="100">IP Address</th>
                                    <th width="90">Kunjungan Terakhir</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visitor as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>{{ role($data->role) }}</td>
                                    <td>{{ $data->ip_address }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->visit_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->visit_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->visit_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.log.activity', ['id' => $data->id_user]) }}" class="btn btn-sm btn-info" data-id="{{ $data->id_visitor }}" data-toggle="tooltip" title="Lihat Aktivitas"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

@include('faturcms::template.admin._js-table')

<script src="{{ asset('templates/vali-admin/js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Datepicker
        $("input[name=tanggal]").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });

    // DataTable
    generate_datatable("#dataTable");
    
    // Button Date
    $(document).on("click", ".btn-date", function(e){
        e.preventDefault();
        $("input[name=tanggal]").focus();
    });
</script>

@endsection