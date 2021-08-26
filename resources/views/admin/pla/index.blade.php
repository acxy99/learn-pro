@extends('layouts.app')

@section('title', '| Manage PLA')

@section('content')
    <admin-pla-questions :course="{{$course}}" :topic="{{$topic}}"></admin-pla-questions>
@endsection