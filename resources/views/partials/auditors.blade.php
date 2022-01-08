<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title text-primary">{{ __('Logs') }}</h5>
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
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <span>{{ __('Created') }}</span>
                        <span class="text-muted">{{ $model->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mb-0">
                        @if ($model->createdBy && Gate::check('view', $model->createdBy))
                            <a href="{{ route('backend.users.show', $model->createdBy) }}">{{ $model->createdBy->name }}</a>
                        @elseif ($model->createdBy)
                            {{ $model->createdBy->name }}
                        @else
                            {{ __('Unknown') }}
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
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <span>{{ __('Updated') }}</span>
                        <span class="text-muted">{{ $model->updated_at->diffForHumans() }}</span>
                    </div>
                    <p class="mb-0">
                        @if ($model->updatedBy && Gate::check('view', $model->updatedBy))
                            <a href="{{ route('backend.users.show', $model->updatedBy) }}">{{ $model->updatedBy->name }}</a>
                        @elseif ($model->updatedBy)
                            {{ $model->updatedBy->name }}
                        @else
                            {{ __('Unknown') }}
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
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <span>{{ __('Deleted') }}</span>
                            <span class="text-muted">{{ $model->deleted_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-0">
                            @if ($model->deletedBy && Gate::check('view', $model->deletedBy))
                                <a href="{{ route('backend.users.show', $model->deletedBy) }}">{{ $model->deletedBy->name }}</a>
                            @elseif ($model->deletedBy)
                                {{ $model->deletedBy->name }}
                            @else
                                {{ __('Unknown') }}
                            @endif
                        </p>
                    </div>
                </div>
            </li>
        @endif
    </ul>
</div>
