<div class="container">
    <div class="row justify-content-md-center mt-3">
        <div class="col-{{ $colSize ?? '12' }}">
            <div class="card">
                <div class="card-header {{ $cardHeadingColor ?? 'bg-primary' }} {{ $cardHeadingTextColor ?? 'text-white' }}">{!! $cardTitle !!}</div>
                @if($cardNavigation ?? false)
                <div class="card-header {{ $cardNavigationColor ?? '' }} {{ $cardNavigationTextColor ?? '' }}">
                    {{ $cardNavigation ?? '' }}
                </div>
                @endif

                @if(trim($slot) != '')
                <div class="card-block">
                    {{ $slot }}
                </div>
                @endif

                {{ $block ?? '' }}
            </div>
        </div>
    </div>
</div>