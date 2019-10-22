@extends('layouts.app')

@section('title')
    Reset Password
@endsection

@section('content')
    @component('layouts.card', [
        'cardTitle' => 'Reset Password',
        'colSize' => 8
    ])
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form role="form" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                <label for="email" class="col-4 col-form-label text-right">E-Mail Address</label>

                <div class="col-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
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

            <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                <label for="password-confirm" class="col-4 form-control-label text-right">Confirm Password</label>
                <div class="col-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <p class="form-text text-muted text-danger">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </p>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection