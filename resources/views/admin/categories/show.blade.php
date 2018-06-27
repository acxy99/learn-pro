@extends('layouts.app')

@section('title', '| Manage Category')

@section('content')
    <admin-category :category="{{ $category }}"></admin-category>
@endsection