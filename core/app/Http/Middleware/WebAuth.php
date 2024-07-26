<?php

namespace App\Http\Middleware;

use App\Approval;
use App\ApprovalAanwijzingV;
use App\ApprovalCobV;
use App\ApprovalCoqV;
use App\ApprovalNegoV;
use App\User;
use Closure;
use Illuminate\Support\Facades\DB;

class WebAuth{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        // if ($request->path() != 'maintenance')
        //     return redirect(url('/').'/maintenance');
        session_start();
        if(!isset($_SESSION['lstp_id']) || empty($_SESSION['lstp_id'])){
            return $this->directout($request);
        }
        //MAINTENANCE
        if ($request->path() == '/'){
            return redirect(url('/').'/home');
        }
        // if (!isset($_SESSION['eproc_userid'])){
        //     if (!$eproc_userid = User::where('id_sso', $_SESSION['lstp_id'])->first()){
        //         return $this->directout($request);
        //     }
        //     $_SESSION['eproc_userid'] = $eproc_userid->id;
        // }
        $_SESSION['lstp_ta'] = 0;
        // $_SESSION['eproc_dpt'] = Approval::where('approval_userid', $_SESSION['eproc_userid'])->count();
        // $_SESSION['eproc_aanwijzing'] = ApprovalAanwijzingV::whereNull('release')->where('approval_userid', $_SESSION['eproc_userid'])->count();
        // $_SESSION['eproc_coq'] = ApprovalCoqV::where(DB::raw('DATEDIFF(tanggal_selesai, DATE(NOW()))'), '<', 0)->
        //     where([
        //         'bidding' => 0,
        //         'negosiasi' => 0,
        //         'pemenang' => 0,
        //         'approval_userid' => $_SESSION['eproc_userid']
        //     ])->count();
        // $_SESSION['eproc_cob'] = ApprovalCobV::where(DB::raw('TIME_TO_SEC(TIMEDIFF(tanggal_selesai, NOW()))'), '<', 0)
        //     ->where(['approval_userid'=>$_SESSION['eproc_userid'], 'negosiasi'=>0, 'pemenang'=>0])->count();
        // $_SESSION['eproc_ba_nego'] = ApprovalNegoV::where('approval_userid', $_SESSION['eproc_userid'])->count();
        // $user = User::find($_SESSION['lstp_id']);
        // $_SESSION['ebudget_admin'] = $user->budget_admin ? true : false;
        // $_SESSION['ebudget_pengadaan'] = $user->pengadaan_reject_budget ? true : false;
        return $next($request);
    }
    public function directout($request){
        $baseURL = 'http://172.16.11.17:70/sikar/login_lstp.php';
        if($_SERVER['SERVER_NAME']=='cigading.ptkbs.co.id'){
            $baseURL = 'http://cigading.ptkbs.co.id:8086/kipsinglewindow';
        }elseif ($_SERVER['SERVER_NAME'] == 'ss0.krakatauport.id'){
            $baseURL = 'http://ss0.krakatauport.id:8086/kipsinglewindow';
        }elseif($_SERVER['SERVER_NAME']=='103.126.30.250'){
            $baseURL = 'http://103.126.30.250:8086/kipsinglewindow';
        }elseif($_SERVER['SERVER_NAME']=='http://192.168.0.27/'){
            $baseURL = 'http://192.168.0.27:88/kipsinglewindow';
        }elseif($_SERVER['SERVER_NAME']=='localhost')
            $baseURL = 'http://localhost:70/sikar/login_lstp.php';
        header("Location: ".$baseURL.'?url='.$request->fullUrl());
        die();
    }
}
