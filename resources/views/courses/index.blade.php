<?php
use App\Course;
?>

@extends('layouts.app')

@section('title', '| Courses')

@section('content')
    <courses></courses>
    {{-- {{ $courses->links() }} --}}
@endsection