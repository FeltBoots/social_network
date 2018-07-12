@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="border-radius: 40px;">

                <div class="panel-heading" style="border-top-left-radius: 40px; border-top-right-radius: 40px;">Update profile</div>

                @include('includes.message-block')

                <form method="post" action="/profile/update">

                    <div class="form-group hidden">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                    </div>

                    <div class="panel-body">
                        <label for="name" class="col-md-2 control-label">Name</label>
                        <input type="text" name="name" class="col-md-5" value="{{ Auth::user()->name }}" />
                    </div>

                    <div class="panel-body">
                        <label for="name" class="col-md-2 control-label">Email</label>
                        <input type="email" name="email" class="col-md-5" value="{{ Auth::user()->email }}" />
                    </div>

                    <div class="panel-body">
                        <label for="name" class="col-md-2 control-label">Password</label>
                        <input type="password" class="col-md-5" name="password" />
                    </div>

                    <div class="panel-body">
                        <div>
                            <label for="name" class="col-md-2 control-label">Confirm</label>
                            <input type="password" class="col-md-5" name="password_confirmation" />
                        </div>
                    </div>

                    <div class="panel-body">
                        <label for="birthday" class="col-md-2 control-label">Date of birth</label>
                        <div class="form-inline left form-inline">
                            <div>
                                {{ Form::selectRange('date_of_birth[day]', 1, 31, null, ['class' => 'form-control']) }}
                                {{ Form::selectMonth('date_of_birth[month]', null, ['class' => 'form-control'])}}
                                {{ Form::selectYear('date_of_birth[year]', date('Y'), date('Y') - 100, null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <input type="submit" class="btn btn-sm btn-primary button-submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection