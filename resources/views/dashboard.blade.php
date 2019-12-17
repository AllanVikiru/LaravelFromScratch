@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p><a href="/posts/create" class="btn btn-primary btn-sm"> Create Post </a></p>
                    <p><h4> Your Blog Posts </h4></p>
                    @if (count($posts)>0)
                        <table class="table table-striped">
                            <tr>
                                <th> Title </th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td>
                                        <button class="btn btn-default btn-sm"
                                            onclick= "window.location.href='posts/{{$post->id}}/edit'">
                                            Edit
                                        </button>
                                        </td>
                                    <td>
                                        {{Form::open(['action' =>['PostsController@destroy', $post->id], 'method' => 'POST'])}}
                                        {{Form::hidden('_method', 'DELETE') }}
                                        {{Form::submit('Delete', ['class'=>'btn btn-default btn-sm'])}}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @else
                            <p> You have no posts </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
