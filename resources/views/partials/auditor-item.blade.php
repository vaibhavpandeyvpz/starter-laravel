<div class="d-flex align-top">
    <div class="me-3">
        @if ($auditor && $auditor->photo)
            <img alt="{{ $auditor->name }}" height="32" src="{{ $auditor->photo_url }}">
        @else
            @include('partials.placeholder-image', ['width' => 32, 'height' => 32])
        @endif
    </div>
    <div class="d-flex flex-column w-100">
        <h6 class="mb-1">
            {{ $action }} <abbr data-bs-toggle="tooltip" title="{{ Timezone::convertToLocal($model->created_at) }}">{{ $model->created_at->diffForHumans() }}</abbr>
        </h6>
        <p class="mb-0">
            @if ($auditor && Gate::check('view', $auditor))
                <a href="{{ route('users.show', $auditor) }}">{{ $auditor->name }}</a>
            @elseif ($auditor)
                {{ $auditor->name }}
            @else
                <span class="text-muted">{{ __('System') }}</span>
            @endif
        </p>
    </div>
</div>
