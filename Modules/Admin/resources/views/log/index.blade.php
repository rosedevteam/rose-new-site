@extends('admin::layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="flex-grow-1 p-3y">
            <div class="card mx-4">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.logs.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                            <div class="col-md-3">
                                <label for="count" class="form-label">جستجو: </label>
                                <div id="search" class="search-input">
                                    <input type="search" name="search" value="{{ $search }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_direction" class="form-label">نوع ترتیب: </label>
                                <select id="sort_direction" name="sort_direction" class="form-select text-capitalize">
                                    <option value="desc" selected>نزولی</option>
                                    <option value="asc" {{ $sort_direction == 'asc' ? 'selected' : '' }}>صعودی</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="count" class="form-label">تعداد: </label>
                                <select id="count" name="count" class="form-select text-capitalize">
                                    <option value="50" selected>50</option>
                                    <option value="100" {{ $count == "100" ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="submit" type="submit" class="btn btn-primary mt-4 data-submit">جستجو
                                </button>
                            </div>
                            @if(auth()->user()->hasRole('super-admin'))
                                <div class="col-md-2 mx-4">
                                    <button type="button" class="btn btn-danger mt-4" data-bs-target="#delete-modal"
                                            data-bs-toggle="modal">حذف همه
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 12%" aria-sort="ascending">توضیحات
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 12%;">توسط
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">تاریخ
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 1%;">عملیات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $log->description }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                <span class="fw-semibold">
                                    <a href="{{ route('admin.users.edit', $log->causer) }}"
                                       class="text-truncate text-body">
                                    {{ $log->causer->name() }}</a>
                                </span>
                                    </td>
                                    <td>{{ verta($log->created_at)->formatJalaliDateTime() }}</td>
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            <button class="btn btn-sm btn-primary" id="details-button"
                                                    data-bs-target="#details" data-bs-toggle="modal"
                                                    data-log-id="{{ $log->id }}"
                                                    data-description="{{ $log->description }}"
                                                    data-route="{{ getEditRouteByType($log->subject_type, $log->subject_id) }}"
                                                    data-subject-name="{{ getModelTitleByType($log->subject_type, $log->subject_id) }}"
                                                    data-causer-route="{{ route('admin.users.edit', $log->causer) }}"
                                                    data-causer-name="{{ $log->causer->name() }}"
                                                    data-properties="{{ $log->properties }}"
                                                    data-created-at="{{ verta($log->created_at)->formatJalaliDatetime() }}"
                                            >جزییات
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
            <div class="modal fade" id="details" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="causer">توسط: </label>
                                    <a href="" class="text-body" id="causer-ref">
                                        <span id="causer"></span></a>
                                </div>
                                <div class="col mb-3">
                                    <label for="created_at">تاریخ: </label>
                                    <span id="created_at"></span>
                                </div>
                            </div>
                            <div class="row" id="route-div" hidden>
                                <div class="col mb-3">
                                    <label for="route">روی: </label>
                                    <a href="" class="text-body" id="route-ref">
                                        <span id="route"></span>
                                    </a>
                                </div>
                            </div>
                            {{-- todo better format to view properties --}}
                            <div class="row">
                                <div class="col">
                                    <div class="mt-2" id="beforeDiv" hidden>
                                        <label for="before">قبل: </label>
                                        <span id="before"></span>
                                    </div>
                                    <div class="mt-2" id="afterDiv" hidden>
                                        <label for="after">بعد: </label>
                                        <span id="after"></span>
                                    </div>
                                    <div class="mt-2">
                                        <label for="logId">آیدی: </label>
                                        <span id="logId"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->hasRole('super-admin'))
                <div class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center mb-4 mt-0 mt-md-n2">
                                    <h3 class="secondary-font">آیا اطمینان دارید؟</h3>
                                </div>
                                <form id="deleteUserForm" action="{{ route('admin.logs.destroy') }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-danger me-sm-3 me-1">حذف</button>
                                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            انصراف
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.addEventListener('click', (event) => {
                if (event.target.matches('#details-button')) {
                    const description = event.target.getAttribute('data-description');
                    const causerName = event.target.getAttribute('data-causer-name');
                    const createdAt = event.target.getAttribute('data-created-at');
                    const logId = event.target.getAttribute('data-log-id');
                    const route = event.target.getAttribute('data-route');
                    const subjectName = event.target.getAttribute('data-subject-name');
                    const causerRoute = event.target.getAttribute('data-causer-route')
                    const properties = JSON.parse(JSON.parse(event.target.getAttribute('data-properties').replace(/&quot;/g, '"'))[0]);
                    document.getElementById('title').textContent = logId + " : " + description;
                    document.getElementById('causer').textContent = causerName;
                    document.getElementById('causer-ref').href = causerRoute;
                    document.getElementById('created_at').textContent = createdAt;
                    document.getElementById('route-ref').href = route;
                    document.getElementById('route').textContent = subjectName;
                    document.getElementById('route-div').hidden = route === "";

                    if('before' in properties) {
                        document.getElementById('before').textContent = JSON.stringify(properties.before)
                        document.getElementById('beforeDiv').hidden = false
                    } else {
                        document.getElementById('beforeDiv').hidden = true
                    }
                    if("after" in properties) {
                        document.getElementById('after').textContent = JSON.stringify(properties.after)
                        $('#afterDiv').removeAttr('hidden')
                    } else {
                        document.getElementById('beforeDiv').hidden = true
                    }
                    document.getElementById('logId').textContent = JSON.stringify(properties.id)
                }
            });
        });
    </script>
@endpush
