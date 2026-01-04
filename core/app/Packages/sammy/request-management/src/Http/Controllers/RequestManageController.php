<?php
namespace Sammy\RequestManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Models\RequestType;
use App\Models\RequestStatus;

use Sammy\Location\Models\Location;
use Sammy\RequestManage\Http\Requests\RequestManage;
use Sammy\RequestManage\Models\RequestDetail;
use Sammy\RequestManage\Models\RequestApprove;

use Sammy\EmployeeManage\Models\Employee;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\AssetManage\Models\Asset;
use Sammy\Permissions\Models\Permission;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\CheckInout\Models\IssueNoteDetails;
use Sammy\AssetSoftwareManage\Models\LicenseDetails;

use App\Classes\UserLocationFilter;

use DB;
use Log;
use Response;
use Request;
use Sentinel;
use Carbon\Carbon;

class RequestManageController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| Request Manage Controller
		|--------------------------------------------------------------------------
		|
		| This controller renders the "marketing page" for the application and
		| is configured to only allow guests. Like most of the other sample
		| controllers, you are free to modify or remove it as you desire.
		|
	*/

	private $auditLogger;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(AuditLogger $auditLogger) {
		//$this->middleware('guest');
        $this->auditLogger = $auditLogger;
	}

	/**
	 * Show the location add screen to the user.
	 *
	 * @return Response
	 */
	public function addView() {

		$type=RequestType::all()->lists('name','id');
		
		$modal=AssetModal::where('status',1)->lists('name','id')->prepend('Please Select..',0);
		
		return view('requestManage::request.add')->with(['type' => $type,'modal' => $modal]);
	}

	/**
	 * Get asset of the location add screen to the user.
	 *
	 * @return Response
	 */
	public function getAsset(RequestManage $request) {
		
		$locations = UserLocationFilter::getLocationOfUser();

		$data = Asset::where('asset_model_id',$request->modal)->whereIn('id',function($aa) use($locations)
		{
			$aa->select('asset_id')->from('asset_transaction')->whereIn('location_id',$locations)->whereNull('deleted_at');
        })->with(['depreciationtype','transaction.status','transaction.location','assetmodel','manufacturerName']);



		if(isset($request->serial_no) && $request->serial_no!='')
		{
			$data  = $data->where('asset_no','like','%'.$request->serial_no.'%');
		}

        $issues = IssueNote::with(['details','grn'])->get();

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

        return $data=$data->whereNotIn('id',$notcheckIn)->get();
        
        // return $data->select(DB::raw('CONCAT("SN : ",asset_no," - INO : ",inventory_no) as name'))->get();
	}

	/**
	 * Add new request data to database
	 *
	 * @return Redirect to request add
	 */
	public function add(RequestManage $request) {

		// return $request->all();

		try {
		    $res = null;
			DB::transaction(function () use ($request, &$res) {

				if($request->get('type')==1){

					$res=RequestDetail::create([
						'send_by'=>Sentinel::getUser()->employee_id,
						'request_type_id'=>$request->get('type'),
						'remark'=>$request->get('remark'),
						'asset_type_id'=>$request->get('modal'),
						'quantity'=>$request->get('quantity')
					]);					

				}else{

					$check_asset=Asset::find($request->get('asset_no'));

					if($check_asset){
						$res=RequestDetail::create([
							'send_by'=>Sentinel::getUser()->employee_id,
							'request_type_id'=>$request->get('type'),
							'asset_type_id'=>$check_asset->asset_model_id,
							'asset_no'=>$check_asset->asset_no,
							'remark'=>$request->get('remark')
						]);
					}else{
						throw new TransactionException('Something wrong.Employee wasn\'t created', 100);
					}

				}

				if ($res) {

					$employee= Employee::with('employee_location')->find(Sentinel::getUser()->employee_id);
					$location = Location::find($employee->employee_location->location_id);


					/*if($employee->employee_type_id==1){
						$approved_employee_id=$employee->id;
					}else{
						$parent=$employee->parent()->get();

						$approved_employee_id=$parent[0]->id;
					}*/


					$result=RequestApprove::create([
						'request_id'=>$res->id,
						'approved_location_id'=>$location->id,
						'status_id'=>1
					]);


				}else{
					throw new TransactionException('Something wrong.Employee wasn\'t created', 101);
				}
			});

			if($res) {
			    $res->send_by = Sentinel::getUser()->username;
			    $res->request_type_id = RequestType::find($res->request_type_id)->name;
			    $res->asset_type_id = AssetModal::find($res->asset_type_id)->name;
                $this->auditLogger->addLog('Add Request', 'New Entry', $res->id, null, $res->toJson());
            }

			return redirect('request/add')->with(['success' => true,
				'success.message' => 'Request Send successfully!',
				'success.title' => 'Well Done!']);
		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {
				Log::info("Request Not added");
				return redirect('request/add')->with(['error' => true,
					'error.message' => "Request Not added. Asset not found. Try again",
					'error.title' => 'Error!']);
			} elseif ($e->getCode() == 101) {
				Log::info('Request Not added');
				return redirect('request/add')->with(['error' => true,
					'error.message' => "Request Not added. Try again",
					'error.title' => 'Error!']);
			}
		} catch (Exception $e) {
			Log::info('Transaction Error');
				return redirect('request/add')->with(['error' => true,
					'error.message' => 'Transaction Error',
					'error.title' => 'Error!']);
		}

	}

	/**
	 * Show the Location List view to the user.
	 *
	 * @return Response
	 */
	public function listView(RequestManage $request) {

		$users=UserLocationFilter::getLocationsId();

		$users=array_flatten($users);

        array_push($users, Sentinel::getUser()->employee_id);

		$data = RequestDetail::whereIn('send_by',$users)->with([
		    'requestType', 'employeeApproveLatest', 'employeeApprove.status' ,
            'employeeApprove.employeeApprove','requestStatus','employee.Location.location',
            'employeeApprove.approve_location', 'employeeApproveLatest.approve_location',
            'asset.assetmodel','requestModal','detail'
        ]);

		$type=$request->type;
        if($type!=null && $type != "" && $type!=0){
            $data = $data->where('request_type_id',$type);
        }

        $status=$request->status;
        if($status!=null && $status!="" && $status!=0){
            $data = $data->where('status',$status);
        }

        if($request->from_date){
            $data->where('created_at', '>=', $request->from_date.' 00:00:00');
        }

        if($request->to_date){
            $data->where('created_at', '<=', $request->to_date.' 23:59:59');
        }

		$data=$data->paginate(25);
		
		$count=$data->total();

		$logged_emp=Sentinel::getUser()->employee_id;

		$log_employee = Employee::with('employee_location')->find($logged_emp);

		$typeList=RequestType::all()->lists('name','id')->prepend('All',0);

		$statusList=RequestStatus::all()->lists('name','id')->prepend('All',0);

		return view('requestManage::request.list')->with([
			'data'=>$data,
			'row_count'=>$count,
			'logged'=>$logged_emp,
			'logged_employee' => $log_employee,
			'typeList'=>$typeList,
			'statusList'=>$statusList,
			'old'=>['type'=>$type,'status'=>$status, 'from_date' => '', 'to_date' => '']
		]);
	}

	/**
	 * Show the Location List screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(RequestManage $request) {
		if ($request->ajax()) {

			$i = 1;
			$jsonList = array();

			$requestData = RequestDetail::with(['requestType','employeeApprove','requestStatus','employee.Location.location','asset.assetmodel','requestModal'])->get();

			if (!empty($requestData)) {

				foreach ($requestData as $value) {
					$dd = array();
					array_push($dd, $i);
					
					array_push($dd, $value->employee->first_name." ".$value->employee->last_name);
					array_push($dd, $value->employee->Location!=null?$value->employee->Location->location->name:'-');
					array_push($dd, $value->requestType->name);
					array_push($dd, $value->remark);
					
					if($value->requestStatus->name=="Pending"){
						array_push($dd, "<label class='badge label-warning'>".$value->requestStatus->name."</label>");
					}else if($value->requestStatus->name=="Approved"){
						array_push($dd, "<label class='badge label-success'>".$value->requestStatus->name."</label>");
					}else if($value->requestStatus->name=="Rejected"){
						array_push($dd, "<label class='badge label-danger'>".$value->requestStatus->name."</label>");
					}else if($value->requestStatus->name=="Service"){
						array_push($dd, "<label class='badge label-info'>".$value->requestStatus->name."</label>");
					}

					if ($value->asset != NULL) {
						array_push($dd, $value->asset->assetmodel->name);
						array_push($dd, '-');
						array_push($dd, $value->asset->asset_no);
					} else {
						array_push($dd, $value->requestModal->name);
						array_push($dd, $value->quantity);
						array_push($dd, "-");
					}

					if(count($value->employeeApprove)>0){
						$emp='';
						foreach ($value->employeeApprove as $sub) {
							if($sub->approved_date==null){
								$emp=$sub->approved_employee_id;
							}
						}

						if($emp!='' && $emp==Sentinel::getUser()->employee_id){
							if($value->status==1){
								array_push($dd, '<button class="btn btn-default btn-xs request-reject" data-toggle="tooltip" data-placement="top" data-id="'.$value->id.'" onclick="rejectFunc('.$value->id.')" title="Reject"><i class="fa fa-trash-o"></i> Reject</button>');
								array_push($dd, '<button class="btn btn-default btn-xs request-approve" data-toggle="tooltip" data-placement="top" data-id="'.$value->id.'" onclick="approveFunc('.$value->id.')" title="Approve"><i class="fa fa-check"></i> Approve</button>');
							}else if($value->status==2){
								array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
								array_push($dd, '<span class="label label-success" style="padding: .6em 10px .3em;">Approved</span>');
							}else if($value->status==3){
								array_push($dd, '<span class="label label-danger" style="padding: .6em 10px .3em;">Rejected</span>');
								array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Approve Disabled"><i class="fa fa-check"></i> Approve</button>');
							}else if($value->status==4){
								array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
								array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Approve Disabled"><i class="fa fa-check"></i> Approve</button>');
							}
						}else{
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Approve Disabled"><i class="fa fa-check"></i> Approve</button>');
						}						
					}else{
						if($value->status==1){
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Approve Disabled"><i class="fa fa-check"></i> Approve</button>');
						}else if($value->status==2){
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
							array_push($dd, '<span class="label label-success" style="padding: .6em 10px .3em;">Approved</span>');
						}else if($value->status==3){
							array_push($dd, '<span class="label label-danger" style="padding: .6em 10px .3em;">Rejected</span>');
							array_push($dd, '<span class="label label-success" style="padding: .6em 10px .3em;">Approved</span>');
						}else if($value->status==4){
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Reject Disabled"><i class="fa fa-trash-o"></i> Reject</button>');
							array_push($dd, '<button class="btn btn-default btn-xs disabled" data-toggle="tooltip" data-placement="top" title="Approve Disabled"><i class="fa fa-check"></i> Approve</button>');
						}
					}
					
					array_push($jsonList, $dd);
					$i++;				

				}
				return Response::json(array('data' => $jsonList));
			} else {
				return Response::json(array('data' => []));
			}
		} else {
			return Response::json(array('data' => []));
		}
	}

    /**
     * Reject Request
     */
    public function rejectRequest(RequestManage $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $data = RequestDetail::find($id);
            if ($data) {
                $old = $data->replicate();
                $data->status = 3;
                $data->reason = $request->reason;
                $data->save();

                $res=RequestApprove::where('request_id',$id)->whereNull('approved_date')->first();

                $logged_emp=Sentinel::getUser()->employee_id;

                if($res){
                	$res->status_id=3;
                	$res->approved_employee_id = $logged_emp;
                	$res->reason = $request->reason;
                	$res->approved_date=Carbon::now();
                	$res->save();
                }

                $old->send_by = Sentinel::getUser()->username;
                $old->request_type_id = RequestType::find($old->request_type_id)->name;
                $a = AssetModal::find($old->asset_type_id);
                $old->asset_type_id = ($a)?$a->name:null;

                $data->send_by = Sentinel::getUser()->username;
                $data->request_type_id = RequestType::find($data->request_type_id)->name;
                $a = AssetModal::find($data->asset_type_id);
                $data->asset_type_id = ($a)?$a->name:null;

                $this->auditLogger->addLog('Request List', 'Reject Entry', $data->id, $old->toJson(), $data->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Approve Request
     */
    public function approveRequest(RequestManage $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $data = RequestDetail::find($id);
            if ($data) {
                $old = $data->replicate();

            	$res=RequestApprove::where('request_id',$id)->whereNull('approved_date')->first();

            	$data->status = 1;
                $data->reason = $request->reason;
                $data->save();

                $logged_emp=Sentinel::getUser()->employee_id;
            	
            	if($data->request_type_id==1){

	                if($res){
	                	$res->status_id=2;
                        $res->reason = $request->reason;
                        $res->approved_employee_id = $logged_emp;
	                	$res->approved_date=Carbon::now();
	                	$res->save();
	                }

	                $employee= Employee::find($logged_emp);
                    $location = Location::with('parent_loc')->find($employee->employee_location->location_id);

					/*if($employee->parent && $employee->parent!=1){
						
						$result=RequestApprove::create([
							'request_id'=>$data->id,
							'approved_employee_id'=>$employee->parent,
							'reason' => '',
							'status_id'=>1
						]);

					}else{
						$data->status = 2;
                        $data->reason = $request->reason;
	                	$data->save();	
					}*/

                    if($location->parent_loc){
                        $result=RequestApprove::create([
                            'request_id'=>$data->id,
                            'approved_location_id'=>$location->parent_loc->id,
                            'reason' => '',
                            'status_id'=>1
                        ]);
                    }else{
                        $data->status = 2;
                        $data->reason = $request->reason;
                        $data->save();
                    }

                    $old->send_by = Sentinel::getUser()->username;
                    $old->request_type_id = RequestType::find($old->request_type_id)->name;
                    $a = AssetModal::find($old->asset_type_id);
                    $old->asset_type_id = ($a)?$a->name:null;

                    $data->send_by = Sentinel::getUser()->username;
                    $data->request_type_id = RequestType::find($data->request_type_id)->name;
                    $a = AssetModal::find($data->asset_type_id);
                    $data->asset_type_id = ($a)?$a->name:null;

                    $this->auditLogger->addLog('Request List', 'Approve Entry', $data->id, $old->toJson(), $data->toJson());

	                return response()->json(['status' => 'success']);

            	}else{
	                if($res){
	                	$res->status_id=2;
                        $res->reason = $request->reason;
                        $res->approved_employee_id = $logged_emp;
	                	$res->approved_date=Carbon::now();
	                	$res->save();

                        $this->auditLogger->addLog('Request List', 'Approve Request', $data->id, null, json_encode(['reason' => $request->reason]));
                        //$this->auditLogger->addLog('Request List', 'Approve Entry', $res->id, $old->toJson(), $res->toJson());
	                }

                    $employee= Employee::find($logged_emp);
                    $location = Location::with('parent_loc')->find($employee->employee_location->location_id);

                    /*if($employee->parent && $employee->parent!=1){

                        $result=RequestApprove::create([
                            'request_id'=>$data->id,
                            'approved_employee_id'=>$employee->parent,
                            'reason' => $request->reason,
                            'status_id'=>1
                        ]);

                    }else{
                        $data->status = 2;
                        $data->reason = $request->reason;
                        $data->save();
                    }*/

                    if($location->parent_loc){
                        $result=RequestApprove::create([
                            'request_id'=>$data->id,
                            'approved_location_id'=>$location->parent_loc->id,
                            'reason' => $request->reason,
                            'status_id'=>1
                        ]);
                    }else{
                        $data->status = 2;
                        $data->reason = $request->reason;
                        $data->save();
                    }

                    $old->send_by = Sentinel::getUser()->username;
                    $old->request_type_id = RequestType::find($old->request_type_id)->name;
                    $a = AssetModal::find($old->asset_type_id);
                    $old->asset_type_id = ($a)?$a->name:null;

                    $data->send_by = Sentinel::getUser()->username;
                    $data->request_type_id = RequestType::find($data->request_type_id)->name;
                    $a = AssetModal::find($data->asset_type_id);
                    $data->asset_type_id = ($a)?$a->name:null;

                    $this->auditLogger->addLog('Request List', 'Approve Entry', $data->id, $old->toJson(), $data->toJson());
                	return response()->json(['status' => 'success']);
            	}

            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Approve Request
     */
    public function setReplacementDetail(RequestManage $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $submit_qty = $request->input('submit_qty');

            $data = RequestDetail::find($id);
            if ($data) {

                $old = $data->replicate();
                
                $res=RequestApprove::where('request_id',$id)->whereNull('approved_date')->first();

                $logged_emp=Sentinel::getUser()->employee_id;

                if($res){
                	$res->status_id=2;
                    $res->reason = 'approved '.$submit_qty.'qty with the reason:'.$request->reason;
                    $res->approved_employee_id = $logged_emp;
                	$res->approved_date=Carbon::now();
                	$res->save();

                    $this->auditLogger->addLog('Request List', 'Approve Request', $data->id, null, json_encode(['reason' => $request->reason, 'approve_qty' => $submit_qty]));
                }

                $employee= Employee::find($logged_emp);
                $location = Location::with('parent_loc')->find($employee->employee_location->location_id);

                /*if($employee->parent && $employee->parent!=1){
                    $result=RequestApprove::create([
                        'request_id'=>$data->id,
                        'approved_employee_id'=>$employee->parent,
                        'reason' => '',
                        'status_id'=>1
                    ]);

                }else{
                    $data->status = 2;
                    $data->reason = $request->reason;
                    $data->approved_quantity = $submit_qty;
                    $data->save();
                }*/

                if($location->parent_loc){
                    $result=RequestApprove::create([
                        'request_id'=>$data->id,
                        'approved_location_id'=>$location->parent_loc->id,
                        'reason' => '',
                        'status_id'=>1
                    ]);
                }else{
                    $data->status = 2;
                    $data->reason = $request->reason;
                    $data->approved_quantity = $submit_qty;
                    $data->save();
                }

                $old->send_by = Sentinel::getUser()->username;
                $old->request_type_id = RequestType::find($old->request_type_id)->name;
                $a = AssetModal::find($old->asset_type_id);
                $old->asset_type_id = ($a)?$a->name:null;

                $data->send_by = Sentinel::getUser()->username;
                $data->request_type_id = RequestType::find($data->request_type_id)->name;
                $a = AssetModal::find($data->asset_type_id);
                $data->asset_type_id = ($a)?$a->name:null;

                $this->auditLogger->addLog('Request List', 'Replacement Details', $data->id, $old->toJson(), $data->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * To Service Request
     */
    public function sentToService(RequestManage $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $data = RequestDetail::find($id);
            if ($data) {
                $old = $data->replicate();
                $data->status = 4;
                $data->save();

                $old->send_by = Sentinel::getUser()->username;
                $old->request_type_id = RequestType::find($old->request_type_id)->name;
                $a = AssetModal::find($old->asset_type_id);
                $old->asset_type_id = ($a)?$a->name:null;

                $data->send_by = Sentinel::getUser()->username;
                $data->request_type_id = RequestType::find($data->request_type_id)->name;
                $a = AssetModal::find($data->asset_type_id);
                $data->asset_type_id = ($a)?$a->name:null;

                $this->auditLogger->addLog('Request List', 'Send to Service', $data->id, $old->toJson(), $data->toJson());
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Check assigned software for asset Request
     */
    public function checkSoftwareAsset(RequestManage $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');

            $data = RequestDetail::find($id);
            
            if ($data)
            {
            	$asset_license = LicenseDetails::whereIn('asset_id',function($q)use($data)
            	{
            		$q->select('id')->from('asset')->where('asset_no',$data->asset_no);
            	})->first();

            	if($asset_license)
            	{
                	return response()->json(['status' => 1,'asset'=>$asset_license->name]);
                }else{
                	return response()->json(['status' => 0]);
                }
                
            } else {
                return response()->json(['status' => 0]);
            }
        } else {
            return response()->json(['status' => 0]);
        }
    }

}
