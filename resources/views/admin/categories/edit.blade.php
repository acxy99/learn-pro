@extends('layouts.app')

@section('title', '| Edit Category')

@section('content')
    <admin-category-form :category="{{ $category }}"></admin-category-form>
@endsection