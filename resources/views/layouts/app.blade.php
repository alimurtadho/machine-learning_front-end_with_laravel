<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name') }}</title>

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @stack('styles')

    <script>
        window.AIMED = {!! json_encode([
            'csrfToken' => csrf_token(),
            'userId' => auth()->check() ? auth()->id() : null,
        ]) !!};
    </script>
</head>

<body>
    @include('layouts._nav')

    @yield('content')

    @include('layouts._footer')

    <script src="{{ mix('/js/app.js') }}"></script>

    @stack('scripts')
    @include('layouts._errors')
</body>
</html>
