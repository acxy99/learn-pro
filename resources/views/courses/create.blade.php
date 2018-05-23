@extends('layouts.app')

@section('title', '| Create Course')

@section('content')

    <div class="container">
        <h3>Create Course</h3><hr>
        {!! Form::model($course, [
            'route' => ['courses.store'],
        ]) !!}

        <!-- Code -->
        <div class="form-group">
            {!! Form::label('code', 'Code', ['class' => 'control-label']) !!}
            {!! Form::text('code', null, [
                'class' => 'form-control col-sm-3',
                'maxlength' => 8,
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

        <!-- Description -->
        <div class="form-group">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, [
                'class' => 'form-control'
            ]) !!}
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            {!! Form::button('Save', [
                'type' => 'submit',
                'class' => 'btn btn-primary',
            ]) !!}
        </div>

        {!! Form::close() !!}

    </div>

@endsection