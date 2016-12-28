@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/beach.jpg') }});
@stop

@section('content')
<h1>Registreren</h1>
<div id="registerdiv">
	<table id="register">
		<form method="POST" action="/auth/register">
			{!! csrf_field() !!}
			<tr>
				<td>Naam: &nbsp;</td>
				<td><input type="text" name="name" value="{{ old('name') }}" required></td>
			</tr>
			<tr>
				<td>Email: &nbsp;</td>
				<td><input type="email" name="email" value="{{ old('email') }}" required></td>
			</tr>
			<tr>
				<td>Wachtwoord: &nbsp;</td>
				<td><input type="password" name="password" required></td>
			</tr>
			<tr>
				<td>Bevestig wachtwoord: &nbsp;</td>
				<td><input type="password" name="password_confirmation" required></td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit" class="btn btn-primary btn-lg"> Registreer</button></td>
			</tr>
		</form>
	</table>
</div>
@stop