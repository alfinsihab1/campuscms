@extends('faturcms::email.main')

@section('content')

    <strong>Yth {{ $user->nama_user }},</strong>
    <br>
    Anda telah berhasil melakukan pendaftaran. Segera aktivasi akun Anda supaya dapat menggunakan fasilitas dari {{ setting('site.name') }}, dengan cara melakukan pembayaran sejumlah <strong>Rp {{ number_format($komisi->komisi_aktivasi,0,'.','.') }}</strong> ke rekening berikut:
    <br>
    <ol>
        @foreach($default_rekening as $data)
        <li>
            <strong>{{ $data->nama_platform }}</strong> dengan nomor rekening <strong>{{ $data->nomor }}</strong> a/n <strong>{{ $data->atas_nama }}</strong>.
            @if($data->tipe_platform == 1)
            Kode transfer bank adalah <strong>{{ $data->kode_platform }}</strong>.
            @endif
        </li>
        @endforeach
    </ol>
    <br>
    Kode Invoice Anda adalah: <strong>{{ $komisi->inv_komisi }}</strong>
@endsection