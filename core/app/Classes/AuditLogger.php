<?php


namespace App\Classes;


use App\Models\AuditTrail;
use Sentinel;
use DB;
use Illuminate\Http\Request;

class AuditLogger
{
    public function addLog($module, $event, $reference, $old_data, $new_data){
        $user = Sentinel::getUser();
        $time = date('Y-m-d H:i:s');
        $req = Request::capture();
        $ip = $req->ip();

        if(!$module){
            throw new \Exception('module not found!');
        }

        if(!$event){
            throw new \Exception('event not found!');
        }

        if(!$reference){
            throw new \Exception('reference not found!');
        }

        if(!$new_data){
            throw new \Exception('new data not found!');
        }

        AuditTrail::create([
            'module' => $module,
            'event' => $event,
            'event_time' => $time,
            'user_id'   => $user->username,
            'username' => $user->employeedetail->first_name.' '.$user->employeedetail->last_name,
            'reference' => $reference,
            'old_data' => ($old_data)?($old_data):null,
            'new_data' => $new_data,
            'ip'    => $ip
        ]);

    }

    public function getAuditTrail($from = null, $to = null, $module = null, $user = null){
        $audit = AuditTrail::orderBy('event_time','desc')->orderBy('id','desc');

        if($from){
            $audit->where('event_time','>=',$from.' 00:00:00');
        }

        if($to){
            $audit->where('event_time','<=',$to.' 23:59:59');
        }

        if($module){
            $audit->where('module',$module);
        }

        if($user){
            $audit->where(function($q) use ($user){
                $q->where('user_id','like', '%'.$user.'%')
                    ->orWhere('username', 'like', '%'.$user.'%');
            });
        }

        return $audit->paginate(20);
    }

    public function getAuditTrailAll($from = null, $to = null, $module = null, $user = null){
        $audit = AuditTrail::orderBy('event_time','desc')->orderBy('id','desc');

        if($from){
            $audit->where('event_time','>=',$from.' 00:00:00');
        }

        if($to){
            $audit->where('event_time','<=',$to.' 23:59:59');
        }

        if($module){
            $audit->where('module',$module);
        }

        if($user){
            $audit->where(function($q) use ($user){
                $q->where('user_id','like', '%'.$user.'%')
                    ->orWhere('username', 'like', '%'.$user.'%');
            });
        }

        return $audit->get();
    }

    public function getModules(){
        return DB::select(DB::raw('SELECT DISTINCT module FROM audit_trail'));
    }
}