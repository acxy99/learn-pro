@extends('layouts.app')

@section('title', '| Create Course')

@section('content')
    <courseform :course="{{ $course }}"></courseform>
@endsection