@extends('layouts.app')

@section('title', '| Manage LEAP')

@section('content')
    <admin-leap-question-form :course="{{ $course }}" :leap="{{$leap}}"></admin-leap-question-form>
@endsection