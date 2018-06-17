<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

        <title>LearnPro @yield('title')</title>

        @yield('stylesheets')

        <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    </head>
    <body>
        <div id="app">
            @include('layouts.header')
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>