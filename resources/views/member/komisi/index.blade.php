@extends('faturcms::template.admin.main')

@section('title', 'Komisi')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Komisi',
        'items' => [
            ['text' => 'Transaksi', 'url' => '#'],
            ['text' => 'Komisi', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                    <h5>Ambil Komisi</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Saldo -->
                    <div class="alert alert-success text-center">
                        Saldo:
                        <br>
                        <p class="h5 mb-0">Rp {{ number_format(Auth::user()->saldo,0,'.','.') }}</p>
                    </div>
                    <!-- /Saldo -->
                    <form id="form" class="mt-3" method="post" action="{{ route('member.komisi.withdraw') }}">
                        {{ csrf_field() }}
                        @if($current_withdrawal)
                        <div class="alert alert-warning mb-4" role="alert">
                            Komisi sedang diproses untuk dikirimkan ke rekening Anda. Kode transaksinya adalah <strong>{{ $current_withdrawal->inv_withdrawal }}</strong>.
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nominal <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text {{ $errors->has('withdrawal_hidden') ? 'border-danger' : '' }}">Rp.</span>
                                    </div>
                                    <input type="text" name="withdrawal" class="form-control number-only thousand-format {{ $errors->has('withdrawal_hidden') ? 'border-danger' : '' }}" value="{{ old('withdrawal') }}" placeholder="Masukkan nominal withdrawal yang akan diambil" {{ Auth::user()->saldo < setting('site.min_withdrawal') || $current_withdrawal ? 'disabled' : '' }}>
                                    <input type="hidden" name="withdrawal_hidden" value="{{ old('withdrawal_hidden') }}">
                                </div>
                                @if($errors->has('withdrawal_hidden'))
                                <div class="small text-danger">Nominal withdrawal yang dapat diambil yaitu antara Rp. {{ number_format(setting('site.min_withdrawal'),0,',','.') }} dan Rp. {{ number_format(Auth::user()->saldo,0,',','.') }}.</div>
                                @else
                                <div class="small text-muted">Minimum nominal withdrawal yang dapat diambil adalah Rp. {{ number_format(setting('site.min_withdrawal'),0,'.','.') }}.</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Rekening <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select class="form-control {{ $errors->has('rekening') ? 'border-danger' : '' }}" name="rekening" {{ Auth::user()->saldo < setting('site.min_withdrawal') || $current_withdrawal ? 'disabled' : '' }}>
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($rekening as $data)
                                    <option value="{{ $data->id_rekening }}" {{ $data->id_rekening == old('rekening') ? 'selected' : '' }}>{{ $data->nama_platform }} | {{ $data->nomor }} | {{ $data->atas_nama }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('rekening'))
                                <div class="small text-danger">{{ ucfirst($errors->first('rekening')) }}</div>
                                @else
                                <div class="small text-muted">Komisi akan ditransfer ke rekening ini.</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                    <h5>Arsip Komisi</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="40">No.</th>
                                    <th width="100">Waktu</th>
                                    <th>Nama</th>
                                    <th width="100">Masuk Saldo?</th>
                                    <th width="100">Komisi (Rp.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($komisi)>0)
                                    @php $i = 1; @endphp
                                    @foreach($komisi as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <span class="d-none">{{ $data->komisi_at }}</span>
                                            {{ date('d/m/Y', strtotime($data->komisi_at)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->komisi_at)) }} WIB</small>
                                        </td>
                                        <td>{{ $data->nama_user }}</td>
                                        <td><strong class="{{ $data->masuk_ke_saldo == 1 ? 'text-success' : 'text-danger' }}">{{ $data->masuk_ke_saldo == 1 ? 'Sudah' : 'Belum' }}</strong></td>
                                        <td>{{ number_format($data->komisi_hasil,0,',',',') }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" align="center">Tidak ada data.</td>
                                    </tr>
                                @endif
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

<script type="text/javascript">
    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        e.preventDefault();
        var withdrawal = $("input[name=withdrawal]").val();
        withdrawal = withdrawal.replace(/\./g, '');
        $("input[name=withdrawal_hidden]").val(withdrawal);
        $("#form").submit();
    })
</script>

@endsection