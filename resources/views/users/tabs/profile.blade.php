<div class="card">
    <div class="card-header">
        Basic Information
    </div>
    <form role="form" method="POST" action="{{ $user->path() }}/edit" class="card-block">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label for="name" class="col-md-12 form-control-label">Name</label>

            <div class="col-md-12">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>

                @if ($errors->has('name'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('name') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('username') ? ' has-danger' : '' }}">
            <label for="username" class="col-md-12 form-control-label">Username</label>

            <div class="col-md-12">
                <input id="username" type="text" class="form-control" name="username" value="{{ $user->username }}" disabled>
            </div>
        </div>

        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
            <label for="email" class="col-md-12 form-control-label">E-Mail Address</label>

            <div class="col-md-12">
                <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" disabled>
            </div>
        </div>

        <div class="form-group row{{ $errors->has('dob') ? ' has-danger' : '' }}">
            <label for="dob" class="col-md-12 form-control-label">Date Of Birth</label>

            <div class="col-md-12">
                <input id="dob" type="date" class="form-control" name="dob" value="{{ old('dob', $user->dob) }}">

                @if ($errors->has('dob'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('occupation') ? ' has-danger' : '' }}">
            <label for="occupation" class="col-md-12 form-control-label">Occupation</label>

            <div class="col-md-12">
                <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation', $user->occupation) }}">

                @if ($errors->has('occupation'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('occupation') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('organization') ? ' has-danger' : '' }}">
            <label for="organization" class="col-md-12 form-control-label">Organization</label>

            <div class="col-md-12">
                <input id="organization" type="text" class="form-control" name="organization" value="{{ old('organization', $user->organization) }}">

                @if ($errors->has('organization'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('organization') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('github_username') ? ' has-danger' : '' }}">
            <label for="github_username" class="col-md-12 form-control-label">Github Username</label>

            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-github"></i></span>
                    <input id="github_username" type="text" class="form-control" name="github_username" value="{{ old('github_username', $user->github_username) }}">
                </div>

                @if ($errors->has('github_username'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('github_username') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('linkedin_username') ? ' has-danger' : '' }}">
            <label for="linkedin_username" class="col-md-12 form-control-label">LinkedIn Username</label>

            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                    <input id="linkedin_username" type="text" class="form-control" name="linkedin_username" value="{{ old('linkedin_username', $user->linkedin_username) }}">
                </div>

                @if ($errors->has('linkedin_username'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('linkedin_username') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('website') ? ' has-danger' : '' }}">
            <label for="website" class="col-md-12 form-control-label">Website URL</label>

            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input id="website" type="text" class="form-control" name="website" value="{{ old('website', $user->website) }}">
                </div>

                @if ($errors->has('website'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('website') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="newsletter" value="1" {{ old('newsletter', $user->newsletter) ? 'checked' : '' }}> Subscribe to Newsletter
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"> </i> Save
                </button>
            </div>
        </div>
    </form>
</div>