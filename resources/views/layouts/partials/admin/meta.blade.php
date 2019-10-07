<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	  <meta name="csrf-token" content="{{ csrf_token() }}">

	  <title>{{ config('app.name') }}</title>


		<!-- Styles -->
		
		<!------------------------------>
		<!-- ADD THIS LINE UNDERNEATH -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- ADD THIS LINE ABOVE -->
		<!------------------------------>

	  <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
	</head>
	<body>

		{{-- Body Content --}}
		<div id="admin-app">
			@yield('master')
		</div>
		
		<!-- Scripts -->
	  <script src="{{ mix('js/admin.js') }}"></script>
	  @yield('scripts')

	</body>
</html>
