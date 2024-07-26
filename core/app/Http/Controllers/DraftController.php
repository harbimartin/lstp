<?php

namespace App\Http\Controllers;

use App\DptJasaDptV;
use App\Exports\ExportOverview;
use App\JasaDptV;
use App\Lstp;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DraftController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
        if (!$length = $request->el)
            $length = 10;
            if ($request->id){
                $header = [
                    'id' => 186,
                    'code' => 'LSTP-2021-3811',
                    'date' => '2022-03-18',
                    'job_order' => '3510003355',
                    'items' => array(
                        [
                            'no' => '10',
                            'name' => 'Pembuatan Dashboard Manajemen Tableau',
                            'due_date' => '2021-07-17',
                            'realisasi' => '207000000',
                            'limit' => '230000000',
                            'overlimit' => false,
                            'service' => array(
                                [
                                    'no' => '10',
                                    'short_text' => 'Implementasi Tableau',
                                    'due_date' => '2021-07-17',
                                    'qty_jo' => '1',
                                    'qty_aktual' => '1',
                                    'uom' => 'PAC',
                                    'aktual' => '230000000',
                                    'overlimit' => 'No',
                                    'real_date' => '2021-07-17'
                                ]
                            )
                        ]
                    ),
                    'vendors' => [
                        'name' => 'TIGA PUTRA PANDAWA, PT',
                        'contact' => 'Agus Wahyudi',
                        'email' => 'info@3pp.co.id',
                        'posisi' => 'Direktur'
                    ],
                    'nilai' => 23000000,
                    'status' => 'Prepared',
                    'k3lh' => '',
                    'catatan' => 'Implementasi Tableau Termin II 10%',
                    'persentase' => 10,
                    'tenorretensi' => false,
                    'info' => 'Implementasi Tableau Termin II 10%',
                    'score' => '4',
                    'note_score' => '90'
                ];
                return view('pages.draft.list', ['header'=>$header, 'error'=>$error]);
            }
        $paginate = $this->getDataByRequest($request)->paginate($length);
        $data = $paginate->getCollection();
        $data = array(
            [
                'id' => 186,
                'code' => 'LSTP-2021-3811',
                'date' => '2022-03-18',
                'job_order' => '3510003355',
                'item' => array(
                    [
                        'name' => 'Implementasi Tableau'
                    ]
                ),
                'vendors' => [
                    'name' => 'TIGA PUTRA PANDAWA, PT',
                    'contact' => 'Agus Wahyudi',
                    'email' => 'info@3pp.co.id',
                    'posisi' => 'Direktur'
                ],
                'status' => 'Proposed',
                'k3lh' => '',
                'catatan' => 'Implementasi Tableau Termin II 10%'
            ]
        );
        return view('pages.draft', [ 'data' => $data, 'error'=>$error, 'table'=>$this->tableProp($paginate)]);
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
