@extends('layouts.app')

@section('title', '| Create Page')

@section('content')
    <pageform :course="{{ $course }}" :parents="{{ $parents }}" :page="{{ $page }}"></pageform>
@endsection