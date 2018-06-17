@extends('layouts.app')

@section('title', '| Manage Course')

@section('content')
    <admin-course 
        :course="{{ $course }}" 
        last-updated-page="{{ $lastUpdatedPage }}"
        last-updated-file="{{ $lastUpdatedFile }}"
    ></admin-course>
@endsection