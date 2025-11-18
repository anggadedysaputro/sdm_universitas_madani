<!doctype html>
<!--
	* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
	* @version 1.0.0-beta20
	* @link https://tabler.io
	* Copyright 2018-2023 The Tabler Authors
	* Copyright 2018-2023 codecalm.net Paweł Kuna
	* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
	-->
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
		<title>Sign in</title>
		<style>
			@import url('https://rsms.me/inter/inter.css');
			:root {
			--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
			}
			body {
			font-feature-settings: "cv03", "cv04", "cv11";
			}
		</style>
		@vite([
            'resources/css/app.css',
            'resources/css/gondes.css',
            'resources/css/tabler.min.css',
            'resources/css/tabler-payments.min.css',
            'resources/css/tabler-vendors.min.css',
            'resources/css/demo.min.css',
            'resources/js/app.js',
            'resources/js/tabler.min.js',
            'resources/js/demo-theme.min.js',
            'resources/js/demo.min.js',
            ])
	</head>
	<body  class=" d-flex flex-column bg-white">
		{{-- <script src="./dist/js/demo-theme.min.js?1692870487"></script> --}}
		<div class="row g-0 flex-fill">
			<div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
				<div class="container container-tight my-5 px-lg-5">
					<div class="text-center mb-4">
						<a href="{{ route("dashboard.index") }}" class="navbar-brand navbar-brand-autodark">
						<img src="{{ asset("assets/logo.png") }}" height="36" alt="">
						</a>
					</div>
					<h2 class="h3 text-center mb-3">
						Login to your account
					</h2>
					@if($errors->any())
					@foreach($errors->getMessages() as $this_error)
                    <div class="alert alert-danger">{{ $this_error[0] }}</div>
					@endforeach
					@endif
					<form action="{{ route('login.authenticate') }}" method="post" autocomplete="off" novalidate>
						@csrf
						<div class="mb-3">
							<label class="form-label">Email or Username</label>
							<input type="email" class="form-control" name="email" placeholder="your@email.com" autocomplete="off">
						</div>
						<div class="mb-2">
							<label class="form-label">
							Password
							<span class="form-label-description">
							<a href="./forgot-password.html">I forgot password</a>
							</span>
							</label>
							<div class="input-group input-group-flat">
								<input type="password" class="form-control"  placeholder="Your password"  autocomplete="off" name="password">
								<span class="input-group-text">
									<a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
										<!-- Download SVG icon from http://tabler-icons.io/i/eye -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
											<path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
											<path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
										</svg>
									</a>
								</span>
							</div>
						</div>
						<div class="form-footer">
							<button type="submit" class="btn btn-primary w-100">Sign in</button>
						</div>
						{{-- {{ dd(session()->all()) }} --}}
					</form>
				</div>
			</div>
			<div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
				<!-- Photo -->
				<div class="bg-cover h-100 min-vh-100" style="background-image: url({{ asset('assets/photos/stylish-workspace-with-macbook-pro.jpg') }})"></div>
			</div>
		</div>
		<!-- Libs JS -->
		<!-- Tabler Core -->
		{{-- <script src="./dist/js/tabler.min.js?1692870487" defer></script>
		<script src="./dist/js/demo.min.js?1692870487" defer></script> --}}
	</body>
</html>
