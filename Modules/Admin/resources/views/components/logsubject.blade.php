@php
    $type = strtolower(substr(strrchr($log->subject_type, '\\'), 1));
@endphp
<td>
    @if(!is_null($log->subject))
    <a href="{{ route('admin.' . $type . 's.show', $log->subject) }}" class="text-body text-truncate">
        <span class="fw-semibold">{{ $log->subject }}</span>
    </a>
    @endif
</td>
