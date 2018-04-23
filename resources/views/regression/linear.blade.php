@extends('layouts.default')

@section('title', 'Linear Regression')

@section('styles')
@stop

@section('content')


<div class="row mb-4">
    <div class="col">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Linear Regression</h3>
            <p>This page explain a brief introductory of the Linear Regression principles.</p>
        </div>
    </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
    <div class="card">
        <div class="card-header">
        <div class="col d-flex pl-0">
            <h4>Dataset</h4>
            @if (isset($files) && count($files) >0)
            <button class="btn btn-primary btn-sm ml-auto" id="RL-dataset-confirm-btn"> Confirm</button>
            @endif
        </div>
        </div>
        <div class="card-body">
            @if (isset($files) && count($files) >0)
            <div class="row">
            <div class="col">
            <div class="form-group">
                <label for="RL-dataset-select">Select the Dataset that you want working on:</label>
                <select class="form-control" id="RL-dataset-select">
                    @foreach ($files as $file)
                    <option value="{{ $file->id }}">{{ $file->filename }} [{{ ($file->filesize)/1000 }}KB]</option>
                    @endforeach
                </select>
            </div>
            </div>

            <div class="col">
            <div class="form-group">
                <label for="RL-dataset-trainfold-range">Select the percentage of dataset that will be use as the training group (over test group)</label>
                <div class="form-row">
                    <div class="col-1"><span class="bg-info text-white text-center" id="RL-dataset-trainfold-range-value"> 70% </span></div>
                    <div class="col">
                        <input type="range" class="form-control-range" id="RL-dataset-trainfold-range" min="10" max="100" value="70">
                        <small class="form-text text-muted">By default, 70% of the dataset is selected as the training set.</small>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="col-3">       
            <div class="form-group">
                <label for="RL-dataset-split">Select the type of Cross-Validtion split method:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="RL-dataset-split-stratified" name="RL-dataset-split-radios" value="stratified" checked>
                    <label class="form-check-label" for="RL-dataset-split-stratified">Stratified Random Split</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="RL-dataset-split-random" name="RL-dataset-split-radios" value="random">
                    <label class="form-check-label" for="RL-dataset-split-random">Random Split</label>
                </div>
            </div>
            </div>

            </div>
            @else

            <p class="card-text text-muted">There is no datafile on the system, please <a href="{{ url('/data') }}">upload datafile</a>.</p>            
            @endif

        </div>
    </div>
    </div>
</div>


@stop


@section('scripts')
<script type="text/javascript">

$(document).ready(function() {
    $('#RL-dataset-trainfold-range').change(function(e){
        $('#RL-dataset-trainfold-range-value').text($(this).val()+"%");
    });


    $('#RL-dataset-confirm-btn').click(function(e){
        var fileid = $('#RL-dataset-select').val();
        var trainfoldvalue = $('#RL-dataset-trainfold-range').val();
        var splitmethod = $('input[name=RL-dataset-split-radios]:checked').val();
        $.ajax({
            url: "/regression/linear/",
            method: "POST",
            data: { _token: '{{csrf_token()}}' , fileid: fileid, trainfoldvalue: trainfoldvalue, splitmethod: splitmethod},
            success:function(response){
                console.log("Hourra : ",response);
            },
            error:function(response){
                console.log("fuck : ",response);
            }
        });

    });
    

});

</script>
@stop

