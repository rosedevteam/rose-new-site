<table>
    <thead>
    <tr>
        <th>نام و نام خانوادگی</th>
        <th>موبایل</th>
        <th>آیدی</th>
        <th>مدت زمان</th>
        <th>تاریخ شروع</th>
        <th>تاریخ پایان</th>
        <th>اس ام اس یادآوری</th>
        <th>وضعیت</th>
        <th>توضیحات</th>
    </tr>
    </thead>
    <tbody>
    @foreach($telegrams as $telegram)

        <tr>
            <td>
                {{$telegram->fullname}}
                <small class="emp_post text-truncate text-muted"></small>
            </td>
            <td>
                {{$telegram->phone}}
            </td>
            <td>{{$telegram->telegram_id}}</td>
            <td>{{$telegram->duration}}</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($telegram->start_date)->formatJalaliDate()}}</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($telegram->end_date)->formatJalaliDate()}}</td>
            <td>
                @switch($telegram->is_notified)
                    @case(1)
                        ارسال شده
                        @break
                    @case(0)
                        ارسال نشده
                        @break
                @endswitch
            </td>
            <td>
                @switch($telegram->is_deleted)
                    @case(1)
                        <div class="d-flex flex-column">
                            تاریخ حذف:
                            {{\Hekmatinasser\Verta\Verta::instance($telegram->deleted_date)->formatJalaliDate()}}حذف شده
                            -
                        </div>

                        @break
                    @case(0)
                        عضو
                        @break
                @endswitch
            </td>
            <td>{{$telegram->desc}}</td>
        </tr>
    @endforeach

    </tbody>
</table>
