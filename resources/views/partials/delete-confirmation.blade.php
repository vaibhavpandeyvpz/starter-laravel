<div class="modal" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}-label">{{ __('Confirmation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <p class="text-wrap">{{ $message ?? __('Do you really want to delete this?') }}</p>
            </div>
            <div class="modal-footer">
                <form action="{{ $action }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-light" data-bs-dismiss="modal" type="button">{{ __('Cancel') }}</button>
                    <button class="btn btn-danger"><i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
