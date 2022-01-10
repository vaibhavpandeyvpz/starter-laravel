<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title text-primary">{{ __('Changes') }}</h5>
        <p class="card-text">{{ __('Below are the recent changes made to this record.') }}</p>
    </div>
    <ul class="list-group list-group-flush border-top">
        <li class="list-group-item">
            <div class="media">
                <div class="align-self-center mr-3">
                    @if ($model->createdBy && $model->createdBy->photo)
                        <img alt="{{ $model->createdBy->name }}" class="rounded" height="32" src="{{ $model->createdBy->photo_url }}">
                    @else
                        @include('partials.placeholder', [
                            'class' => 'rounded',
                            'width' => 32,
                            'height' => 32,
                        ])
                    @endif
                </div>
                <div class="media-body">
                    <p class="mb-1">
                        {{ __('Created') }} <abbr data-toggle="tooltip" title="{{ Timezone::convertToLocal($model->created_at) }}">{{ $model->created_at->diffForHumans() }}</abbr>
                    </p>
                    <p class="mb-0">
                        @if ($model->createdBy && Gate::check('view', $model->createdBy))
                            <a href="{{ route('backend.users.show', $model->createdBy) }}">{{ $model->createdBy->name }}</a>
                        @elseif ($model->createdBy)
                            {{ $model->createdBy->name }}
                        @else
                            <span class="text-muted">{{ __('Unknown') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="media">
                <div class="align-self-center mr-3">
                    @if ($model->updatedBy && $model->updatedBy->photo)
                        <img alt="{{ $model->updatedBy->name }}" class="rounded" height="32" src="{{ $model->updatedBy->photo_url }}">
                    @else
                        @include('partials.placeholder', [
                            'class' => 'rounded',
                            'width' => 32,
                            'height' => 32,
                        ])
                    @endif
                </div>
                <div class="media-body">
                    <p class="mb-1">
                        {{ __('Updated') }} <abbr data-toggle="tooltip" title="{{ Timezone::convertToLocal($model->updated_at) }}">{{ $model->updated_at->diffForHumans() }}</abbr>
                    </p>
                    <p class="mb-0">
                        @if ($model->updatedBy && Gate::check('view', $model->updatedBy))
                            <a href="{{ route('backend.users.show', $model->updatedBy) }}">{{ $model->updatedBy->name }}</a>
                        @elseif ($model->updatedBy)
                            {{ $model->updatedBy->name }}
                        @else
                            <span class="text-muted">{{ __('Unknown') }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </li>
        @if ($model->trashed)
            <li class="list-group-item">
                <div class="media">
                    <div class="align-self-center mr-3">
                        @if ($model->deletedBy && $model->deletedBy->photo)
                            <img alt="{{ $model->deletedBy->name }}" class="rounded" height="32" src="{{ $model->deletedBy->photo_url }}">
                        @else
                            @include('partials.placeholder', [
                                'class' => 'rounded',
                                'width' => 32,
                                'height' => 32,
                            ])
                        @endif
                    </div>
                    <div class="media-body">
                        <p class="mb-1">
                            {{ __('Deleted') }} <abbr data-toggle="tooltip" title="{{ Timezone::convertToLocal($model->deleted_at) }}">{{ $model->deleted_at->diffForHumans() }}</abbr>
                        </p>
                        <p class="mb-0">
                            @if ($model->deletedBy && Gate::check('view', $model->deletedBy))
                                <a href="{{ route('backend.users.show', $model->deletedBy) }}">{{ $model->deletedBy->name }}</a>
                            @elseif ($model->deletedBy)
                                {{ $model->deletedBy->name }}
                            @else
                                <span class="text-muted">{{ __('Unknown') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endif
    </ul>
</div>
