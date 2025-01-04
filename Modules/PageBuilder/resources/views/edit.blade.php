@extends('pagebuilder::layouts.master')

@section('content')
    <input type="hidden" name="pagebuilder_id" id="pagebuilder_id" value="{{$pagebuilder->id}}">
    <div id="gjs">
        {!! $pagebuilder->content !!}
    </div>

@endsection

@section('footer')
    <script type="module" src="{{asset('assets/admin/js/pagebuilder/edit.js')}}"></script>
@stop
