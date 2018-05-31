<?php
use App\Course;
use App\Page;
?>

@extends('layouts.app')

@section('title', '| Create Page')

@section('stylesheets')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=jvygsti8vfl669gfq2jxa3h5qr00kuj22sgdd3tfhibp14yj"></script>
    <script>
        tinymce.init({ 
            selector:'textarea',
            height: '500',
            plugins: 'codesample',
            toolbar: 'codesample',
        });
    </script>
@endsection

@section('content')

    <div class="container">
        <small>
            <a href="/courses/{{ $course->code }}" style="text-decoration: none">{{ $course->code }} {{ $course->title }}</a>
        </small>
        <h3>Create Page</h3><br>
        {!! Form::model($page, [
            'route' => ['pages.store'],
        ]) !!}

        <!-- Course ID -->
        <div class="form-group">
            {!! Form::label('course_id', 'Course ID', ['class' => 'control-label']) !!}
            {!! Form::text('course_id', $course->id, [
                'class' => 'form-control',
                'readonly'
            ]) !!}
        </div>

        <!-- Title -->
        <div class="form-group">
            {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
            {!! Form::text('title', null, [
                'class' => 'form-control',
                'maxlength' => 50,
            ]) !!}
        </div>

        {{-- Parent ID --}}
        <div class="form-group">
            {!! Form::label('parent_id', 'Parent ID', ['class' => 'control-label']) !!}
            {!! Form::select('parent_id', Page::where('course_id', $course->id)->where('parent_id', null)->pluck('title', 'id'), null, [
                'class' => 'form-control',
                'placeholder' => 'None',
            ]) !!}
        </div>

        <!-- Body -->
        <div class="form-group">
            {!! Form::label('body', 'Content', ['class' => 'control-label']) !!}
            {!! Form::textarea('body', null) !!}
        </div>

        <!-- Submit Button -->
        <div class="form-group text-center">
            {!! Form::button('Save', [
                'type' => 'submit',
                'class' => 'btn btn-primary',
            ]) !!}
        </div>

        {!! Form::close() !!}

    </div>

@endsection