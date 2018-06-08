@extends('layouts.app')

@section('title', '| Create Page')

@section('content')
    <page-form :course="{{ $course }}" :parents="{{ $parents }}" :page="{{ $page }}"></page-form>
@endsection