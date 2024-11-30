@php
    $type = strtolower(substr(strrchr($log->subject_type, '\\'), 1));
@endphp
<td>
    <a href="{{ route('admin.' . $type . '.show', $log->subject_id) }}">
        <span class="fw-semibold">{{ $log->subject }}</span>
    </a>
</td>
