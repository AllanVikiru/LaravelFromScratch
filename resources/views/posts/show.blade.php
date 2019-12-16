@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-primary">Go Back</a>
<h1>{{$post->title}}</h1>
<div>
	{!! $post->body !!}
</div>

<hr>
<small>Written on {{$post->created_at}}</small>

<hr>
<a href="/posts/{{$post->id}}/edit" class="btn btn-primary"> Edit </a>

<div style="float:right;">
{{Form::open(['action' =>['PostsController@destroy', $post->id], 'method' => 'POST'])}}
    {{Form::hidden('_method', 'DELETE') }}
    {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
{!! Form::close() !!}
</div>

@endsection
