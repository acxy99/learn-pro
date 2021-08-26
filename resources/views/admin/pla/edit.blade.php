@extends('layouts.app')

@section('title', '| Edit PLA Form')

@section('content')
    <admin-pla-question-form :course="{{ $course }}" :pla="{{$pla}}" :topic ="{{$topic}}"></admin-pla-question-form>
@endsection