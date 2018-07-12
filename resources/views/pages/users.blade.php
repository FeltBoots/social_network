@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($users as $user)
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="{{ url('profile/' . $user->id) }}"> {{ ($user->name) }}</a>
                        </div>

                        <div class="panel-body">
                            <img src="/uploads/avatars/{{ $user->avatar }}" class="user-avatar">
                            <div class="panel-body">
                                <label> {{ $user->email  }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection


