<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadFiles;
use Phpml\Dataset\Demo\IrisDataset;
use Phpml\Dataset\Demo\WineDataset;
use Phpml\Dataset\Demo\GlassDataset;
use Phpml\Dataset\CsvDataset;
use Illuminate\Support\Facades\Storage;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\CrossValidationRandomSplit;
use Phpml\Regression\LeastSquares;

class LinearRegressionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = UploadFiles::all();
        return view('regression.linear', compact('files')); 
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
        $fileid = $request->input('fileid');
        $trainfoldvalue = 1-($request->input('trainfoldvalue')/100);
        $uploadfile = UploadFiles::findOrFail($fileid);
        if(stripos($uploadfile->filename, 'iris') !== FALSE){
            $dataset = new IrisDataset();
        }elseif(stripos($uploadfile->filename, 'wine') !== FALSE){
            $dataset = new WineDataset();
        }elseif(stripos($uploadfile->filename, 'glass') !== FALSE){
            $dataset = new GlassDataset();
        }else{
            \Debugbar::error("die");
            die();
        }
        //\Debugbar::info($dataset);

        if($request->input('splitmethod') == "random"){
            $split = new RandomSplit($dataset, $trainfoldvalue);
        }else{
            $split = new StratifiedRandomSplit($dataset, $trainfoldvalue);
        }
        //\Debugbar::info($split);
        $regression = new LeastSquares();
        //\Debugbar::info($split->getTrainSamples());
        $arr = array();
        for($i=0;$i<count($split->getTrainSamples());$i++){
            $arr[$i] = array((array_column($split->getTrainSamples(), 0))[$i], (array_column($split->getTrainSamples(), 1))[$i]);
        }
        \Debugbar::info($arr);
        $regression->train($arr, $split->getTrainLabels());
        \Debugbar::info($regression);
        //$predicted = $regression->predict($split->getTestSamples());
        //\Debugbar::info($predicted);
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
    public function destroy($id)
    {
        //
    }
}
