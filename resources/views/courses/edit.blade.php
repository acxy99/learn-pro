@extends('layouts.app')

@section('title', '| Create Course')

@section('content')
    <course-form :course="{{ $course }}"></course-form>
@endsection