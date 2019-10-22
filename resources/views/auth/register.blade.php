@extends('layouts.app')

@section('title')
    Register
@endsection

@section('content')
    @component('layouts.card', [
        'pageTitle' => 'Register',
        'cardTitle' => 'Register',
        'colSize' => 8
    ])
        <form role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-4 form-control-label text-right">Name</label>

                <div class="col-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('username') ? ' has-danger' : '' }}">
                <label for="username" class="col-4 form-control-label text-right">Username</label>

                <div class="col-6">
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                    @if ($errors->has('username'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('username') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                <label for="email" class="col-4 form-control-label text-right">E-Mail Address</label>

                <div class="col-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="password" class="col-4 form-control-label text-right">Password</label>

                <div class="col-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-4 form-control-label text-right">Confirm Password</label>

                <div class="col-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6 offset-4">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        Already have an account?
                    </a>
                </div>
            </div>
        </form>
    @endcomponent
@endsection