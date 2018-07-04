@extends('layouts.app')

@section('title', '| Create Users')

@section('content')
<admin-user-form :user="{{ $user }}" :roles="{{ $roles }}"></admin-user-form>
@endsection