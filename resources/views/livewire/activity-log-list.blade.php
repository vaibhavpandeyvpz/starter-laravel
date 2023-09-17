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
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="spinner-border spinner-border-sm float-end" role="status" wire:loading>
            <span class="visually-hidden">{{ __('Loading') }}&hellip;</span>
        </div>
        <h5 class="card-title">{{ __('History') }}</h5>
        <p class="card-text">{{ __('Recorded activities or changes to this record are listed below.') }}</p>
    </div>
    <div class="list-group list-group-flush border-top" x-data="activities">
        @forelse ($activities as $activity)
            @php
                $properties = $activity->properties['attributes'] ?? [];
            @endphp
            <div class="list-group-item p-3 list-group-item-activity list-group-item-activity-{{ $colors[$activity->description] ?? 'light' }}">
                <div class="d-flex align-top">
                    <div class="me-3">
                        @if ($activity->causer && $activity->causer->photo)
                            <img alt="{{ $activity->causer->name }}" height="32" src="{{ $activity->causer->photo_url }}">
                        @else
                            @include('partials.placeholder-image', ['width' => 32, 'height' => 32])
                        @endif
                    </div>
                    <div class="d-flex flex-column w-100">
                        <div class="d-flex justify-content-between @if (count($properties)) mb-1 @endif">
                            <span>
                                @if ($activity->causer && Gate::check('view', $activity->causer))
                                    <a href="{{ route('users.show', $activity->causer) }}">{{ $activity->causer->name }}</a>
                                @elseif ($activity->causer)
                                    {{ $activity->causer->name }}
                                @else
                                    <span class="text-muted">{{ __('System') }}</span>
                                @endif
                                {{ __(':action this record.', ['action' => $activity->description]) }}
                            </span>
                            <abbr data-bs-toggle="tooltip" title="{{ Timezone::convertToLocal($activity->created_at) }}">{{ $activity->created_at->diffForHumans() }}</abbr>
                        </div>
                        @if (count($properties))
                            <p class="mb-0">
                                <a class="text-body" href="" @click.prevent="expand({{ $activity->getKey() }})">
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
            <div class="list-group-item p-3" x-show="expanded === {{ $activity->getKey() }}" x-collapse>
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
                            <td colspan="2">{{ __('…and :count hidden.', ['count' => $skipped]) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="list-group-item p-3 disabled text-center" aria-disabled="true">
                {{ __('No activities recoded yet.') }}
            </div>
        @endforelse
    </div>
    @if ($activities->hasPages())
        <div class="card-body">
            {{ $activities->links() }}
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', function () {
            Alpine.data('activities', () => ({
                expanded: false,

                expand(id) {
                    this.expanded = this.expanded !== id ? id : false;
                },
            }));
        });
    </script>
@endpush
