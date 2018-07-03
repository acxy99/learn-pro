@extends('layouts.app')

@section('title', '| Create Users')

@section('content')
    <admin-user-form :user="{{ $user }}"></admin-user-form>
@endsection