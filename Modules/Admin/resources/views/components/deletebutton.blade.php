@can('delete-' . $model)
    <button class="btn btn-sm btn-danger" data-bs-target="#delete-modal" data-bs-toggle="modal" {{ $attributes }}
    id="delete-button">
        حذف
    </button>
@endcan
