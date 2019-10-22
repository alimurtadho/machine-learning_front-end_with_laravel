@extends('layouts.app')

@section('title')
    Login
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Login',
        'colSize' => 8
    ])
        <form role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group row{{ $errors->has('username') ? ' has-danger' : '' }}">
                <label for="username" class="col-4 col-form-label text-right">Username</label>

                <div class="col-6">
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('username') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="password" class="col-4 col-form-label text-right">Password</label>

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
                <div class="col-6 offset-4">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>
                <div class="offset-4 col-sm-8">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div>
            </div>
        </form>
    @endcomponent
@endsection