<?php

namespace App\Http\Controllers;

use App\DptJasaDptV;
use App\Exports\ExportOverview;
use App\JasaDptV;
use App\Lstp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OverviewController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if (!$length = $request->el)
            $length = 10;
        $paginate = $this->getDataByRequest($request)->paginate($length);
        $data = $paginate->getCollection();
        return view('pages.overview', [ 'data' => $data, 'error'=>$error, 'table'=>$this->tableProp($paginate)]);
    }

    // public function exporte(Request $request){
    //     return Excel::download(new ExportOverview($this->getDataByRequest($request)->getCollection()), 'MRA_OVERVIEW_'.date("YmdHis").'.xlsx');
    // }

    public function getDataByRequest(Request $request){
        // $div_id = $_SESSION['ebudget_division_id'];
        // $user_id = $_SESSION['ebudget_id'];
        $paginate = Lstp::filter($request);
        return $paginate;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}
