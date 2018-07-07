<?php
use App\Common;
?>

@extends('layouts.app')

@section('title', '| Edit Profile')

@section('content')
    <profile-form :profile="{{ $profile }}" :countries="{{ json_encode(Common::$countries) }}"></profile-form>
@endsection