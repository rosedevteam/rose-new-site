@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.joboffers.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-1 gap-md-0 primary-font">
                            <div class="col-md-2">
                                <label for="category" class="form-label">نوع: </label>
                                <select id="category" name="category" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}" {{ $c->id == $category ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_direction" class="form-label">نوع ترتیب: </label>
                                <select id="sort_direction" name="sort_direction" class="form-select text-capitalize">
                                    <option value="desc" selected>نزولی</option>
                                    <option value="asc" {{ $sort_direction == 'asc' ? 'selected' : '' }}>صعودی</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button id="submit" type="submit" class="btn btn-primary mt-4 data-submit">جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        @can('create-job-offers')
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                        class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="{{ route('admin.joboffers.create') }}">
                                                <button class="btn btn-secondary add-new btn-primary ms-2"><span><i
                                                            class="bx bx-plus me-0 me-lg-2"></i><span
                                                            class="d-none d-lg-inline-block">ساخت فرصت شغلی جدید</span></span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <table class="datatables-users table border-top dataTable no-footer dtr-column"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                            <tr>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 7%;">عنوان
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">نویسنده
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 10%;">کتگوری
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">نوع
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">وضعیت
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">تاریخ ساخت
                                </th>
                                <th aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">جزییات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobOffers as $jobOffer)
                                <tr>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $jobOffer->title }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                <span class="fw-semibold"><a href="{{ route('admin.users.edit', $jobOffer->user) }}"
                                                             class="text-body text-truncate">
                                        {{ $jobOffer->user->name() }}</a>
                                </span>
                                    </td>
                                    <td>
                                        @foreach($jobOffer->categories as $c)
                                            {{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}
                                        @endforeach
                                    </td>
                                    <td>{{ $jobOffer->type }}</td>
                                    <td>
                                        <span @class(['badge', 'bg-success' => $jobOffer->status == 'active', 'bg-danger' => $jobOffer->status == 'inactive'])>
                                        @switch($jobOffer->status)
                                            @case('active')فعال@break
                                            @case('inactive')غیر فعال@break
                                        @endswitch
                                        </span>
                                    </td>
                                    <td>{{ verta($jobOffer->created_at)->formatJalaliDateTime() }}</td>
                                    <td>
                                        <div class="d-flex gap-3 text-nowrap">
                                            <a href="{{ route('admin.joboffers.edit', $jobOffer) }}"
                                               class="btn btn-sm btn-info">
                                                ویرایش
                                            </a>
                                            @can('delete-job-offers')
                                                <x-admin::deletebutton data-id="{{ $jobOffer->id }}"/>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $jobOffers->links() }}
                    </div>

                </div>
            </div>
            <x-admin::deletemodal/>
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
    <x-admin::deletemodalscript model="joboffers"/>
@endpush
