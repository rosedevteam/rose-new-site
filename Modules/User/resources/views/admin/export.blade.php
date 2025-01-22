<table>
    <thead>
    <tr>
        <th>سازنده</th>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>موبایل</th>
        <th>ایمیل</th>
        <th>تاریخ تولد</th>
        <th>تاریخ عضویت</th>
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)

        <tr>
            <td>
                {{ $user->creator?->name() ?: "" }}
            </td>
            <td>
                {{ $user->first_name }}
            </td>
            <td>
                {{ $user->last_name }}
            </td>
            <td>
                {{$user->phone}}
            </td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->birthday }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>

    @endforeach
    </tbody>
</table>
