@extends('faturcms::email.main')

@section('content')

	<span id="receiver">Hai <strong>{{ is_object($receiver) ? $receiver->nama_user : $receiver }},</strong></span>
	<br><br>
	{!! html_entity_decode($message) !!}

@endsection