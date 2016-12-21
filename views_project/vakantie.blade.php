@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/'.$vakdata->type.'.jpg') }});
@stop

@section('content')
<script>
	function aantalkamers($aantal){
		
	}
</script>
	<h1>{{ $vakdata->naam }}</h1>
	<p class="text-center">
		@for($teller = 0; $teller < $vakdata->sterren; $teller++)
			<span class="glyphicon glyphicon-star-empty"></span>
		@endfor
	</p>
	<div id="slidercontainer">
	<table id="slidertable">
		<tr><td id="slidertd">
		<div id="slider" class="carousel slide" data-ride="carousel">
		  <!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img class="slider_foto" src="{{ URL::asset('assets/img/vakanties/vakantie'.$vakdata->id.'/vak0.jpg') }}" alt="foto" class="slide">
				</div>
				@for($i = 1; $i < $vakdata->aantalfotos; $i++)
					<div class="item">
						<img class="slider_foto" src="{{ URL::asset('assets/img/vakanties/vakantie'.$vakdata->id.'/vak'.$i.'.jpg') }}" alt="foto" class="slide">
					</div>
				@endfor
			</div>

		  <!-- Left and right controls -->
			<a class="left carousel-control" href="#slider" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#slider" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div></td><td id="boektd">
		<div id="boekdiv" class="pull-right">
			<a class="page-scroll" href="#boeken"><button type="button" class="btn btn-primary btn-lg infoknop">Vakantie boeken <span class="glyphicon glyphicon-chevron-right" style="color:white"></span></button></a>
			<p>Prijs per persoon: €{{ $vakdata->prijspp }}</p>
		</div></td>
	</table>
	</div>
	<h3>{{ $vakdata->naam }}</h3>
	<p><?php echo nl2br(e($vakdata->beschrijving)) ?></p>
	<h3>ligging</h3>
	<ul>
		<?php $ligging = explode(" | ", $vakdata->ligging); ?>
		@foreach($ligging as $punt)
			<li>{{ $punt }}</li>
		@endforeach
	</ul>
	<h3>kamertypes</h3>
	<ul>
		<?php $kamertypes = explode(" | ", $vakdata->kamertypes); ?>
		@foreach($kamertypes as $kamertypetemp)
			<?php $kamertype = explode(" § ", $kamertypetemp) ?>
			<li>{{ $kamertype[0] }} &nbsp;&nbsp;&nbsp;&nbsp; (&nbsp;€{{ $kamertype[1] }} per persoon&nbsp;)</li>
		@endforeach
	</ul>
	<h3>faciliteiten</h3>
	<ul>
		<?php $faciliteiten = explode(" | ", $vakdata->faciliteiten); ?>
		@foreach($faciliteiten as $faciliteit)
			<li>{{ $faciliteit }}</li>
		@endforeach
	</ul>
	<br id="boeken"/>
	<br/>
	<h2>Boeken en prijzen</h2>
	<form id="boekform">
		<label>Aantal kamers:</label>
		<select name="aantal_kamers">
			@for ($i = 1; $i < 10; $i++)
				<option value="{{ $i }}" onchange="toonKamers(this.value)">{{ $i }}</option>
			@endfor
		</select>
	</form>
@stop