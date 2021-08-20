@extends('faturcms::template.admin.main')

@section('title', 'Statistik Lokasi')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Lokasi',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Lokasi', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Kota</h5>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless" id="table-city">
                            <thead>
                                <tr>
                                    <th>Kota</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="colspan" colspan="2"><em>Loading...</em></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Column -->

        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Region</h5>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless" id="table-region">
                            <thead>
                                <tr>
                                    <th>Region</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="colspan" colspan="2"><em>Loading...</em></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Column -->

        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Negara</h5>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless" id="table-country">
                            <thead>
                                <tr>
                                    <th>Negara</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="colspan" colspan="2"><em>Loading...</em></td></tr>
                            </tbody>
                        </table>
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

<script type="text/javascript">
    $(function(){
        // Load city
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.city') }}",
            success: function(response){
                var html = '';
                var data = Object.entries(response.data.data);
                for(i=0; i<data.length; i++){
                    html += '<tr>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + data[i][0] + '</td>' : '<td>' + data[i][0] + '</td>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + thousand_format(data[i][1]) + '</td>' : '<td>' + thousand_format(data[i][1]) + '</td>';
                    html += '</tr>';
                }
                $("#table-city tbody").html(html);
            }
        });

        // Load region
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.region') }}",
            success: function(response){
                var html = '';
                var data = Object.entries(response.data.data);
                for(i=0; i<data.length; i++){
                    html += '<tr>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + data[i][0] + '</td>' : '<td>' + data[i][0] + '</td>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + thousand_format(data[i][1]) + '</td>' : '<td>' + thousand_format(data[i][1]) + '</td>';
                    html += '</tr>';
                }
                $("#table-region tbody").html(html);
            }
        });

        // Load country
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.country') }}",
            success: function(response){
                var html = '';
                var data = Object.entries(response.data.data);
                for(i=0; i<data.length; i++){
                    html += '<tr>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + data[i][0] + '</td>' : '<td>' + data[i][0] + '</td>';
                    html += (data[i][0] == 'Tidak Diketahui') ? '<td class="text-danger">' + thousand_format(data[i][1]) + '</td>' : '<td>' + thousand_format(data[i][1]) + '</td>';
                    html += '</tr>';
                }
                $("#table-country tbody").html(html);
            }
        });
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .table tr th, .table tr td {padding: .25rem;}
    .table tr th:last-child, .table tr td:last-child {text-align: right;}
    .table tr td.colspan {text-align: center!important;}
</style>

@endsection