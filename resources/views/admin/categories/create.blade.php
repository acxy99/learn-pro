@extends('layouts.app')

@section('title', '| Create Category')

@section('content')
    <admin-category-form :category="{{ $category }}"></admin-category-form>
@endsection