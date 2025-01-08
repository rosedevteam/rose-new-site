@component('front.master')
    @section('content')
        <div class="container">
            @include('front.partials.heading', ['title' => 'تحلیل های دانشپذیران', 'subtitle' => ''])
            <div class="row mt-4">
                @foreach($studentReports as $studentReport)
                    <div class="col col-md-4 pb-4">
                        <div class="card border-1 ">
                            <div class="row mx-4 my-3 no-gutters">
                                <div class="col align-content-center">
                                    <img alt="" src="/assets/front/images/Frame.svg">
                                </div>
                                <div class="col">
                                    <p class="fw-bold">{{ $studentReport->company }}</p>
                                    <p>نام دانشپذیر: {{ $studentReport->user->name() }}</p>
                                    <p>تاریخ تحلیل: {{ $studentReport->date }}</p>
                                    <a href="{{ urldecode(route('studentreport.show', $studentReport)) }}"
                                       class="btn btn-default-outline">
                                        <i class="bx bx-download"></i>دانلود
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
@endcomponent
