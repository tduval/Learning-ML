@extends('layouts.default')

@section('title', 'Data')

@section('styles')
<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

<div class="row">
    <div class="card w-75">
        <div class="card-header">
        Datasets
        </div>
        <div class="card-body">
            <h5 class="card-title">Data Page</h5>
            This is some text within a card body.
        </div>
    </div>


    <div class="card w-25 border-light">
        <div class="card-header text-center text-primary">
        Upload Datafile
        </div>
        <div class="card-body">
            <div id="dropzone" class="dropzone"></div>
        </div>
    </div>
</div>
@stop


@section('scripts')
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>

<script type="text/javascript">
Dropzone.autoDiscover = false;
jQuery(document).ready(function() {
  $("#dropzone").dropzone({
    url: "/file/post",
    dictDefaultMessage: "Drop files here or<br>click to upload..."
  });
});
</script>
@stop




