@extends('layouts.app')

@section('title', '| Manage Courses')

@section('content')
    <admin-courses :courses="{{ $courses }}"></admin-courses>
@endsection