<?php
use App\Category;
?>

@extends('layouts.app')

@section('title', '| Category')

@section('content')
    <category id="{{ $category->id }}"></category>
@endsection