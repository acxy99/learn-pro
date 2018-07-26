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
        .anchor-custom {
            opacity: 1;
        }

        .anchor-custom:hover { 
            opacity: 0.8;
            text-decoration: none;
        }

        .br-0 {
            border-radius: 0!important;
        }

        .line-clamp {
            display: -webkit-box!important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 48px;
        }

        .btn-form {
            width: 150px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            display: inline-block;
            padding-right: 0.5rem;
            color: #6c757d;
            font-family: "Material Icons";
            content: "navigate_next"!important;
        }
        </style>

        <!-- Icons -->
        <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            @include('layouts.header')
            @include('layouts.success')
            @yield('content')
        </div>

        @if(Auth::user())
            <script>window.user = {!! Auth::user() !!}</script>
        @endif
        
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>