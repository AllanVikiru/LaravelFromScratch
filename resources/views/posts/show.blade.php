@extends('layouts.app')

@section('content')
<button class="btn btn-primary btn-sm" onclick= "window.location.href='/posts'">
     Go Back
</button>
<h3>{{$post->title}}</h3>
<img style= "width: 100%" src="/storage/cover_images/{{$post->cover_image}}">
<br> <br>
<div>
	{!! $post->body !!}
</div>

<hr>
<small>Written on {{$post->created_at}} by {{$post->user['name']}} </small>

<hr>
@if (!Auth::guest()) <!--locks out unauthenticated users from editing and deleting posts -->
    @if (Auth::user()->id == $post->user_id)
    <!--limits editing and deleting to post owner -->
        <a href="/posts/{{$post->id}}/edit" class="btn btn-primary btn-sm"> Edit </a>

        <div style="float:right;">
        {{Form::open(['action' =>['PostsController@destroy', $post->id], 'method' => 'POST'])}}
            {{Form::hidden('_method', 'DELETE') }}
            {{Form::submit('Delete', ['class'=>'btn btn-danger btn-sm'])}}
        {!! Form::close() !!}
        </div>
     @endif
@endif
@endsection
