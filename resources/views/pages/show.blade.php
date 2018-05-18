<?php
use App\Page;
?>

@extends('layouts.app')

@section('title', '| Page')

@section('content')
    <page id="{{ $page->id }}"></page>
@endsection