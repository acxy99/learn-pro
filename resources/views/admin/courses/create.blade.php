@extends('layouts.app')

@section('title', '| Create Course')

@section('content')
    <admin-course-form :course="{{ $course }}"></admin-course-form>
@endsection