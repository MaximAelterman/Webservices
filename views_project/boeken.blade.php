@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/ski.jpg') }});
@stop

@section('content')
	<h1>{{ $vakantie->naam }}</h1>
@stop