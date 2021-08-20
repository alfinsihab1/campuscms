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
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
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
                                    <th width="50">Total</th>
                                    <th width="90">Kunjungan Terakhir</th>
                                    <th width="60">Opsi</th>
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
                                    <td>{{ number_format(count_kunjungan($data->id_user, $tanggal),0,',',',') }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->last_visit }}</span>
                                        {{ date('d/m/Y', strtotime($data->last_visit)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->last_visit)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-info btn-visitor" data-id="{{ $data->id_user }}" data-toggle="tooltip" title="Lihat Informasi"><i class="fa fa-info"></i></a>
                                            <a href="{{ route('admin.log.activity', ['id' => $data->id_user]) }}" class="btn btn-sm btn-warning" data-id="{{ $data->id_visitor }}" data-toggle="tooltip" title="Lihat Aktivitas"><i class="fa fa-eye"></i></a>
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

<!-- Modal Visitor -->
<div class="modal fade" id="modal-visitor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Info Visitor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- /Modal Visitor -->

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

    // Button Visitor
    $(document).on("click", ".btn-visitor", function(e){
        e.preventDefault();
        var user = $(this).data("id");
        $.ajax({
            type: "post",
            url: "{{ route('admin.visitor.info') }}",
            data: {_token: "{{ csrf_token() }}", user: user, date: "{{ $tanggal }}"},
            success: function(response){
                var result = JSON.parse(response);
                var html = '';
                if(result.length > 0){
                    $(result).each(function(key,data){
                        html += '<div class="mb-3">';
                        html += '<p class="h6 mb-2"><i class="fa fa-clock-o mr-1"></i>' + data.time + '</p>';
                        html += data.device != null ? '<p class="mb-2"><strong>Device:</strong><br>' + data.device.type + ' ' + data.device.family + ' ' + data.device.model + ' ' + data.device.grade + '</p>' : '<p class="mb-2"><strong>Device:</strong><br>NULL</p>';
                        html += data.browser != null ? '<p class="mb-2"><strong>Browser:</strong><br>' + data.browser.name + ' ' + ' (' + data.browser.family + '); ' + data.browser.engine + ' Engine</p>' : '<p class="mb-2"><strong>Browser:</strong><br>NULL</p>';
                        html += data.platform != null ? '<p class="mb-2"><strong>Platform:</strong><br>' + data.platform.name + ' ' + ' (' + data.platform.family + ')</p>' : '<p class="mb-2"><strong>Platform:</strong><br>NULL</p>';
                        html += data.location != null ? '<p class="mb-2"><strong>Lokasi:</strong><br>' + data.location.cityName + ', ' + data.location.regionName + ', ' + data.location.countryName + '</p>' : '<p class="mb-2"><strong>Lokasi:</strong><br>NULL</p>';
                        html += '</div>';
                        html += '<hr>';
                    });
                }
                $("#modal-visitor .modal-body").html(html);
                $("#modal-visitor").modal("show");
            }
        });
    });
    
    // Hide Modal Visitor
    $('#modal-visitor').on('hidden.bs.modal', function(){
        $("#modal-visitor .modal-body").html("");
    });
</script>

@endsection