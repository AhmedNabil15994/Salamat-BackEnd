<head>

	<meta charset="utf-8" />
	<title>@yield('title', setting('app_name',locale())) - {{ setting('app_name',locale()) }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	@if (is_rtl() == 'rtl')
		<link rel="stylesheet" href="{{ url('frontend/css/bootstrap-rtl.min.css') }}" />
	@else
		<link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}" />
	@endif
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
	<link rel="stylesheet" href="{{ url('frontend/css/animate.css') }}" />
	<link rel="stylesheet" href="{{ url('frontend/css/owl.carousel.min.css') }}" />
	<link rel="stylesheet" href="{{ url('frontend/css/main.css') }}" />

	<link rel="shortcut icon" href="{{ setting('favicon') ? url(setting('favicon')) : ''}}" />

	@yield('css')

</head>
