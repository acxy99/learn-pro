@extends('layouts.app')

@section('title', '| Upload Files')

@section('content')
    <files-upload-form :course="{{ $course }}"></files-upload-form>
@endsection