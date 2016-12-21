<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Travlr</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
		    <!-- Bootstrap -->
		<link href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('assets/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('assets/css.css') }}" rel="stylesheet" />
		<style>
			body::before{
				@yield('foto')
			}
		</style>
		<script src="{{ URL::asset('assets/js/jquery.js') }}"></script>					<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
		<script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
		<script src="{{ URL::asset('assets/js/kamers.js') }}"></script>
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigatie">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/">Travlr</a>
				</div>
				<div class="collapse navbar-collapse" id="navigatie">
					<ul class="nav navbar-nav">
						<li class="{{ Request::path() == '/' ? 'active' : '' }}"><a href="/"><span class="glyphicon glyphicon-home"></span></a></li>
						<li class="{{ Request::path() == 'citytrips' ? 'active' : '' }}"><a href="/citytrips">citytrips</a></li>
						<li class="{{ Request::path() == 'ski' ? 'active' : '' }}"><a href="/ski">ski</a></li>
						<li class="{{ Request::path() == 'all_in' ? 'active' : '' }}"><a href="/all_in">all inclusive</a></li>
						<li class="{{ Request::path() == 'groepen' ? 'active' : '' }}"><a href="/groepen">groepen</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					@if(Auth::check())
						<li><a href="auth/logout"> Logout</a></li>
					@else
						<li><a href="register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						<li><a href="login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					@endif
					</ul>
				</div>
			</div>
		</nav>
		<div id="wrapper">
			@yield('content')
		</div>
	</body>
	
</html>
