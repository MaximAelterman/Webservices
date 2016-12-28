@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/'.$vakdata->type.'.jpg') }});
@stop

@section('content')
<?php
	$aantKamers = Input::get('aantal_kamers', 1);
	$datumrange = Input::get('daterange', "");
	$foutmelding = "";
	if($datumrange != "")							//onderstaande code veronderstelt dat er een datum van formaat DD/MM/YYYY binnen komt
	{
		$datums = explode(' - ', $datumrange);						//begin en einddatum splitsen
		$temp = explode('/', $datums[0]);							//DD/MM/YYYY splitsen
		$begin = strtotime($temp[1]."/".$temp[0]."/".$temp[2]);		//DD/MM/YYYY --> MM/DD/YYYY zo dat we strtotime kunnen doen om de data af te kunnen trekken
		$temp = explode('/', $datums[1]);
		$eind = strtotime($temp[1]."/".$temp[0]."/".$temp[2]);
		$aantDagen = $eind - $begin;
		$aantDagen = floor($aantDagen / (60 * 60 * 24));
//controleren of datum valid is
		$test = $begin - strtotime(date("m/d/Y"));
		$test = floor($test / (60 * 60 * 24));
		if($test <= 0)
		{
			$foutmelding = "We bieden helaas nog geen tijdreizen aan (controleer de datums)";
		}
	}
	else
	{
		$aantDagen = 0;
	}

?>
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
			<a href="#boeken"><button type="button" class="btn btn-primary btn-lg infoknop">Vakantie boeken <span class="glyphicon glyphicon-chevron-right" style="color:white"></span></button></a>
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
		@foreach($kamerdata as $kamer)
			<li>{{ $kamer->naam }} &nbsp;&nbsp;&nbsp;&nbsp; (&nbsp;€{{ $kamer->prijsPP }} per persoon&nbsp;)</li>
			<ul style="list-style-type:circle">
				<?php $specs = explode(" | ", $kamer->specs); ?>
				@foreach($specs as $spec)
					<li>{{ $spec }}</li>
				@endforeach
			</ul>
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
	<form id="boekform" method="GET" action="#boeken">
		<span class="glyphicon glyphicon-calendar"></span>
		<input style="width: 170px" type="text" name="daterange" value="{{ $datumrange }}" /><button type="button" onclick="this.form.submit()" class="btn btn-primary btn-sm">ok</button></br>
		<input type="text" name="reisduur" value="{{ $aantDagen }}" hidden></input>
		<label>Aantal kamers:</label>
		<select name="aantal_kamers" onchange="this.form.submit()">
			@for ($i = 1; $i < 6; $i++)
				@if ($i == $aantKamers)
					<option selected="selected" value="{{ $i }}">{{ $i }}</option>
				@else
					<option value="{{ $i }}">{{ $i }}</option>
				@endif
			@endfor
		</select>
		@for ($i = 1; $i <= $aantKamers; $i++)
		<?php
			$aantPers = Input::get('personen'.$i, 1);
			$min = 10;
			$max = 0;
			foreach($kamerdata as $kamer)
			{
				if($kamer->minPers < $min)
				{
					$min = $kamer->minPers;
				}
				if($kamer->maxPers > $max)
				{
					$max = $kamer->maxPers;
				}
			}
		?>
			<h3>Kamer {{ $i }}</h3>
			Voor 
			<select name="personen{{ $i }}" onchange="this.form.submit()">
				@for ($pers = $min; $pers <= $max; $pers++)
					@if ($pers == $aantPers)
						<option selected="selected" value="{{ $pers }}"> {{ $pers }} </option>
					@else
						<option value="{{ $pers }}"> {{ $pers }} </option>
					@endif
				@endfor
			</select> personen</br></br>
			Kamertype:
			<select name="type{{ $i }}">
				@foreach($kamerdata as $kamer)
					@if($aantPers <= $kamer->maxPers && $aantPers >= $kamer->minPers)
						<?php
							$kType = Input::get('type'.$i, $kamer->id);
						?>
						@if($kType == $kamer->id)
							<option selected="selected" value="{{ $kamer->id }}">{{ $kamer->naam }} - €{{ $kamer->prijsPP }} per persoon&nbsp;</option>
						@else
							<option value="{{ $kamer->id }}">{{ $kamer->naam }} - €{{ $kamer->prijsPP }} per persoon&nbsp;</option>
						@endif
					@endif
				@endforeach
			</select></br></br>
		@endfor
		@if ($foutmelding == "" && $aantDagen != 0)
			@if (Auth::check())
				<button type="button" class="btn btn-primary btn-lg infoknop" onclick="this.form.action = '/boeken/{{ $vakdata->id }}'; this.form.submit();">Prijzen en Boeken</button>
			@else
				<button type="button" class="btn btn-primary btn-lg infoknop" onclick="this.form.action = '/boeken/{{ $vakdata->id }}'; this.form.submit();">Prijzen en Boeken</button>
			@endif
		@else
			<button type="button" class="btn btn-primary btn-lg infoknop" disabled>Prijzen en Boeken</button>  {{ $foutmelding  }}
		@endif
	</form>
@stop