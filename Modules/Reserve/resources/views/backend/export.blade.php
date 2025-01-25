<table>
    <thead>
    <tr>
        <th>نام و نام خانوادگی</th>
        <th>موبایل</th>
        <th>محصولات</th>
        <th>تاریخ رزرو</th>
    </tr>
    </thead>

    <tbody>
    @foreach($reserves as $reserve)

        <tr>
            <td>{{$reserve->name . ' ' . $reserve->lastname}}</td>
            <td>{{$reserve->phone}}</td>
            <td>
                @foreach($reserve->products as $product)
                    {{$product->title}},
                @endforeach
            </td>
            <td>
                {{\Hekmatinasser\Verta\Verta::instance($reserve->created_at)->formatJalaliDate()}}
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
