@extends('layouts.app')

@section('title', '| Edit Course')

@section('content')
    <admin-course-form :course="{{ $course }}"></admin-course-form>
@endsection