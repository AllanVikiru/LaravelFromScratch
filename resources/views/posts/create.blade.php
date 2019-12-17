@extends('layouts.app')

@section('content')
<h1>Create Post</h1>
    {!! Form::open(['action' => 'PostsController@store' , 'method' => 'POST']) !!}
        <div class="form-group">
	        {{Form::label('title', 'Title')}}
	        {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '' , ['id' => 'ckeditor', 'class' => 'form-control', 'placeholder' => 'Body'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
    {!! Form::close() !!}
@endsection

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor' );
    </script>
