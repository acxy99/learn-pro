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
        <style>
        .line-clamp {
            display: -webkit-box!important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 48px;
        }
        </style>

        <!-- Icons -->
        <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    </head>
    <body>
        <div id="app">
            @include('layouts.header')
            @include('layouts.success')
            @yield('content')
        </div>

        <script>window.user = {!! Auth::user() !!}</script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>