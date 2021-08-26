@extends('layouts.app')

@section('title', '| Manage Topic')

@section('content')
    <admin-topic :course="{{ $course }}"></admin-topic>
@endsection