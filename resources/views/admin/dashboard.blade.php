@extends('layouts.app')

@section('title', '| Admin')

@section('content')
    <dashboard 
        :courses-count="{{ $courses_count }}"
        :categories-count="{{ $categories_count }}"
        :users-count="{{ $users_count }}"
        :instructors-count="{{  $instructors_count }}"
        :learners-count="{{ $learners_count }}"
    ></dashboard>
@endsection