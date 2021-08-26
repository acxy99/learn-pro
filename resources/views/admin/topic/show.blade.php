@extends('layouts.app')

@section('title', '| Manage Topic')

@section('content')
    <admin-topic-view :course="{{ $course}}" :topic ="{{$topic}}"></admin-topic-view>
@endsection