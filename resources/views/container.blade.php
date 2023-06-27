<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	@routes
	@vite([
		'resources/js/app.js',
		'resources/css/app.css',
	])
</head>
<body>
	<div class="container-xxl">
		<nav class="navbar navbar-expand-lg bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="{{ route('home') }}">{{__('view.home_page') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="{{ route('tasks.create') }}">{{__('view.create_tasks') }}</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		{{-- conteudo --}}
		<main class="container-xl">
			@yield('content')
		</main>
	</div>

	{{-- alert personalizado --}}
	<div class="modal fade" id="modal-alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-alertLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" id="message-alert"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>