<?php

namespace App\Http\Controllers;

use App\EmailSend;
use App\Lstp;
use Illuminate\Http\Request;

class ViewController extends Controller{
    public function home(Request $request){
        return view('pages.home', ['on'=>'home']);
    }
    public function sendsap(Request $request){
        $data = Lstp::filter($request)->where('budget_status','Approved')->whereNull('banfn')
        ->with(['doc_types','budget_versions'])->get();
        return view('pages.monitor.sendsap', [ 'data'=>$data, 'total'=>$this->monitor_count()]);
    }
    public function cancelsap(Request $request){
        $data = Lstp::filter($request)->where(['budget_status'=>'Canceled'])->where(function($q){
            $q->where('fb_type','!=','CL')->orWhere('result','!=','SC');
        })->get();
        return view('pages.monitor.cancelsap', [ 'data'=>$data, 'total'=>$this->monitor_count()]);
    }
    public function monitor(){
        return redirect(url('sendsap'));
    }
    public function monitor_count(){
        return [
            'Cancel' => Lstp::where(['budget_status'=>'Canceled'])->where(function($q){
                            $q->where('fb_type','!=','CL')->orWhere('result','!=','SC');
                        })->count(),
            'Send' => Lstp::where('budget_status','Approved')->whereNull('banfn')->count(),
            'Error' => EmailSend::where('view','error')->count(),
            'User' => EmailSend::where('view','mails')->count(),
            'SAP' => EmailSend::where('view','xmls')->count()
        ];
    }
    // public function print_view(Request $request){
    //     $budget_status = BudgetStatus::find($request->id);
    //     if ($budget_status->budget->budget_status != 'DRAFT'){
    //         $approver = [
    //             'user' => array_values($budget_status->budget->status->where('status_ref','<=', 4)->where('status_ref','>',2)->toArray()),
    //             'keu' => array_values($budget_status->budget->status->where('status_ref','>',6)->where('status_ref','<=',8)->toArray())
    //         ];
    //     }
    //     return view('pages.persetujuan.print', ['data'=>$budget_status->budget, 'onPreview'=>$request->id,'approver'=>$approver, 'withQR'=>true]);
    // }
    public function maintenance(Request $request){
        return view('maintenance');
    }
}
