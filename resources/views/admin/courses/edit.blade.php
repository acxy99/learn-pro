@extends('layouts.app')

@section('title', '| Edit Course')

@section('content')
    <admin-course-form :course="{{ $course }}" :categories="{{ $categories }}"></admin-course-form>
@endsection