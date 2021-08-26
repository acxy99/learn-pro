@extends('layouts.app')

@section('title', '| Create Topic')

@section('content')
    <admin-topic-form :course="{{ $course }}" :topic="{{ $topic }}"></admin-topic-form>
@endsection