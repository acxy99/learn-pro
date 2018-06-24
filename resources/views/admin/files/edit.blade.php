@extends('layouts.app')

@section('title', '| Manage Files')

@section('content')
    <admin-file-edit-form :course="{{ $course }}" :file="{{ $file }}"></admin-file-edit-form>
@endsection