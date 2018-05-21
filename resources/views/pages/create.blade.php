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
        <h3>Create Page</h3><br>
        {!! Form::model($page, [
            'route' => ['pages.store'],
        ]) !!}

        <!-- Title -->
        <div class="row">
            <div class="form-group col-sm-6">
                {!! Form::label('title', 'Title', ['class' => 'control-label']) !!}
                {!! Form::text('title', null, [
                    'class' => 'form-control',
                    'maxlength' => 50,
                ]) !!}
            </div>
        </div>

        <!-- Body -->
        {!! Form::label('body', 'Content', ['class' => 'control-label']) !!}
        {!! Form::textarea('body', null) !!}
        <br>

        <!-- Course ID -->
        <div class="row">
            <div class="form-group col-sm-6">
                {!! Form::label('course_id', 'Course ID', ['class' => 'control-label']) !!}
                {!! Form::text('course_id', 1, [
                    'class' => 'form-control',
                    'maxlength' => 50,
                ]) !!}
            </div>
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