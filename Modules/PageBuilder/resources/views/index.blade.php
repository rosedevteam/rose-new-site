@extends('pagebuilder::layouts.master')

@section('content')
    <input type="hidden" name="pagebuilder_type" id="pagebuilder_type" value="{{request('pagebuilder_type')}}">
    <input type="hidden" name="pagebuilder_id" id="pagebuilder_id" value="{{request('pagebuilder_id')}}">
    <div id="gjs">

    </div>

@endsection

@section('footer')
    <script>

    </script>
@stop
