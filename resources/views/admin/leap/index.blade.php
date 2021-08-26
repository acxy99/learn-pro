@extends('layouts.app')

@section('title', '| Manage LEAP')

@section('content')
    <admin-leap :course="{{ $course }}"></admin-leap>
@endsection