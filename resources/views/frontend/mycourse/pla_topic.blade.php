@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <pla-topic :course="{{ $course }}"></pla-topic>
@endsection