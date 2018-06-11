@extends('layouts.app')

@section('title', '| Create Page')

@section('content')
    <page-form :course="{{ $course }}" :parents="{{ $parents }}" :files="{{ $files }}" :page="{{ $page }}"></page-form>
@endsection