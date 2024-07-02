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
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title>@yield('title')</title>
	<!-- CSS files -->
    <style>
		@font-face {
			font-family: "tabler-icons";
			font-style: normal;
			font-weight: 400;
			src: url("{{ asset('assets/icons/tabler-icons.eot') }}");
			src: url("{{ asset('assets/icons/tabler-icons.eot') }}") format("embedded-opentype"), url("{{ asset('assets/icons/tabler-icons.woff2') }}") format("woff2"), url("{{ asset('assets/icons/tabler-icons.woff') }}") format("woff"), url("{{ asset('assets/icons/tabler-icons.ttf') }}") format("truetype")
		}
	</style>
	<x-vite/>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
	<body>
		<div class="page">
