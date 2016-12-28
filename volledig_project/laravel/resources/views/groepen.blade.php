@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/group.jpg') }});
@stop

@section('content')
	<h1>Groepen</h1>
	<p>Welkom bij Travlr!</br>
	U kan hierboven uw reisformule kiezen en de door ons geselecteerde formules doorzoeken.</p>
@stop