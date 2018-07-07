@extends('layouts.app')

@section('title', '| View Profile')

@section('content')
    <profile :profile="{{ $profile }}"></profile>
@endsection