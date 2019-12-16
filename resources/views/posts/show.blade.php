@extends('layouts.app')

@section('content')
<h1>{{$post->title}}</h1>
<a href="/posts" class="btn btn-default">Go Back</a>

<div>
	{{$post->body}}
</div>
<hr>
<small>Written on {{$post->created_at}}</small>
</hr>
@endsection