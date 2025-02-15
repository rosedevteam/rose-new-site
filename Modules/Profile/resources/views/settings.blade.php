@extends("profile::layouts.main")

@push('css')
    <link rel="stylesheet" href="/assets/admin/js/datepicker/persian-datepicker.min.css">
@endpush

@section('content')
    <form method="POST" action="{{ route('users.update') }}">
        @csrf
        <div class="col w-25 ms-4">
            <div class="row mb-2">
                <label class="form-label" for="birthday">تاریخ تولد</label>
                <input name="birthday" id="birthday" value="{{ auth()->user()->birthday }}"
                       class="form-control date-picker" autocomplete="off">
            </div>
            <div class="row mb-2">
                <label for="email" class="form-label">ایمیل</label>
                <input name="email" id="email" value="{{ auth()->user()->email }}" class="form-control">
            </div>
            <div class="row mb-2">
                <label for="city" class="form-label">شهر</label>
                <input name="city" id="city" value="{{ auth()->user()->city }}" class="form-control">
            </div>
            <div class="row">
                <label for="is_married" class="form-label">وضعیت تاهل</label>
                <select name="is_married" id="is_married" class="form-select">
                    <option class="form-control" value="" selected>انخاب کنید</option>
                    <option class="form-control"
                            value="0" {{ (auth()->user()->is_married == false && auth()->user()->is_married !== null) ? 'selected' : '' }}>
                        مجرد
                    </option>
                    <option class="form-control" value="1" {{ auth()->user()->is_married == true ? 'selected' : "" }}>
                        متاهل
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">ویرایش</button>
        </div>
    </form>
@endsection

@push('script')
    <script src="/assets/admin/js/datepicker/persian-date.min.js"></script>
    <script src="/assets/admin/js/datepicker/persian-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date-picker").persianDatepicker({
                initialValue: false,
                format: 'YYYY/MM/DD',
                autoClose: true,
            });
        });
    </script
@endpush
