@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/beach.jpg') }});
@stop

@section('content')
	<h1>Home</h1>
	<div id="welcome">
		<p>Welkom bij Travlr!</p>
		<p>U kan hierboven uw reisformule kiezen en de door ons geselecteerde formules doorzoeken.</p>
	</div>
	</br>
	<p>Weet je niet welk type van reis je wil maken? Zoek dan hieronder op land of gebied.</p>
	<form>
		<div class="input-group">
			<input type="text" class="form-control" name="zoekterm" placeholder="Zoeken naar hotels in land / gebied" value="{{ Input::get('zoekterm') }}">
			<div class="input-group-btn">
			  <button class="btn btn-default" type="submit">
				<span class="glyphicon glyphicon-search"></span>
			  </button>
			</div>
		</div>
	</form>
	<?php
		$input = Input::get('zoekterm');
		if($input == "") $input = " ";
	?>
	
	<div id="banner" class="carousel slide" data-ride="carousel">		<!-- id wordt gebruikt in carousel als target -->
	  <!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="{{ URL::asset('assets/img/banners/banner0.jpg') }}" alt="foto" class="slide">
			</div>

		</div>

	  <!-- Left and right controls -->
		<a class="left carousel-control" href="#banner" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#banner" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	
	
<!--	@if(Auth::check())
	<div>
		<?php
			//$gebruiker = Auth::user();
		?>
	<p> welkom, {{ $gebruiker->name }}! </p>
	</div>
	@endif
-->
@stop