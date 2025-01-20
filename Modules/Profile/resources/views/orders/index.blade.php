@extends("profile::layouts.main")

@section('content')

    <div class="panel-title-box d-flex justify-content-between flex-column flex-sm-row align-items-sm-center">
        <h4 class="breadcrumb-wrapper">
            <span class="text-muted fw-light">حساب کاربری /</span> سفارش های من
        </h4>

    </div>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>شماره سفارش</th>
                    <th>تاریخ</th>
                    <th>مبلغ</th>
                    <th>وضعیت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($orders as $order)
                    <tr>
                        <td>#{{$order->id}}</td>
                        <td>{{Verta::instance($order->created_at)->formatJalaliDate()}}</td>
                        <td>
                            {{number_format($order->price)}}
                            تومان
                        </td>
                        <td>
                            @switch($order->status)
                                @case('completed')
                                    <span class="badge bg-success">تکمیل شده</span>
                                @break
                                @case('pending')
                                    <span class="badge bg-info">در حال انجام</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">لغو شده</span>
                                    @break
                                @case('returned')
                                    <span class="badge bg-secondary">عودت داده شده</span>
                                    @break
                            @endswitch

                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
@stop
