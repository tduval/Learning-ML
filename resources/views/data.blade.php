@extends('layouts.default')

@section('title', 'Data')

@section('styles')
@stop

@section('content')


<div class="row mb-4">
    <div class="col-8">
        <div class="card">
            <div class="card-header">
            Datasets
            </div>
            <div class="card-body">
                @if (isset($files) && count($files) >0) 
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">File</th>
                                <th scope="col">Size</th>
                                <th scope="col">Description</th>
                                <th scope="col">Created at</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <th scope="row">{{ $file->filename }}</th>
                                <td>{{ ($file->filesize)/1000 }} KB</td>
                                <td>{{ $file->filedescription }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td><div class="d-inline-flex">
                                    <form action="{{ url('/data-show') }}" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{ $file->id }}"><button type="submit" class="btn btn-primary fas fa-eye mr-2"></button></form>
                                    <a class="btn btn-info fas fa-file-archive mr-2" href="{{ url($file->fileurl) }}" target="_blank" role="button"></a>
                                    <form action="{{ url('/data-delete') }}" method="post">{{csrf_field()}}<input type="hidden" name="id" value="{{ $file->id }}"><button type="submit" class="btn btn-danger fas fa-trash"></button></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                </div>
                @else
                <p class="card-text text-muted">There is no datafile on the system, please upload datafile.</p>
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
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" id="customFile" required>
                            <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" id="submitFileButton">Upload</button>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="description" id="descriptionInput" placeholder="Enter a brief description of the file" maxlength="255">
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col">
    <div class="card">
        <div class="card-header">
        Data extract of '@if (isset($filename)) {{$filename}}@endif' (first 25 rows)
        </div>
        <div class="card-body">
            @if (isset($data) && isset($header))
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead class="thead-light">
                        <tr>
                            @foreach ($header as $th)
                            <th scope="col">{{ $th }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            @foreach ($row as $cell)
                            <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    </div>
</div>
@stop


@section('scripts')
<script type="text/javascript">
$('#submitFileButton').hide(); //Hide the Upload button if no file is selected to upload - avoid empty upload
$('.custom-file-input').on('change', function() { 
    var inputfiles = document.getElementById($(this).attr('id')); //retrieve the DOM component with vanilla javascript as jQuery do not support this features
    if (inputfiles.files.length > 0){
        if(inputfiles.files[0].size > 8388608){ //if the file size is greater than 8 MB (PHP.ini Defasult limit size for POST request)
            inputfiles.setCustomValidity('The file exceed the size limit (8 MB).');
        }else{
            inputfiles.setCustomValidity('');
        }
        $(this).next('.custom-file-label').addClass("selected").html(inputfiles.files[0].name); //display the filename into the file input label
        $('#submitFileButton').show(); //restore the Upload button when a valid selected file is present
    }
});
</script>
@stop




