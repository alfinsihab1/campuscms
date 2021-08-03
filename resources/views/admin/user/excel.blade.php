<table border="1">
	<tr>
		<td align="center" width="5" style="background-color: {{ setting('site.primary_color') }};"><strong>No.</strong></td>
		<td align="center" width="40" style="background-color: {{ setting('site.primary_color') }};"><strong>Nama User</strong></td>
		<td align="center" width="40" style="background-color: {{ setting('site.primary_color') }};"><strong>Email</strong></td>
		<td align="center" width="20" style="background-color: {{ setting('site.primary_color') }};"><strong>Nomor HP</strong></td>
		<td align="center" width="20" style="background-color: {{ setting('site.primary_color') }};"><strong>Kategori</strong></td>
		<td align="center" width="15" style="background-color: {{ setting('site.primary_color') }};"><strong>Role</strong></td>
		<td align="center" width="15" style="background-color: {{ setting('site.primary_color') }};"><strong>Status</strong></td>
	</tr>
	@foreach($user as $key=>$data)
	<tr>
		<td>{{ ($key+1) }}</td>
        <td>{{ $data->nama_user }}</td>
        <td>{{ $data->email }}</td>
        <td align="center">{{ $data->nomor_hp }}</td>
        <td>{{ $data->kategori }}</td>
        <td align="center">{{ $data->nama_role }}</td>
        <td align="center">{{ status($data->status) }}</td>
	</tr>
	@endforeach
</table>