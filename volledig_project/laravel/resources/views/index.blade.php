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
	
		<div id="content">
		<table class="table table-hover">
			<tbody>
			@foreach($vakantie as $vak)
				@if (strpos(strtolower($vak->naam), strtolower($input)) !== false || strpos(strtolower($vak->adres), strtolower($input)) !== false || strpos(strtolower($vak->gebied), strtolower($input)) !== false ) 
				<tr>
				<td class="tbl_foto"><a href="vakantie/{{ $vak->id }}"><img class="img-responsive" src="{{ URL::asset('assets/img/vakanties/vakantie'.$vak->id.'/'.'vak0.jpg') }}" alt="foto"/></a></td>
				<td>
					<div class="tbl_info">
						<p>{{ $vak->naam }} &nbsp;&nbsp;( categorie: {{ $vak->type }} )</p>
						<p>
						@for($teller = 0; $teller < $vak->sterren; $teller++)
							<span class="glyphicon glyphicon-star-empty"></span>
						@endfor
						</p>
						<p>{{ $vak->land }}</p>
						<?php
						$limiter = 0;
						$ppunten = explode(" | ", $vak->pluspunten);
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
						<a href="vakantie/{{ $vak->id }}"><button type="button" class="btn btn-primary btn-lg infoknop">Meer info <span class="glyphicon glyphicon-chevron-right" style="color:white"></span></button></a>
						<p>Vanaf €{{ $vak->prijspp }} per persoon</p>
					</div>
				</td>
				</tr>
				@endif
			@endforeach
			</tbody>
		</table>
	</div>
@stop