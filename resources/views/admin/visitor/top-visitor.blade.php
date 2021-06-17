@extends('faturcms::template.admin.main')

@section('title', 'Top Visitor')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Top Visitor',
        'items' => [
            ['text' => 'Visitor', 'url' => route('admin.visitor.index')],
            ['text' => 'Top Visitor', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Identitas User</th>
                                    <th width="80">Role</th>
                                    <th width="50">Total</th>
                                    <th width="90">Kunjungan Terakhir</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
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
    generate_datatable("#dataTable", {
        "url": "{{ route('admin.visitor.top.data') }}",
        "columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'user_identity', name: 'user_identity'},
            {data: 'nama_role', name: 'nama_role'},
            {data: 'visits', name: 'visits'},
            {data: 'last_visit', name: 'last_visit'},
            {data: 'options', name: 'options'},
        ],
        "order": [3, 'desc']
    });
</script>

@endsection