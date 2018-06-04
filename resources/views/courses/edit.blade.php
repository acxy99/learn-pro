@extends('layouts.app')

@section('title', '| Create Course')

@section('content')
    <courseform slug="{{ $slug }}"></courseform>
@endsection