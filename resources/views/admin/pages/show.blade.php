@extends('layouts.app')

@section('title', '| Manage Page')

@section('content')
    <admin-page :course="{{ $course }}" :page="{{ $page }}" :topic="{{ $topic }}"></admin-page>
@endsection