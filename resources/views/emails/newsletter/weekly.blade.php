@component('mail::message')
# Popular This Week at {{ config('app.name') }}

@foreach($twitterFeeds as $feed)
@component('mail::panel')
    ## [{{ $feed->author_name }}](https://twitter.com/{{ $feed->author_screen_name }})
    {{ $feed->body }}
@endcomponent
@endforeach

@component('mail::button', ['url' => url('/news')])
Read More
@endcomponent

@endcomponent
