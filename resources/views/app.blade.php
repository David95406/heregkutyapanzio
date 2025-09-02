<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
	    <meta name="description" content="Professzionális kutyapanzió szolgáltatás, ahol kedvence otthon érzi magát Héregen – megbízható gondoskodás, kényelmes elhelyezés és személyre szabott figyelem." />

	    <meta property="og:title" content="Héreg DTC - Kutyapanzió">
	    <meta property="og:image" content="https://heregdtc.hu/images/preview.jpg">
	    <meta property="og:url" content="https://heregdtc.hu">
	    <meta property="og:type" content="website">

        <meta property="og:locale" content="hu_HU">
        <meta property="og:site_name" content="Héreg DTC">


        <meta name="robots" content="index, follow">

        <!-- <title>Héreg DTC</title> -->
        <title>Héreg DTC – Megbízható gondoskodás</title>
        <link rel="icon" href="{{ url('logo.svg') }}">

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @inertiaHead()
        @routes

    </head>
    <body>
        @inertia
    </body>
</html>
