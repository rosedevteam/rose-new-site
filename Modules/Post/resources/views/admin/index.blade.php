@extends('admin::layouts.main')

@section('content')
    <div class="content-wrapper">
        <div class="flex-grow-1 p-3y">
            <div class="card mx-4">
                <div class="card-header border-bottom">
                    <h5 class="card-title">فیلتر جستجو</h5>
                    <form action="{{ route('admin.posts.index') }}" method="GET">
                        <div
                            class="d-flex justify-content-start align-items-center row py-3 gap-3 gap-md-0 primary-font">
                            <div class="col-md-3">
                                <label for="count" class="form-label">جستجو: </label>
                                <div id="search" class="search-input">
                                    <input type="search" name="search" value="{{ $search }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="category" class="form-label">کتگوری: </label>
                                <select id="category" name="category" class="form-select text-capitalize">
                                    <option value="all" selected>همه</option>
                                    @foreach($categories as $c)
                                        <option
                                            value="{{ $c->id }}" {{ $category == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort_by" class="form-label">ترتیب بر اساس: </label>
                                <select id="sort_by" name="sort_by" class="form-select text-capitalize">
                                    <option value="created_at" selected>تاریخ ساخت</option>
                                    <option value="title" {{ $sort_by == 'title' ? 'selected' : '' }}>نام
                                    </option>
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
                        </div>
                    </form>
                </div>
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        @can('create-posts')
                            <div class="row mx-2 my-2">
                                <div class="col-md-20">
                                    <div
                                        class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="{{ route('admin.posts.create') }}">
                                                <button class="btn btn-secondary add-new btn-primary ms-2" tabindex="0"
                                                        aria-controls="DataTables_Table_0" type="button"><span><i
                                                            class="bx bx-plus me-0 me-lg-2"></i><span
                                                            class="d-none d-lg-inline-block">نوشتن پست جدید</span></span>
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
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 10%" aria-sort="ascending">نام
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 5%;">نویسنده
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 8%;">کتگوری ها
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 2%;">وضعیت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 1%;">کامنت
                                </th>
                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    style="width: 3%;">تاریخ ساخت
                                </th>
                                @can('edit-posts')
                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                        style="width: 5%;">ویرایش
                                    </th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr class="">
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="d-flex flex-column"><a
                                                    href="{{ route('admin.posts.edit', $post) }}"
                                                    class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $post->title }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @can('view-users')
                                            <a href="{{ route('admin.users.edit', $post->user) }}"
                                               class="text-body text-truncate">
                                            <span class="fw-semibold">
                                    {{ $post->user->name() }}
                                </span>
                                            </a>
                                        @else
                                            <span class="fw-semibold">
                                    {{ $post->user->name() }}
                                </span>
                                        @endcan
                                    </td>
                                    <td>
                                        @foreach($post->categories as $c)
                                            {{ ($c->parent?->name . (is_null($c->parent) ? '' : ': ')) . $c->name }}
                                        @endforeach
                                    </td>
                                    <td><span class="fw-semibold">
                                            @switch($post->status)
                                                @case('public')<span
                                                    class="badge bg-success">منتشر شده</span>@break
                                                @case('draft')<span class="badge bg-warning">پیشنویس</span>@break
                                                @case('hidden')<span class="badge bg-secondary">پنهان</span>@break
                                            @endswitch
                                    </span></td>
                                    <td>{{ $post->comment_status ? 'باز' : 'بسته' }}</td>
                                    <td>{{ verta($post->created_at)->formatJalaliDateTime() }}</td>
                                    @can('edit-posts')
                                        <td>
                                            <div class="d-flex gap-3 text-nowrap">
                                                <a href="{{ route('admin.posts.edit', $post) }}"
                                                   class="btn btn-sm btn-info">
                                                    ویرایش
                                                </a>
                                                @can('delete-posts')
                                                    <x-admin::deletebutton data-id="{{ $post->id }}"/>
                                                @endcan
                                            </div>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $posts->links() }}
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
    <x-admin::deletemodalscript model="posts"/>
@endpush
