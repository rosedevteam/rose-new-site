@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger" style="padding-right: 80px">{{ $errors->first() }}</div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="col d-flex justify-content-between">
                        <div>
                            <h5 class="card-title me-2" style="display: inline">تراکنش های کیف پول</h5>
                            <a href="{{ route('admin.users.edit', $wallet->user) }}"
                               class="h5">{{ $wallet->user->name() }}</a>
                            <h5 class="mt-2">موجودی {{ number_format($wallet->balance) }} تومان</h5>
                        </div>
                        <button class="btn btn-primary my-3" data-bs-target="#create-transaction-modal"
                                data-bs-toggle="modal">افزایش اعتبار
                        </button>
                    </div>
                </div>
                <div class="table-responsive mb-3">
                    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="table datatable-invoice border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info"
                               style="width: 100%;">
                            <thead>
                            <tr>
                                <th tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                    style="width: 2%;">نوع
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1"
                                    colspan="1" style="width: 3%;">مقدار
                                </th>
                                <th class="sorting sorting_desc" tabindex="0"
                                    aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" style="width: 20%;">توضیحات
                                </th>
                                <th class="control sorting dtr-hidden" tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                    style="width: 5%;">تاریخ تراکنش
                                </th>
                                @can('edit-wallet-transactions')
                                    <th class="control sorting dtr-hidden" tabindex="0"
                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"
                                        style="width: 5%;">ویرایش
                                    </th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        @if($transaction->order)
                                            <a href="{{  route("admin.orders.edit", $transaction->order)  }}"
                                               class="text-body">@endif
                                                @switch($transaction->type)
                                                    @case('debit')<span class="badge bg-danger">کسر اعتبار</span>@break
                                                    @case('credit')<span
                                                        class="badge bg-success">افزایش اعتبار</span>@break
                                                @endswitch
                                                @if($transaction->order)</a>
                                        @endif
                                    </td>
                                    <td>{{ number_format($transaction->amount) }} تومان</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ verta($transaction->created_at)->formatJalaliDatetime() }}</td>
                                    @can('edit-wallet-transactions')
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                    data-amount="{{ $transaction->amount }}"
                                                    data-type="{{ $transaction->type }}"
                                                    data-description="{{ $transaction->description }}"
                                                    id="edit-transaction-button"
                                                    data-bs-target="#edit-transaction-modal"
                                                    data-bs-toggle="modal"
                                                    data-route="{{ route('admin.wallettransactions.update', $transaction) }}">
                                                ویرایش
                                            </button>
                                            @can('delete-wallet-transactions')
                                                <x-admin::deletebutton data-id="{{ $transaction->id }}"/>
                                            @endcan
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
            <x-admin::deletemodal/>
            @can('create-wallet-transactions')

                <div class="modal fade" id="create-transaction-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center mb-4 mt-0 mt-md-n2">
                                    <h3 class="secondary-font">ساخت تراکنش</h3>
                                </div>
                                <form action="{{ route('admin.wallettransactions.store') }}"
                                      method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="amount">مقدار</label>
                                            <input type="text" id="amount" name="amount"
                                                   class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="type">نوع</label>
                                            <select class="form-select" name="type" id="type">
                                                <option value="credit" selected>افزایش اعتبار</option>
                                                <option value="debit">کسر اعتبار</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="form-label" for="description">توضیحات</label>
                                    <textarea id="description" class="form-control" name="description"></textarea>
                                    <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-label-primary me-sm-3 me-1">ثبت
                                        </button>
                                        <button type="reset" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal"
                                                aria-label="close">
                                            انصراف
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('edit-wallet-transactions')
                <div class="modal fade" id="edit-transaction-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center mb-4 mt-0 mt-md-n2">
                                    <h3 class="secondary-font">ساخت تراکنش</h3>
                                </div>
                                <form id="edit-transaction-form" action="" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="edit-amount">مقدار</label>
                                            <input type="text" id="edit-amount" name="amount"
                                                   class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="edit-type">نوع</label>
                                            <select class="form-select" name="type" id="edit-type">
                                                <option value="credit">افزایش اعتبار</option>
                                                <option value="debit">کسر اعتبار</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="form-label" for="edit-description">توضیحات</label>
                                    <textarea id="edit-description" class="form-control"
                                              name="description"></textarea>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-label-primary me-sm-3 me-1">ثبت
                                        </button>
                                        <button type="reset" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal"
                                                aria-label="close">
                                            انصراف
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="content-backdrop fade"></div>
    </div>

@endsection

@push('vendor')
    <script src="/assets/admin/vendor/libs/moment/moment.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/admin/vendor/libs/datatables-bs5/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/select2/select2.js"></script>
    <script src="/assets/admin/vendor/libs/select2/i18n/fa.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="/assets/admin/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave.js"></script>
    <script src="/assets/admin/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="/assets/admin/js/autonumeric/autonumeric.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', (event) => {
                if (event.target.matches('#edit-transaction-button')) {
                    const route = event.target.getAttribute('data-route');
                    const amount = event.target.getAttribute('data-amount');
                    const type = event.target.getAttribute('data-type');
                    const description = event.target.getAttribute('data-description');
                    document.getElementById('edit-amount').value = amount;
                    document.getElementById('edit-type').value = type;
                    document.getElementById('edit-description').value = description;
                    document.getElementById('edit-transaction-form').action = route;
                }
                if (event.target.matches('#delete-button')) {
                    const id = event.target.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `/kara-fa/wallettransactions/${id}`;
                    //todo admin panel prefix is hardcoded in js
                }
            });
            const amount = new AutoNumeric('#amount', {
                digitGroupSeparator: ',',
                minimumValue: '0',
                unformatOnSubmit: true,
                decimalPlaces: 0,
            });
            const editAmount = new AutoNumeric('#edit-amount', {
                digitGroupSeparator: ',',
                minimumValue: '0',
                unformatOnSubmit: true,
                decimalPlaces: 0,
            });
        });
    </script>
@endpush
