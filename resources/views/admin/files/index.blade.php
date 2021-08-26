@extends('layouts.app')

@section('title', '| Manage Files')

@section('content')
    <admin-files :course="{{ $course }}" :topic="{{$topic}}"></admin-files>
@endsection