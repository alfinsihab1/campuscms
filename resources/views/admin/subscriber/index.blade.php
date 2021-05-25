@extends('faturcms::template.admin.main')

@section('title', 'Data Subscriber')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Subscriber',
        'items' => [
            ['text' => 'Subscriber', 'url' => '#'],
            ['text' => 'Data Subscriber', 'url' => '#'],
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
                    <div class="btn-group">
                        <a href="{{ route('admin.subscriber.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Subscriber</th>
                                    <th width="100">Email</th>
                                    <th width="30">Versi</th>
                                    <th width="100">Update Terakhir</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subscriber as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ $data->subscriber_url }}" target="_blank">{{ $data->subscriber_url }}</a>
                                        <br>
                                        <small class="text-muted"><strong>API Key:</strong> {{ $data->subscriber_key }}</small>
                                    </td>
                                    <td>{{ $data->subscriber_email }}</td>
                                    <td>{{ $data->subscriber_version }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->subscriber_up }}</span>
                                        {{ date('d/m/Y', strtotime($data->subscriber_up)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->subscriber_up)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-success btn-update" data-id="{{ $data->id_subscriber }}" data-url="{{ $data->subscriber_url }}" data-toggle="tooltip" title="Update"><i class="fa fa-level-up"></i></a>
                                            <a href="{{ route('admin.subscriber.edit', ['id' => $data->id_subscriber]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_subscriber }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.subscriber.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
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

<!-- Modal Update Me -->
<div class="modal fade" id="modal-update-me" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Output</h5>
            </div>
            <div class="modal-body">
                <h5 class="mb-3"></h5>
                <div class="output w-100 mb-3"></div>
			</div>
            <div class="modal-footer justify-content-center">
                <a class="btn btn-primary btn-refresh" href="{{ route('admin.subscriber.index') }}"><i class="fa fa-refresh mr-1"></i>Refresh</a>
                <a class="btn btn-primary btn-update" href="#"><i class="fa fa-level-up mr-1"></i>Update Ulang</a>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Update Me -->


@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    // Button Update Me
    $(document).on("click", ".btn-update", function(e){
        e.preventDefault();
        var url = $(this).data("url");
		$("#modal-update-me .btn-update").attr("data-url",url);
        $.ajax({
            type: "get",
            url: "{{ route('admin.package.update') }}",
            data: {url: url},
            error: function(response){
                var responseText = JSON.parse(response.responseText);
                var html = '';
                html += '<div class="alert alert-danger">' + responseText.message + '</div>';
                html += '<p class="mb-1">File:<br>' + responseText.file + ' on line ' + responseText.line + '</p>';
                html += '<p class="mb-1">Exception:<br>' + responseText.exception + '</p>';
                html += '<ul>';
                $(responseText.trace).each(function(key, array){
                    html += '<li>' + array.class + '::' + array.function + ' (line ' + array.line + ')</li>';
                });
                html += '</ul>';
                $("#modal-update-me .modal-body h5").html('<i class="fa fa-exclamation-circle mr-2"></i>' + response.status + ": " + response.statusText);
                $("#modal-update-me .output").html(html);
				$("#modal-update-me .btn-refresh").addClass("d-none");
				$("#modal-update-me .btn-update").removeClass("d-none");
                $("#modal-update-me").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            success: function(response){
				var responseString = response.toString();
				// Jika sukses
				if(responseString.search('API KEY tidak valid') == -1) $("#modal-update-me .modal-body h5").html('<i class="fa fa-check-circle mr-2"></i>200: Sukses!');
                $("#modal-update-me .output").html(responseString);
				$("#modal-update-me .btn-refresh").removeClass("d-none");
				$("#modal-update-me .btn-update").addClass("d-none");
                $("#modal-update-me").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    });
</script>

@endsection