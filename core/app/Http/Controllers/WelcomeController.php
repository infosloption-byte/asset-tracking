<?php namespace App\Http\Controllers;

use App\Models\AssetTransaction;
use App\Classes\UserLocationFilter;
use Sammy\RequestManage\Models\RequestDetail;
use Illuminate\Http\Request;
use Sammy\AssetManage\Models\Asset;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\CheckInout\Models\IssueNoteDetails;
use Sammy\Location\Models\EmployeeLocation;
use Sammy\Location\Models\Location;

use Response;
use DB;
use Sentinel;

class WelcomeController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| Welcome Controller
		|--------------------------------------------------------------------------
		|
		| This controller renders the "marketing page" for the application and
		| is configured to only allow guests. Like most of the other sample
		| controllers, you are free to modify or remove it as you desire.
		|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function index() {
        return view('index');
    }

	public function dashboard() {

        $locations  = UserLocationFilter::getLocations();

        $location=$locations->pluck('id');

        // $aa = Asset::with('supplier')->selectRaw("*,
        //     TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period,
        //     CASE TIMESTAMPDIFF(MONTH,now(),warranty_to)
        //         WHEN TIMESTAMPDIFF(MONTH,now(),warranty_to) < 3 THEN TIMESTAMPDIFF(MONTH,now(),warranty_to)
        //         WHEN TIMESTAMPDIFF(MONTH,now(),warranty_to) > 3 THEN 'expired'
        //     END as months "
        //     )->where(DB::raw('TIMESTAMPDIFF(MONTH,CURDATE(),warranty_to)'),'<',3)
        //      ->whereIn('id',function($qry) use($location)
        //      {
        //          $qry->select('asset_id')
        //          ->from('asset_transaction')
        //          ->whereIn('location_id',$location);
        //      })->get();

        $aa= Asset::with(['supplier'])->whereIn('id',function($query)use($location){
                    $query->select('asset_id')->from('asset_transaction')->whereIn('location_id',$location);
                })
                ->select("*",DB::raw('DATEDIFF(warranty_to,CURDATE()) as diff'))
                ->where(DB::raw('DATEDIFF(warranty_to,CURDATE())'),'<=',90)
                ->where(DB::raw('DATEDIFF(warranty_to,CURDATE())'),'>=',0)
                ->get();

        $users=UserLocationFilter::getLocationsId();

        $users=array_flatten($users);

        array_push($users, Sentinel::getUser()->employee_id);

        // $requestData = RequestDetail::whereIn('send_by',$users)
        //             ->where('status',1)
        //             ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
        //             ->select(DB::raw('count(request.id) as count'),'name','request_type_id')
        //             ->groupBy('request_type_id')->get(['count','name']);

        $asset_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',1)->get()[0]->count;

        $service_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',2)->get()[0]->count;

        $dispose_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',3)->get()[0]->count;

        $locations=UserLocationFilter::locationHierarchy();

        $issues = IssueNote::whereIn('to_location_id',$location)->with(['details','grn'])->get();

        $notcheckIn=[];

        foreach ($issues as $value) {
            if($value->grn==null){

                foreach ($value->details as $ass) {
                    // if($ass->status==0){
                     $notcheckIn[]=$ass->asset_id;
                    // }
                }
            }else{
                foreach ($value->details as $ass) {
                    if($ass->status==0){
                     $notcheckIn[]=$ass->asset_id;
                    }
                }
            }
        }

        $checkin_pending=count($notcheckIn);

		return view('dashboard')->with([
            'data'=>$aa,
            'locations'=>$locations,
            'asset_request_count'=>$asset_request_count,
            'service_request_count'=>$service_request_count,
            'dispose_request_count'=>$dispose_request_count,
            'checkin_pending'=>$checkin_pending
        ]);
	}

    public function getRequestData(Request $request){

        if($request->location==0){
            $emp_loc=array_flatten(EmployeeLocation::get()->pluck('employee_id'));
        }else{            
            $emp_loc=array_flatten(EmployeeLocation::where('location_id',$request->location)->get()->pluck('employee_id'));
        }
        
        $users=$emp_loc;

        if(Sentinel::getUser()->employee_id==1 && ($request->location==0 || $request->location==1)){
            array_push($users, Sentinel::getUser()->employee_id);            
        }


        $asset_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',1)->get()[0]->count;

        $service_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',2)->get()[0]->count;

        $dispose_request_count=RequestDetail::whereIn('send_by',$users)
                                ->where('status',1)
                                ->leftJoin('request_type', 'request.request_type_id', '=', 'request_type.id')
                                ->select(DB::raw('count(request.id) as count'))
                                ->where('request_type_id',3)->get()[0]->count;

        if($request->location==0){

            $locations  = UserLocationFilter::getLocations();

        }else{

            $location=Location::find($request->location);
            $loc=$location->getDescendantsAndSelf();

        }

        // return UserLocationFilter::getLocationsOfLocation($request->location);

        $location=$loc->pluck('id');
        
        $issues = IssueNote::whereIn('to_location_id',$location)->with(['details','grn'])->get();

        $notcheckIn=[];

        foreach ($issues as $value) {
            if($value->grn==null){

                foreach ($value->details as $ass) {
                    // if($ass->status==0){
                     $notcheckIn[]=$ass->asset_id;
                    // }
                }
            }else{
                foreach ($value->details as $ass) {
                    if($ass->status==0){
                     $notcheckIn[]=$ass->asset_id;
                    }
                }
            }
        }

        $checkin_pending=count($notcheckIn);

        return [
            'asset_request_count'=>$asset_request_count,
            'service_request_count'=>$service_request_count,
            'dispose_request_count'=>$dispose_request_count,
            'checkin_pending'=>$checkin_pending
        ];
    }

    public function test() {
        return 'Hooray';
        //return Menu::create(['label'=>'Add Menu','link'=>'menu/add','icon'=>'','parent'=>'2','menu_sort'=>2,'level'=>1,'permissions'=>'["menu.add"]']);
        //return Sentinel::registerAndActivate(['username'=>'super.admin','password'=>'123456','email'=>'admin@admin.lk','first_name'=>'Super','last_name'=>'Administrator']);
    }

	public function getLocation() {
		return UserLocationFilter::getLocationHierarchy();
	}

    public function loadBucketData(Request $request) {
        $id        = $request->get('location');
        $locations = UserLocationFilter::getLocations();
        $ids       =   $locations->lists('id')->toArray();

        if ($request->ajax()) {
            $total_asset = 0;
            $total_value = 0;
            $undeploy_asset = 0;
            $undeploy_value = 0;
            $deploy_asset = 0;
            $deploy_value = 0;
            $pending_asset = 0;
            $pending_value = 0;
            $service_asset = 0;
            $service_value = 0;
            $damage_asset = 0;
            $damage_value = 0;
            $disposed_asset = 0;
            $disposed_value = 0;

            if(count($locations)>0){
                if ($id == '0') {
                    $assets = DB::select(DB::raw('SELECT 
                                                    count(asset.id) as count,
                                                    ifnull(sum(asset .purchased_value),0) as total,
                                                    `status`.id,
                                                    `status`.name
                                                    FROM asset_transaction 
                                                    LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                                    RIGHT JOIN `status` on `status`.id= asset_transaction.status_id
                                                    WHERE  asset_transaction.deleted_at IS NULL 
                                                    AND asset_transaction.location_id in 
                                                    ('.implode(',', $ids).')
                                                    GROUP BY `status`.id ORDER BY `status`.id')); 

                    $total = DB::select(DB::raw('SELECT 
                                                    count(asset.id) as count,
                                                    ifnull(sum(asset.purchased_value),0) as total
                                                    FROM asset_transaction 
                                                    LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                                    AND asset_transaction.location_id in ('.implode(',', $ids).')
                                                    WHERE  asset_transaction.deleted_at IS NULL'));

                    $aa = DB::select(DB::raw('select 
                                                count(asset.id) as category_count,
                                                asset_modal.`name` as category_name
                                            FROM asset_transaction 
                                            LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                            LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                                            where asset_transaction.deleted_at is null
                                            AND asset_transaction.location_id in ('.implode(',', $ids).')
                                            GROUP BY asset_modal.id'));
                }else{
                    $assets = DB::select(DB::raw('SELECT 
                                                  count(asset.id) as count,
                                                  ifnull(sum(asset.purchased_value),0) as total,
                                                  `status`.id,
                                                  `status`.name
                                                FROM asset_transaction 
                                                LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                                RIGHT JOIN `status` on `status`.id= asset_transaction.status_id
                                                WHERE  asset_transaction.deleted_at IS NULL 
                                                and asset_transaction.location_id = '.$id.'
                                                GROUP BY `status`.id ORDER BY `status`.id')); 

                    $total = DB::select(DB::raw('SELECT 
                                                    count(asset.id) as count,
                                                    ifnull(sum(asset .purchased_value),0) as total
                                                    FROM asset_transaction 
                                                    LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                                    and asset_transaction.location_id = '.$id.'
                                                    WHERE  asset_transaction.deleted_at IS NULL'));

                    $aa = DB::select(DB::raw('select 
                                                count(asset.id) as category_count,
                                              asset_modal.`name` as category_name
                                            from asset_transaction 
                                            LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                            LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                                            where asset_transaction.deleted_at is null
                                            and location_id = '.$id.'
                                            GROUP BY asset_modal.id'));
                }
            }

            foreach ($assets as $key => $value) {
                if(isset($value)){     
                    if($value->id==ASSET_UNDEPLOY){
                        $undeploy_asset = $value->count;
                        $undeploy_value = $value->total;
                    } 

                    if($value->id==ASSET_DEPLOY){
                        $deploy_asset = $value->count;
                        $deploy_value = $value->total;
                    } 

                    if($value->id==ASSET_PENDING){
                        $pending_asset = $value->count;
                        $pending_value = $value->total;
                    } 

                    if($value->id==ASSET_INSERVICE){
                        $service_asset = $value->count;
                        $service_value = $value->total;
                    } 

                    if($value->id==ASSET_DAMAGE){
                        $damage_asset = $value->count;
                        $damage_value = $value->total;
                    } 

                    if($value->id==ASSET_DISPOSED){
                        $disposed_asset = $value->count;
                        $disposed_value = $value->total;
                    }           
                    
                }
            }


            return Response::json(array(
                'total_asset'    => $total!=null?$total[0]->count:0,
                'total_value'    => $total!=null?$total[0]->total:0,
                'undeploy_asset' => $undeploy_asset,
                'undeploy_value' => $undeploy_value,
                'deploy_asset'   => $deploy_asset,
                'deploy_value'   => $deploy_value,
                'pending_asset'  => $pending_asset,
                'pending_value'  => $pending_value,
                'service_asset'  => $service_asset,
                'service_value'  => $service_value,
                'damage_asset'   => $damage_asset,
                'damage_value'   => $damage_value,
                'disposed_asset'   => $disposed_asset,
                'disposed_value'   => $disposed_value,
                'category'       => $aa
            ));
        } else {
            return Response::json(array(
                'total_asset' => '',
                'deploy_asset' => '',
                'undeploy_asset' => '',
                'pending_asset' => '',
                'damage_asset' => '',
                'disposed_asset' => '',
            ));
        }
    }


    public function loadCatData(Request $request) {
        $id = $request->get('location');
        $type = $request->get('type');
        $locations = UserLocationFilter::getLocations();
        $ids       =   $locations->lists('id')->toArray();

        if ($request->ajax()) {
            $filter  =  '';

            if ($request->get('location') != '0') {
                $filter  .= ' AND asset_transaction.location_id = '.$id. '';
            }

            if($type != '0') {
                $filter  .= ' AND asset_transaction.status_id = '.$type. '';
            }

            if ($type == '0') {
                $aa = DB::select(DB::raw("select 
                                              asset_modal.id as model_id,
                                              count(asset_modal.id) as category_count,
                                              asset_modal.`name` as category_name,
                                              'ALL' as status_name
                                            from asset_transaction 
                                            LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                            LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                                            where asset_transaction.deleted_at is null
                                            ".$filter."
                                            AND asset_transaction.location_id in (".implode(',', $ids).")
                                            GROUP BY asset_modal.id"));
            }else{
                $aa = DB::select(DB::raw('select 
                                              asset_modal.id as model_id,
                                              count(asset_modal.id) as category_count,
                                              asset_modal.`name` as category_name,
                                               (select `status`.`name` from `status` where `status`.id = status_id) as status_name
                                            from asset_transaction 
                                            LEFT JOIN asset on asset.id = asset_transaction.asset_id
                                            LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                                            where asset_transaction.deleted_at is null
                                            '.$filter.'
                                             AND asset_transaction.location_id in ('.implode(',', $ids).')
                                            GROUP BY asset_modal.id'));
            }

            $html ="";
            $i=1;

            return Response::json(array('detail'=>$aa, 'status'=>$type, 'location'=>$id));
        } else {
            return Response::json(array(
                'category' => [],
            ));
        }
    }

}
