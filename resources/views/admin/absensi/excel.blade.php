<table border="0">
	<tr>
		<td colspan="6" style="text-align: center; font-size: 16px;"><strong>REKAPITULASI ABSENSI PELATIHAN ONLINE CAMPUS DIGITAL</strong></td>
	</tr>
	<tr>
		<td colspan="6" style="text-align: center; font-size: 14px;"><strong>{{ generate_date(generate_date_format($_GET['tanggal'], 'y-m-d')) }}</strong></td>
	</tr>
</table>

<table border="1">
	<tr>
		<td align="center" width="5" style="background-color: {{ setting('site.primary_color') }};"><strong>No.</strong></td>
		<td align="center" width="40" style="background-color: {{ setting('site.primary_color') }};"><strong>Nama User</strong></td>
		<td align="center" width="40" style="background-color: {{ setting('site.primary_color') }};"><strong>Instansi</strong></td>
		<td align="center" width="30" style="background-color: {{ setting('site.primary_color') }};"><strong>Jurusan</strong></td>
		<td align="center" width="30" style="background-color: {{ setting('site.primary_color') }};"><strong>Kelas</strong></td>
		<td align="center" width="30" style="background-color: {{ setting('site.primary_color') }};"><strong>Waktu Absensi</strong></td>
	</tr>
	@foreach($absensi as $key=>$data)
	<tr>
		<td>{{ ($key+1) }}</td>
        <td>{{ $data->nama_user }}</td>
        <td>{{ $data->instansi }}</td>
        <td align="center">{{ $data->jurusan }}</td>
        <td align="center">{{ $data->kelas }}</td>
        <td align="center">{{ date('d/m/Y H:i:s', strtotime($data->absensi_at)) }}</td>
	</tr>
	@endforeach
</table>