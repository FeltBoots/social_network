@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <img src="/uploads/avatars/{{ $user->avatar }}" class="user-avatar">
                <h2> {{ $user->name }} </h2>
                <form enctype="multipart/form-data" action="/profile" method="POST">
                    {{--<input type="file" class="pull-right" name="avatar">--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @if (Auth::user() && $user->id == Auth::user()->id)
                        <label for="upload"> Update profile image </label>
                        <input type="file" name="avatar" accept="image/png, image/jpeg" style="color: transparent;">
                        <input type="submit" class="btn btn-sm btn-primary button-submit m-t-submit" value="update avatar">
                        @if ($errors->has('avatar'))
                            <span class="help-block">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default" style="border-radius: 20px;">

                    {{--<div class="panel-body">--}}
                        {{--<div>--}}
                            {{--<label for="name" class="col-md-2 control-label">Name</label>--}}
                            {{--<label class="col-md-6">{{ $user->name }}</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Email</label>
                            <label class="col-md-6">{{ $user->email }}</label>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Born</label>
                            <label class="col-md-6">{{ $user->date_of_birth }}</label>
                        </div>
                    </div>


                    @if (Auth::user() && $user->id == Auth::user()->id)
                        <div class="panel-body">
                            <div>
                                <input type="submit" class="btn btn-sm btn-primary button-submit" value="edit profile"
                                       onclick="location.href='{{ url('edit') }}'">
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            @include('includes.message-block')
            <header><h3>What do you have to say?</h3></header>
            <form action="{{ route('post.create') }}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Yout post"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create post</button>
                <input type="hidden" value="{{ csrf_token() }}" name="_token">
            </form>
        </div>
    </section>
@endsection
