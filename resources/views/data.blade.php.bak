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
        <h2 class="text-primary">Upload new datafile</h2>
        {{-- <div id="dropzone" class="dropzone">{{ csrf_field() }}</div> --}}
        <form method="post" action="{{ url('/data-save') }}" class="dropzone" id="myDropzone" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="dz-message">
                <div class="col-xs-8">
                    <div class="message">
                        <p>XXXDrop files here or Click to Upload</p>
                    </div>
                </div>
            </div>
            <div class="fallback">
                <input type="file" name="file" multiple>
            </div>
        </form>

    </div>
</div>
@stop


@section('scripts')
<script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>

<script type="text/javascript">
Dropzone.options.myDropzone = {
    uploadMultiple: true, //allow multiples files selection
    parallelUploads: 2, // files processed at a time
    maxFilesize: 16, //in MB
};
</script>
@stop




