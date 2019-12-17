@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-primary btn-sm">Go Back</a>
<h1>{{$post->title}}</h1>
<div>
	{!! $post->body !!}
</div>

<hr>
<small>Written on {{$post->created_at}} by {{$post->user['name']}} </small>

<hr>
<a href="/posts/{{$post->id}}/edit" class="btn btn-primary btn-sm"> Edit </a>

<div style="float:right;">
{{Form::open(['action' =>['PostsController@destroy', $post->id], 'method' => 'POST'])}}
    {{Form::hidden('_method', 'DELETE') }}
    {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
{!! Form::close() !!}
</div>

@endsection
