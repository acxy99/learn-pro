<?php
use App\Course;
?>

@extends('layouts.app')

@section('title', '| Course')

@section('content')
    <course id="{{ $course_id }}"></course>
@endsection