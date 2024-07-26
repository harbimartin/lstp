<?php

namespace App\Http\Controllers;

use App\EmailSend;
use App\File;
use App\UserPositionRpt;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const KFA_BASE = 'http://103.126.30.250:8086/kfa-api/api/kfa/notif';
    const SAP_BASE = 'http://192.168.0.20:1101/axis2/services/';
    const URL_BASE = 'http://ss0.krakatauport.id:8086/ebudget2/';
    // const URL_BASE = 'http://localhost:70/ebudget/';
    public function validing($request,$items){
        $validate = Validator::make($request,$items);
        if ($validate->fails()) {
            $error = implode(", ",$validate->errors()->all()).'.';
            return $error;//s $this->resFailed(400, $validate->errors()->all());
        }else
            return null;
    }
    public function resSuccess($message, $data = null){
        return response()->json([
            'message' => $message,
            'data' => $data
        ],200);
    }
    /**
     * Undocumented function
     *
     * @param [number] $error
     * @category 400 => Bad Request, 401 => Unauthorized,
     * 402 => Payment Required, 403 => No Access, 404 => No Data, 405 => Method not Allowed,
     * 406 => No Accepted Header, 407 => Proxy Auth Req, 408 => Server Timed Out,
     * 409 => Conflict, 410 => Never Data,
     * @param [string|array] $code
     */
    public function resFailed($code, $error){
        if (is_array($error))
            $error = implode(", ",$error).'.';
        return response()->json($error,$code);
    }
    public function err_get($key){
        if (!isset($_SESSION[$key]))
            return null;
        $return = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $return;
    }
    public function err_handler(Request $request,$key, $error){
        if (is_array($error))
            $error = implode(", ",$error).'.';
        $_SESSION[$key] = [ 'msg'=>$error, 'data'=>$request->toArray()];
        return redirect($request->_last_);
    }
    public function unlink_files($folder, $name){
        if ($name==null)
            return;
        $file_loc = public_path($folder) . $name;
        if (file_exists($file_loc)){
            unlink($file_loc);
        }
    }
    public function tableProp($paginate){
        return [
            'total' => $paginate->total(),
            'count' => $paginate->count(),
            'per_page' => $paginate->perPage(),
            'current_page' => $paginate->currentPage(),
            'total_pages' => $paginate->lastPage(),
        ];
    }
    // public function getUserNew($array){
    //     $result = UserPositionRpt::whereIn('id', $array)->get();
    //     $output = array();
    //     foreach($result as $user){
    //         $output[$user['position_user_id']] = [
    //             'nama' => $user['NAME'],
    //             'email' => $user['email'],
    //             'nik' => $user['nik']
    //         ];
    //     }
    //     return $output;
    // }

    public function notifKFA($user_id, $budget){
        $client = curl_init();
        curl_setopt_array($client, array(
            CURLOPT_URL => self::KFA_BASE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => json_encode([
                'app_id' => 1,
                'user_id' => $user_id,
                'item' => $budget,
            ]),
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Access-Control-Allow-Headers' => '*',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($client);
        curl_close($client);
        return json_decode($response);
    }

    public function send_email($email, $name, $subject, $data){
        $to_name = $name;
        $to_email = $email;
        $view = "mails";
        try{
            Mail::send($view, $data, function($message) use ($to_name, $to_email, $subject) {
                $message->to($to_email, $to_name)->subject($subject);
                $message->from("kirimemail.ptkbs@gmail.com","E-Budgeting System");
            });
            EmailSend::create([
                'name' => $to_name,
                'receiver' => $to_email,
                'title' => $subject,
                'body' => json_encode($data),
                'view' => $view,
                'error' => '',
                'status' => '1'
            ]);
        }catch(Exception $th){
            // try{
                EmailSend::create([
                    'name' => $to_name,
                    'receiver' => $to_email,
                    'title' => $subject,
                    'body' => json_encode($data),
                    'view' => $view,
                    'error' => substr($th->getMessage(), 0, 254),
                    'status' => '0'
                ]);
            // }catch(Exception $th){}
        }
    }

    public function send_emails($emails, $name, $subject, $data){
        $to_name = $name;
        $to_email = $emails;
        $view = "mails";
        try{
            Mail::send($view, $data, function($message) use ($to_name, $to_email, $subject) {
                $message->to($to_email, $to_name)->subject($subject);
                $message->from("kirimemail.ptkbs@gmail.com","E-Budgeting System");
            });
            EmailSend::create([
                'name' => $to_name,
                'receiver' => implode(', ',$to_email),
                'title' => $subject,
                'body' => json_encode($data),
                'view' => $view,
                'error' => '',
                'status' => '1'
            ]);
        }catch(Exception $th){
            // try{
                EmailSend::create([
                    'name' => $to_name,
                    'receiver' => implode(', ',$to_email),
                    'title' => $subject,
                    'body' => json_encode($data),
                    'view' => $view,
                    'error' => substr($th->getMessage(), 0, 254),
                    'status' => '0'
                ]);
            // }catch(Exception $th){}
        }
    }

    public function sendXmlToSAP($xmls,$urls){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $urls,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'UTF-8',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$xmls,
        CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SOAPAction : processRequest'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // $response = 'on debug';
        EmailSend::create([
            'name' => 'SAP LSTP',
            'receiver' => $urls,
            'title' => 'Cancel to SAP',
            'body' => json_encode(['request'=>$xmls,'response'=>$response]),
            'view' => 'xmls',
            'error' => '???',
            'status' => '1'
        ]);
        return $response;
    }
    public function callSAP($xmls,$urls){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => self::SAP_BASE.$urls,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => 'UTF-8',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$xmls,
        CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SOAPAction : processRequest'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // $response = 'on debug';
        EmailSend::create([
            'name' => 'SAP LSTP',
            'receiver' => self::SAP_BASE.$urls,
            'title' => 'Send to SAP',
            'body' => json_encode(['request'=>$xmls,'response'=>$response]),
            'view' => 'xmls',
            'error' => '???',
            'status' => '1'
        ]);
        return $response;
    }
    public static function getEloquentSqlWithBindings($query){
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
    protected function arrayToObjKey(array $array, $key) : array{
        foreach($array as $k => $v){
            $array[$k]=[$key=>$v];
        }
        return $array;
    }

    public function total_notif(){
        return [
            'lstp' => 2,
        ];
    }
}
