@extends('layouts.default')

@section('title', 'Data')

@section('styles')
<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
            Datasets
            </div>
            <div class="card-body">
                @if ($files->count())
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">File</th>
                                <th scope="col">Size</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <th scope="row">{{ $file->filename }}</th>
                                <td>{{ ($file->filesize)/1000 }} KB</td>
                                <td>{{ $file->filedescription }}</td>
                                <td>{{ $file->created_at }}</td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                </div>
                @else
                <p class="card-text text-muted">There is actually no datafile on the system, please upload datafile.</p>
                @endif
                
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-header">
            Upload files
            </div>
            <div class="card-body">
                <form action="{{ url('/data-save') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="customFile" multiple>
                            <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="submitFileButton">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop


@section('scripts')
<script type="text/javascript">
$('#submitFileButton').hide();
$('.custom-file-input').on('change', function() { 
    var inputfiles = document.getElementById($(this).attr('id'));
    var inputfileslength = inputfiles.files.length;
    if (inputfileslength > 0){
        var uploadfiles = [];
        var uploadfilesname = [];
        var uploadfilesize = [];
        var uploadtotalsize = 0;
        for(var x = 0;x< inputfileslength;x++){
            uploadfiles.push(inputfiles.files[x]);
            uploadfilesname.push(uploadfiles[x].name);
            uploadfilesize.push(uploadfiles[x].size);
            uploadtotalsize += uploadfiles[x].size;
            if(uploadfilesize[x] > 16777216){ //if the file size is greater than 16 MB = 16777216
                inputfiles.setCustomValidity('The file \"'+uploadfilesname[x]+'\" exceed the size limit (16MB).');
            }else if (uploadtotalsize > 100000000){
                inputfiles.setCustomValidity('The total size of files exceed the total size limit (100MB per batch).');
            }else{
                inputfiles.setCustomValidity('');
            }
        }
        $(this).next('.custom-file-label').addClass("selected").html(uploadfilesname.join(", "));
        $('#submitFileButton').show();
    }
});

</script>
@stop




