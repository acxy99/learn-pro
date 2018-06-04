@extends('layouts.app')

@section('title', '| Create Course')

@section('content')
    <courseform :id="{{ $course_id }}"></courseform>
@endsection