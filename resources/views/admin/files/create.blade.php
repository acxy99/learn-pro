@extends('layouts.app')

@section('title', '| Upload Files')

@section('content')
    <admin-files-upload-form :course="{{ $course }}" :topic="{{$topic}}"></admin-files-upload-form>
@endsection