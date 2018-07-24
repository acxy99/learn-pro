@extends('layouts.app')

@section('title', '| Access Denied')

@section('content')
<div class="container col-md-6" dusk="error-403">
    <div class="jumbotron mt-5 p-2">
        <div class="m-5 text-center">
            <h3>Access Denied :(</h3>
            <hr>
            <p class="font-weight-light">You don't have authorisation to view this page.</p>
            <small class="text-muted">HTTP ERROR 403</small>
        </div>
    </div>
</div>
@endsection