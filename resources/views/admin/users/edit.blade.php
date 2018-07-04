@extends('layouts.app')

@section('title', '| Create Users')

@section('content')
<admin-user-form :user="{{ $user }}" :roles="{{ $roles }}" :currentRole="{{ $currentRole }}"></admin-user-form>
@endsection