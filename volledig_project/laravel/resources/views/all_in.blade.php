@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/ski.jpg') }});
@stop

@section('content')
	<h1>Ski</h1>
	<form id="zoekform">
		<div class="input-group" id="zoekbalk">
			<input type="text" class="form-control" name="zoekterm" placeholder="Adres / Hotel / Gebied" value="{{ Input::get('zoekterm') }}">
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
			@foreach($ski as $skivak)
				@if (strpos(strtolower($skivak->naam), strtolower($input)) !== false || strpos(strtolower($skivak->adres), strtolower($input)) !== false || strpos(strtolower($skivak->skigebied), strtolower($input)) !== false ) 
				<tr>
				<td class="tbl_foto"><a href="vakantie/ski/{{ $skivak->id }}"><img class="img-responsive" src="{{ URL::asset('assets/img/vakanties/ski/vakantie').$skivak->id.'/'.'vak'.$skivak->id.'_0'.'.jpg' }}" alt="foto"/></a></td>
				<td>
					<div class="tbl_info">
						<p>{{ $skivak->naam }} </p>
						<p>
						@for($teller = 0; $teller < $skivak->sterren; $teller++)
							<span class="glyphicon glyphicon-star-empty"></span>
						@endfor
						</p>
						<p>{{ $skivak->land }}</p>
						<?php
						$ppunten = explode(" | ", $skivak->pluspunten);
						?>
						@foreach($ppunten as $pp)
							<p><span class="glyphicon glyphicon-thumbs-up"></span>	{{ $pp }}</p>
						@endforeach
					</div>
				</td> 
				<td>
					<div>
						<a href="vakantie/ski/{{ $skivak->id }}"><button type="button" class="btn btn-primary btn-lg infoknop">Meer info <span class="glyphicon glyphicon-chevron-right" style="color:white"></span></button></a>
						<p>Vanaf €{{ $skivak->prijspp }} per persoon</p>
					</div>
				</td>
				</tr>
				@endif
			@endforeach
			</tbody>
		</table>
	</div>
@stop