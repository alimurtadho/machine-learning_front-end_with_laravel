<div class="card">
    <div class="card-header">
        Change Password
    </div>
    <form role="form" method="POST" action="{{ $user->path() }}/password" class="card-block">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group row{{ $errors->has('password') ? ' has-danger' : '' }}">
            <label for="password" class="col-md-12 form-control-label">Password</label>

            <div class="col-md-12">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-12 form-control-label">Confirm Password</label>

            <div class="col-md-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    Change Password
                </button>
            </div>
        </div>
    </form>
</div>