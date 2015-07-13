@extends('layouts.default')

@section('content')
    <div class="jumbotron">
        <h1>Welcome to Larabook!</h1>
        <p>Welcome to the best place to talk about Laravel</p>
        <p>
            @if ( !$currentUser) <!--(Auth::guest())-->
                {{ link_to_route('register_path', 'Sign Up', null, ['class'=>'btn btn-lg btn-primary']) }}
            @endif
        </p>
    </div>
@stop
