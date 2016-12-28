@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/citytrips.jpg') }});
@stop

@section('content')
	<h1>Ski</h1>
	<form id="zoekform">
		<div class="input-group" id="zoekbalk">
			<input type="text" class="form-control" name="zoekterm" placeholder="Adres / Hotel / stad" value="{{ Input::get('zoekterm') }}"></input>
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
	<div id="content">
		<table class="table table-hover">
			<tbody>
			@foreach($citytrips as $trip)
				@if (strpos(strtolower($trip->naam), strtolower($input)) !== false || strpos(strtolower($trip->adres), strtolower($input)) !== false) 
				<tr>
				<td class="tbl_foto"><a href="vakantie/{{ $trip->id }}"><img class="img-responsive" src="{{ URL::asset('assets/img/vakanties/vakantie'.$trip->id.'/'.'vak0.jpg') }}" alt="foto"/></a></td>
				<td>
					<div class="tbl_info">
						<p>{{ $trip->naam }} </p>
						<p>
						@for($teller = 0; $teller < $trip->sterren; $teller++)
							<span class="glyphicon glyphicon-star-empty"></span>
						@endfor
						</p>
						<p>{{ $trip->land }}</p>
						<?php
						$limiter = 0;
						$ppunten = explode(" | ", $trip->pluspunten);
						?>
						@foreach($ppunten as $pp)
							@if($limiter < 3)
								<p><span class="glyphicon glyphicon-thumbs-up"></span>	{{ $pp }}</p>
							<?php
								$limiter++;
							?>
							@endif
						@endforeach
					</div>
				</td> 
				<td>
					<div>
						<a href="vakantie/{{ $trip->id }}"><button type="button" class="btn btn-primary btn-lg infoknop">Meer info <span class="glyphicon glyphicon-chevron-right" style="color:white"></span></button></a>
						<p>Vanaf €{{ $trip->prijspp }} per persoon</p>
					</div>
				</td>
				</tr>
				@endif
			@endforeach
			</tbody>
		</table>
	</div>
@stop