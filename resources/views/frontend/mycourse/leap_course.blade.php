@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <leap-course :course="{{$course}}"></leap-course>
@endsection