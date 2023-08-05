<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ __('Changes') }}</h5>
        <p class="card-text">{{ __('Below is change summary for this record.') }}</p>
    </div>
    <ul class="list-group list-group-flush border-top">
        <li class="list-group-item p-3">
            @include('partials.auditor-item', ['action' => __('Created'), 'auditor' => $model->createdBy])
        </li>
        <li class="list-group-item p-3">
            @include('partials.auditor-item', ['action' => __('Updated'), 'auditor' => $model->updatedBy])
        </li>
        @if (method_exists($model, 'trashed') && $model->trashed())
            <li class="list-group-item p-3">
                @include('partials.auditor-item', ['action' => __('Deleted'), 'auditor' => $model->deletedBy])
            </li>
        @endif
    </ul>
</div>
