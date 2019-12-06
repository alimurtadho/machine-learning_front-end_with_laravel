<div class="navbar navbar-toggleable-md navbar-inverse bg-primary">
    <div class="container d-flex justify-content-between">
        <a href="/" class="navbar-brand">{{ config('app.name') }}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavigation">
            <ul class="navbar-nav">
                <li class="nav-item{{ request()->is('/') ? ' active' : '' }}">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item{{ request()->is('/') ? ' active' : '' }}">
                    <a class="nav-link" href="/predict/diabetes">Diabetes</a>
                </li>
                <!-- <li class="nav-item{{ request()->is('/') ? ' active' : '' }}">
                    <a class="nav-link" href="/predict/heart">Heart Disease</a>
                </li> -->
                <!-- <li class="nav-item{{ request()->is('news') ? ' active' : '' }}">
                    <a class="nav-link" href="/news">News</a>
                </li>
                <li class="nav-item{{ request()->is('datasets') ? ' active' : '' }}">
                    <a class="nav-link" href="/datasets">Datasets</a>
                </li>
                <li class="nav-item{{ request()->is('codes') ? ' active' : '' }}">
                    <a class="nav-link" href="/codes">Code</a>
                </li>
                <li class="nav-item{{ request()->is('discuss') ? ' active' : '' }}">
                    <a class="nav-link" href="/discuss">Discussions</a>
                </li> -->
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if (auth()->guest())
                    <!-- <li class="nav-item{{ request()->is('login') ? ' active' : '' }}"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item{{ request()->is('register') ? ' active' : '' }}"><a class="nav-link" href="{{ route('register') }}">Register</a></li> -->
                @else
                    <li class="nav-item dropdown">
                        <a href="javascript:;" class="nav-link dropdown-toggle" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="userMenu">
                            <a href="{{ auth()->user()->path() }}" class="dropdown-item">My Profile</a>
                            <a href="{{ auth()->user()->path() }}/edit" class="dropdown-item">Update Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form hidden id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>