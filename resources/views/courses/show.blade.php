<?php
use App\Course;
?>

@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <course id="{{ $course->id }}"></course>
@endsection