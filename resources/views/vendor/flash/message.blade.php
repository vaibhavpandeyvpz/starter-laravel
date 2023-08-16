@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'title' => $message['title'],
            'body' => $message['message']
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} alert-dismissible @if ($message['important']) alert-important @endif" role="alert">
            {!! $message['message'] !!}
            @if ($message['important'])
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
            @endif
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
