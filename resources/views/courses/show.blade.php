<?php
use App\Course;
?>

@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <course slug="{{ $slug }}"></course>
@endsection