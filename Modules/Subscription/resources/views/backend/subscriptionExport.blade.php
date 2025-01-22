<table>
    <thead>
    <tr>
        <th>نام</th>
        <th>توضیحات</th>
        <th>تاریخ انقضا</th>
    </tr>
    </thead>
    <tbody>

    @foreach($subs as $sub)
        <tr>
            <td>{{$sub->name}}</td>
            <td>{{$sub->description}}</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($sub->created_at)->formatJalaliDate()}}</td>
        </tr>
    @endforeach

    </tbody>
</table>
