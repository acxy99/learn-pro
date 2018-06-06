<?php
use App\Course;
use App\Page;
?>

@extends('layouts.app')

@section('title', '| Create Page')

@section('content')
    <pageform :course="{{ $course }}" :parents="{{ $parents }}"></pageform>
@endsection