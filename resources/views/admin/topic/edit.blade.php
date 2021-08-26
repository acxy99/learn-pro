@extends('layouts.app')

@section('title', '| Edit Topic')

@section('content')
    <admin-topic-form :course="{{ $course }}" :topic="{{ $topic }}"></admin-topic-form>
@endsection