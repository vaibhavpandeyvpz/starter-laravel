@php
    $colors = [
        'created' => 'success',
        'updated' => 'warning',
        'deleted' => 'danger',
    ];
    $hidden = [
        'password',
        'remember_token',

        'created_at',
        'updated_at',
    ];
@endphp
<div class="card shadow-sm">
    <div class="card-body">
        <div class="spinner-border spinner-border-sm float-right" role="status" wire:loading>
            <span class="sr-only">{{ __('Loading') }}&hellip;</span>
        </div>
        <h5 class="card-title text-primary">{{ __('History') }}</h5>
        <p class="card-text">{{ __('Below is a list of all actions ever performed on this record.') }}</p>
    </div>
    <div class="list-group list-group-flush">
        @forelse ($activities as $activity)
            @php
                $properties = $activity->properties['attributes'] ?? [];
            @endphp
            <div class="list-group-item list-group-item-activity list-group-item-activity-{{ $colors[$activity->description] ?? 'light' }}">
                <div class="media">
                    <div class="align-self-center mr-3">
                        @if ($activity->causer && $activity->causer->photo)
                            <img alt="{{ $activity->causer->name }}" class="rounded" height="32" src="{{ $activity->causer->photo_url }}">
                        @else
                            @include('partials.placeholder', [
                                'class' => 'rounded',
                                'width' => 32,
                                'height' => 32,
                            ])
                        @endif
                    </div>
                    <div class="media-body">
                        <div class="d-flex w-100 justify-content-between @if (count($properties)) mb-1 @endif">
                            <span>
                                @if ($activity->causer && Gate::check('view', $activity->causer))
                                    <a href="{{ route('backend.users.show', $activity->causer) }}">{{ $activity->causer->name }}</a>
                                @elseif ($activity->causer)
                                    {{ $activity->causer->name }}
                                @else
                                    <span class="text-muted">{{ __('Unknown') }}</span>
                                @endif
                                {{ __(':action this record.', ['action' => $activity->description]) }}
                            </span>
                            <abbr data-toggle="tooltip" title="{{ Timezone::convertToLocal($activity->created_at) }}">{{ $activity->created_at->diffForHumans() }}</abbr>
                        </div>
                        @if (count($properties))
                            <p class="mb-0">
                                <a class="text-body" href="" wire:click.prevent="toggle({{ $activity->id }})">
                                    {{ __(':count properties were added or changed.', ['count' => count($properties)]) }}
                                </a>
                            </p>
                        @else
                            <p class="mb-0">
                                {{ __(':count properties were added or changed.', ['count' => 0]) }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            @if ($expanded === $activity->id)
                <div class="list-group-item bg-light p-3">
                    <div class="table-responsive">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                            @php
                                $skipped = 0;
                            @endphp
                            @foreach ($properties as $key => $value)
                                @php
                                    if (in_array($key, $hidden)) {
                                        $skipped++;
                                        continue;
                                    }

                                    $column = ucfirst(implode(' ', explode('_', $key)));
                                    $column = str_replace('Id', 'ID', $column);
                                @endphp
                                <tr>
                                    <th>{{ $column }}</th>
                                    <td class="text-wrap w-100">
                                        @if (is_array($value))
                                            {{ __(':count Item(s)', ['count' => count($value)]) }}
                                        @elseif (is_bool($value))
                                            {{ $value ? 'Yes' : 'No' }}
                                        @elseif (is_string($value))
                                            @if (mb_strlen($value) > 50)
                                                {{ mb_substr($value, 0, 50) }}&hellip;
                                            @elseif (empty($value))
                                                <span class="text-muted">{{ __('Empty') }}</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        @elseif (is_null($value))
                                            <span class="text-muted">{{ __('Empty') }}</span>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">{{ __('… and :count hidden.', ['count' => $skipped]) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @empty
            <div class="list-group-item disabled text-center" aria-disabled="true">
                {{ __('No activities yet.') }}
            </div>
        @endforelse
    </div>
    @if ($activities->hasPages())
        <div class="card-body">
            {{ $activities->links('partials.pagination') }}
        </div>
    @endif
</div>
