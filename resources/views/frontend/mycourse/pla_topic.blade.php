@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <pla-topic :topic ="{{$topic}}" :course="{{$course}}"></pla-topic>
@endsection