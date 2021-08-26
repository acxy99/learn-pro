@extends('layouts.app')

@section('title', '| Manage Files')

@section('content')
    <admin-file-edit-form :course="{{ $course }}" :file="{{ $file }}" :topic="{{$topic}}"></admin-file-edit-form>
@endsection