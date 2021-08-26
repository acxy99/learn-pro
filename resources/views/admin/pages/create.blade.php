@extends('layouts.app')

@section('title', '| Create Page')

@section('content')
    <admin-page-form :course="{{ $course }}" :parents="{{ $parents }}" :files="{{ $files }}" :page="{{ $page }}" :topic="{{$topic}}"></admin-page-form>
@endsection