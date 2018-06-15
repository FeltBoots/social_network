@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <img src="/uploads/avatars/{{ $user->avatar }}" style="width:15%; height:100%; float:left; border-radius:50%; margin-right:25px;">
                <h2> {{ $user->name }} </h2>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Name</label>
                            <label class="col-md-6">{{ Auth::user()->name }}</label>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Email</label>
                            <label class="col-md-6">{{ Auth::user()->email }}</label>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Born</label>
                            <label class="col-md-6">{{ Auth::user()->date_of_birth }}</label>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form enctype="multipart/form-data" action="/profile" method="POST">
                            <label> Update profile image </label>
                            <input type="file" name="avatar" style="color: transparent;">
                            {{--<input type="file" class="pull-right" name="avatar">--}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="pull-right btn  btn-sm btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
