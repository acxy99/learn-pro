@extends('layouts.app')

@section('title', '| Admin')

@section('content')
    <dashboard 
        :courses-count="{{ $courses_count }}"
        :categories-count="{{ $categories_count }}"
        :users-count="{{ $users_count }}"
    ></dashboard>
@endsection