@php
    switch(substr(strrchr($log->subject_type, '\\'), 1)) {
    case 'Post': $type = 'posts';
    case 'User': $type = 'users';
    case 'JobApplication': $type = 'jobapplications';
    case 'JobOffer': $type = 'joboffers';
    case 'Comment': $type = 'comments';
    case 'Category': $type = 'categories';
    case 'DailyReports': $type = 'dailyreports';
    case 'Products': $type = 'products';
    case 'Menu': $type = 'menus';
    case 'Order': $type = 'orders';
    case 'Metadata': $type = 'metadatas';
    case 'Discount': $type = 'discounts';
    }
@endphp
<td>
    @if(!is_null($log->subject))
    <a href="{{ route('admin.' . $type . '.show', $log->subject) }}" class="text-body text-truncate">
        <span class="fw-semibold">{{ $log->subject }}</span>
    </a>
    @endif
</td>
