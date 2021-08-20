@extends('faturcms::template.admin.main')

@section('title', 'Peserta Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Peserta Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('member.pelatihan.index')],
            ['text' => 'Peserta Pelatihan', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Identitas Peserta</th>
                                    <th>Pelatihan</th>
                                    <th width="120">Waktu Mendaftar</th>
                                    <th width="100">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelatihan_member as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        {{ $data->nama_user }}
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
                                        <br>
                                        <small><i class="fa fa-tag mr-1"></i>{{ $data->nomor_pelatihan }}</small>
                                    </td>
                                    <td>
                                        <span class="d-none">{{ $data->pm_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->pm_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->pm_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm select-status" data-id="{{ $data->id_pm }}">
                                            <option value="1" {{ $data->status_pelatihan == 1 ? 'selected' : '' }}>Lulus</option>
                                            <option value="11" {{ $data->status_pelatihan == 11 ? 'selected' : '' }}>Lulus (A: Sangat Baik)</option>
                                            <option value="12" {{ $data->status_pelatihan == 12 ? 'selected' : '' }}>Lulus (B: Baik)</option>
                                            <option value="13" {{ $data->status_pelatihan == 13 ? 'selected' : '' }}>Lulus (C: Cukup)</option>
                                            <option value="0" {{ $data->status_pelatihan == '0' ? 'selected' : '' }}>Belum Lulus</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-status" class="d-none">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                            <input type="hidden" name="status">
                        </form>
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

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
    
    // Change Status
    $(document).on("change", ".select-status", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $.ajax({
            type: "post",
            url: "{{ route('member.pelatihan.updatestatus') }}",
            data: {_token: "{{ csrf_token() }}", id: id, status: $(this).val()},
            success: function(response){
                alert(response);
            }
        });
    });
</script>

@endsection