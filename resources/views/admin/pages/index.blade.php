@extends('layouts.app')

@section('title', '| Manage Pages')

@section('content')
    <admin-pages :course="{{ $course }}" :topic="{{$topic}}"></admin-pages>
@endsection