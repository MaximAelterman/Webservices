@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/vakanties/vakantie'.$vakdata->id.'/vak0.jpg') }});
@stop

@section('content')
<?php
	$gebruikerID = Auth::id();
	$kamerTypes = "";
	$aantPers = "";
	$daterange = Input::get('daterange');
	$escDaterange = str_replace('/', "_", $daterange);
	$reisduur = Input::get('reisduur');
	$aantKamers = Input::get('aantal_kamers');
	$totaalPrijs = 0;
	for($i = 0; $i < $aantKamers; $i++)
	{
		$temp = $i + 1;
		$type[$i] = Input::get('type'.$temp);
		$personen[$i] = Input::get('personen'.$temp);
		foreach($kamerdata as $kamerD)
		{
			if($type[$i] == $kamerD->id)
			{
				if($kamerTypes == "")
				{
					$kamerTypes = $type[$i];
					$aantPers = $personen[$i];
				}
				else
				{
					$kamerTypes = $kamerTypes." | ".$type[$i];
					$aantPers = $aantPers." | ".$personen[$i];
				}
				$type[$i] = $kamerD->naam;
				$prijs[$i] = $kamerD->prijsPP;
				break;
			}
		}
	}
?>
	<h1>Boeken</h1>
	<p>Controleer of volgende gegevens correct zijn</p>
	<table id="boektbl">
		<tr><th class="top_th">{{ $vakdata->naam }}</th><th class="top_th">{{ $reisduur }} dagen naar {{ $vakdata->gebied }}, {{ $vakdata->land }} ({{ $daterange }})</th></tr>
	@for($kamer = 0; $kamer < $aantKamers; $kamer++)
		<?php
			$prijs[$kamer] = $prijs[$kamer] * $personen[$kamer] * $reisduur; 
			$totaalPrijs += $prijs[$kamer];
		?>
		<tr><th>kamer {{ $kamer + 1 }}</th><th></th></tr>
		<tr><td>{{ $type[$kamer] }}</td><td>{{ $personen[$kamer] }} {{ $personen[$kamer] == '1' ? 'persoon' : 'personen'}}</td><td>€{{ $prijs[$kamer] }}</td></tr>
	@endfor
		<tr><td></td><td>totaal prijs: </td><td>€{{ $totaalPrijs }}</td>
	</table>
	<a href="/betalen/{{ $kamerTypes }}/{{ $aantPers }}/{{ $vakdata->id }}/{{ $totaalPrijs }}/{{ $escDaterange }}"><button type="button" class="btn btn-primary btn-lg infoknop" id="betaalknop" onclick="betaal()">Boeken en betalen</button></a>
	
@stop