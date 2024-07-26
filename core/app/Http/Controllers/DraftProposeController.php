<?php

namespace App\Http\Controllers;

use App\Lstp;
use App\LstpApproval;
use App\UserPositionRpt;
use Illuminate\Http\Request;

class DraftProposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $error = ''){
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
            $all = UserPositionRpt::select('id','name','user_id','position_id','email','position_level','position_name')->where('is_active','1')->get();
            $user = [
                'user_3'=>[],
                'user_4'=>[],
                'user_5'=>[],
                'user_6'=>[],
            ];
            foreach($all as $val){
                for($i = min(6,$val['position_level']); $i>=3; $i--){
                    array_push($user['user_'. $i], $val);
                }
            }
            return view('pages.draft.propose', ['header'=>$header, 'error'=>$error, 'select'=>$user]);
        }
        return redirect(url('draft'));
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
    public function store(Request $request){
        return $request->toArray();
        $lstp = Lstp::find($request->id);
        if ($lstp->lstp_version_rpt->sisa_lstp < $lstp->total_proposed){
            return $this->err_handler($request, 'error', 'Sisa lstp anda tidak dapat memenuhi nilai total dari MRA ini!');
        }
        if (!$posuser_id = UserPositionRpt::where(['user_id' => $_SESSION['elstp_id'], 'is_active' => 1])->first()->position_user_id){
            return $this->err_handler($request, 'error', 'Posisi User anda tidak ditemukan!');
        }
        $level = $lstp->getLevelPropose();
        if ($lstp){
            if ($lstp->lstp_status == 'Draft'){
                $body = array($posuser_id);
                for($i = $level; $i <= 4; $i++){
                    array_push($body, (int)$request['ttd'.$i]);
                    if (!($request['ttd'.$i] && $request['ttd'.$i]))
                        return $this->err_handler($request, 'error', 'Anda belum mengisi TTD '.($i - $level + 1));
                }
                $user_detail = $this->getUserNew($body);
                for($i = $level; $i <= 4; $i++){
                    if ($i == $level){
                        $res = $this->notifKFA(
                            $request['uid'.$i],
                            $lstp
                        );
                        // if (!isset($res->data))
                            // return json_encode($res);
                        $data = [
                            "name"=>$user_detail[$request['ttd'.$i]]['nama'],
                            "intro" => "Permohonan persetujuan Memo Realisasi Anggaran dengan rincian sebagai berikut :",
                            "table" => [
                                "Kode" => $lstp->lstp_code,
                                "Tanggal" => $lstp->lstp_date,
                                "Tipe Dokumen" => $lstp->doc_types->doc_type_desc,
                                "Catatan Header" => $lstp->note_header,
                                "Versi" => $lstp->lstp_versions->lstp_name,
                                "Status" => 'Proposed',
                            ],
                            "close" => "Dimohon untuk segera membuka web E-lstping untuk melakukan persetujuan.",
                            "link" => self::URL_BASE.'persetujuan?id='.$lstp->id,
                            "pemohon" => $user_detail[$posuser_id]['nama']
                        ];
                        $this->send_email($request['ue'.$i], $user_detail[$request['ttd'.$i]]['nama'], "Persetujuan : Memo Realisasi Anggaran No.".$lstp->lstp_code, $data);
                    }
                    LstpApproval::create([
                        't_lstp_id' => $lstp->id,
                        'lstp_position_user_id' => $request['ttd'.$i],
                        'user_id' => $request['uid'.$i],
                        'user_email' => $request['ue'.$i],
                        'lstp_status' => null,
                        'tgl_status' => null,
                        'status_ref' => $i,//$request['ttd'.$i],
                        'status_active' => $i == $level ? 1:0
                    ]);
                }
                $lstp->update([
                    'lstp_status'=>'Proposed',
                    'proposed' => now(),
                    'proposed_by' => $posuser_id
                ]);
            }
            return redirect(url('/'.request()->segment(1)).'/item?hid='.$lstp->id);
            // }
            // return 'nacawc';
        }
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
