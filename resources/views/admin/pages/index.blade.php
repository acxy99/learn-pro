@extends('layouts.app')

@section('title', '| Manage Pages')

@section('content')
    <admin-pages :course="{{ $course }}"></admin-pages>
@endsection