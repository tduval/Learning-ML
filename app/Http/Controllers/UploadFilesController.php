<?php

namespace App\Http\Controllers;

use App\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadFilesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = UploadFiles::all();
        return view('data', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'file' => 'required|file|max:8192', //8192 KB
                'description' => 'max:255',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $filext = $file->getClientOriginalExtension();
        $filesize = $file->getClientSize();
        $filedescr = $request->description;
            
        $stor = Storage::disk('public')->put('UploadFiles', $file, 'public');
        
        // Create the model UploadFiles and add the following into the DB Table
        $filemodel = new UploadFiles();
        $filemodel->filename = $filename;
        $filemodel->filepath = $stor;
        $filemodel->filesize = $filesize;
        $filemodel->filedescription = "".$filedescr;
        $filemodel->fileurl = Storage::url($stor);
        $filemodel->save();

        return redirect()->back()->withFlashSuccess("Datafile added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $filemodel = UploadFiles::findOrFail($request->id);
        $filemodel->delete();
        if(Storage::disk('public')->exists($filemodel->filepath)){
            $stor = Storage::disk('public')->delete($filemodel->filepath);
        }
        return redirect()->back()->withFlashSuccess("Datafile deleted!");
    }
}
