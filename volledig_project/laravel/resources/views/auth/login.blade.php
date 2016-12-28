@extends('layout')

@section('foto')
	background-image: url({{ URL::asset('assets/img/achtergrond/beach.jpg') }});
@stop

@section('content')
<h1>Inloggen</h1>
<div id="registerdiv">
	<table id="register">
		<form method="POST" action="/auth/login">
			{!! csrf_field() !!}
			<tr>
				<td>Email: &nbsp;</td>
				<td><input type="email" name="email" value="{{ old('email') }}"></td>
			</tr>
			<tr>
				<td>Password: &nbsp;</td>
				<td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="checkbox" name="remember"> Remember Me</td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit" class="btn btn-primary btn-lg"> Log in</button></td>
			</tr>
		</form>
	</table>
</div>
@stop