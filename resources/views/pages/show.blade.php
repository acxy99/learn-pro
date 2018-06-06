<?php
use App\Page;
?>

@extends('layouts.app')

@section('title', '| Page')

@section('content')
    <page :course="{{ $course }}" :page="{{ $page }}"></page>
@endsection