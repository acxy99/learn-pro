@extends('layouts.app')

@section('title', '| Admin')

@section('content')
    <dashboard :courses-count="{{ $courses_count }}"></dashboard>
@endsection