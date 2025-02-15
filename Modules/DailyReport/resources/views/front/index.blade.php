@component('front.master')
    @section('content')
        <div class="container">
            @include('front.partials.heading', ['title' => 'گزارش روزانه بازار', 'subtitle' => ''])
            <div class="row mt-4">
                @foreach($dailyReports as $dailyReport)
                    <div class="col col-md-4 pb-4">
                        <div class="card border-1 ">
                            <div class="row mx-4 my-3 no-gutters">
                                <div class="col align-content-center">
                                    <img alt="" src="/assets/front/images/Frame.svg">
                                </div>
                                <div class="col">
                                    <p class="fw-bold">گزارش روزانه {{ $dailyReport->title }}</p>
                                    <button
                                        onclick="downloadReport('{{ urldecode(route('dailyreports.show', $dailyReport)) }}')"
                                       class="btn btn-default-outline">
                                        <i class="bx bx-download"></i>دانلود
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
    @section('footer')
        <script src="/assets/front/js/dailyreports/download.js"></script>
    @endsection
@endcomponent
