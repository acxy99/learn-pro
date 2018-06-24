@extends('layouts.app')

@section('title', '| Manage Page')

@section('content')
    <admin-page :course="{{ $course }}" :page="{{ $page }}"></admin-page>
@endsection