@extends('faturcms::template.admin.main')

@section('title', 'Data Package')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Package',
        'items' => [
            ['text' => 'Sistem', 'url' => '#'],
            ['text' => 'Data Package', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Package</th>
                                    <th width="30">Versi</th>
                                    <th width="50">Tipe</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($package as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.package.detail', ['package' => $data['name']]) }}">{{ $data['name'] }}</a>
                                        <br>
                                        <small class="text-muted">{{ array_key_exists('description', $data) ? $data['description'] : '' }}</small>
                                    </td>
                                    <td>{{ $data['version'] }}</td>
                                    <td>{{ ucfirst($data['type']) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.package.detail', ['package' => $data['name']]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                                            <a href="https://github.com/{{ $data['name'] }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Lihat Source" target="_blank"><i class="fa fa-link"></i></a>
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

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection