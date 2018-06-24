<?php
use App\Course;
?>

@extends('layouts.app')

@section('title', '| Courses')

@section('stylesheets')
<style>
    .wrapper {
        position: relative;
        overflow: hidden;
    }

    .wrapper:after {
        content: '';
        display: block;
        padding-top: 75%;
    }

    .wrapper img {
        width: auto;
        height: 100%;
        max-width: none;
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
    }
</style>
@endsection

@section('content')
    <courses></courses>
@endsection