<?php
namespace Sammy\AssetManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Classes\UserLocationFilter;
use App\Classes\AssetCustom;
use App\Exceptions\TransactionException;

use App\Http\Controllers\Controller;
use App\Models\Devices;
use App\Models\DeviceModal;
use App\Models\Status;
use App\Models\FieldSetValues;
use App\Models\AssetTransaction;
use App\Models\AssetBarcode;
use App\Models\BarcodeCategory;
use App\Models\LocationType;

use App\Models\User;
use Sammy\AssetManage\Http\Requests\AssetRequest;
use Sammy\AssetManage\Models\Asset;
use Sammy\AssetManage\Models\DepreciationType;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\ConfigManage\Models\AppConfig;
use Sammy\Location\Models\Location;
use Sammy\SupplierManage\Models\Supplier;
use Sammy\Permissions\Models\Permission;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\Location\Models\EmployeeLocation;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\CheckInout\Models\IssueNoteDetails;
use Sammy\CheckInout\Models\Grn;
use Sammy\CheckInout\Models\GrnDetails;
use Sammy\ManufacturerManage\Models\Manufacturer;
use Sammy\RequestManage\Models\RequestDetail;
use Sammy\AssetUpgradeManage\Models\AssetUpgrade;
use Sammy\AssetSoftwareManage\Models\LicenseDetails;
use Sammy\AssetSoftwareManage\Models\License;

use Illuminate\Http\Request;
use PhpSpec\Exception\Exception;
use Illuminate\Database\QueryException;

use Carbon\Carbon;
use Sentinel;
use Response;
use Excel;
use DB;
use Session;
use Log;

class AssetController extends Controller {

	/*
		|--------------------------------------------------------------------------
		|  Asset Controller
		|--------------------------------------------------------------------------
		|
	*/

    private $auditLogger;

    /**
     * Create a new controller instance.
     *
     * @return \Sammy\MenuManage\Http\Controllers\ManufacturersController
     */
	public function __construct(AuditLogger $auditLogger)
	{
        // return "dsjfhkjsdf";
		//$this->middleware('guest');
        $this->auditLogger = $auditLogger;
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{

        $asset_models      	=	AssetModal::where('status',1)->lists('name','id')->prepend('Select Asset Modal', '0');
        $depreciation_type 	= 	DepreciationType::lists('name','id');
        // $status 	 		=	Status::whereIn('name',['Un-Deploy','Deploy'])->lists('name','id');
        $suppliers         	= 	Supplier::where('status',1)->lists('name','id')->prepend('Select Supplier', '0');
        $locations         	= 	Location::where('status',1)->lists('name','id');
        $loc_type			=	LocationType::where('status',1)->lists('name','id')->prepend('Select Location Type', '0');
        $manufacturer 	 	=	Manufacturer::where('status',1)->lists('name','id')->prepend('Select Manufacturer', '0');

        return view( 'assetManage::asset.add' )->with([
            "asset_models"      =>$asset_models,
            "suppliers"         =>$suppliers,
            "locations"         =>$locations,
            "depreciation_type" =>$depreciation_type,
            "loc_type" 			=>$loc_type,
            // "status" 			=>$status,
            "manufacturer" 		=>$manufacturer,
        ]);
	}

	/**
     * get location list of filter the type
     * @param Request $request location type id
     * @return location list
     */
    public function getLocation(Request $request)
    {
        if ($request->get('type') > 0) {
			$locations = UserLocationFilter::getLocations();
			$location  = Location::where('status',1)->where('type', $request->get('type'))->whereIn('id',$locations->lists('id'));
            return response()->json($location->lists('name','id'));
        }else{
            return response()->json([]);
        }
    }

    /**
     * Add new entity to database
     *
     * @param ManufacturerRequest $request
     * @return Redirect to menu add
     */
	public function add(AssetRequest $request)
	{       

        $cust_fields        =  $request->get('fields');
        $user               = Sentinel::getUser()->employee_id;

        $tmp2=Carbon::createFromFormat('Y-m-d', $request->get('warranty_from'));
		$warranty_start=$tmp2->toDateTimeString();
		$warranty_end=$tmp2->addMonths($request->get('warranty_period'))->toDateTimeString();

        $inventory_no=UserLocationFilter::inventoryNo($request->get('asset_model'));
		
        try {
            DB::transaction(function () use ($request,$cust_fields,$user,$tmp2,$warranty_start,$warranty_end,$inventory_no) {

        		$asset      = Asset::create([
        			'inventory_no'		=>	$inventory_no,
                    'description'       =>  $request->get('description'),
                    'manual_no'     	=> 	$request->get('manual_no'),
                    'make'     			=> 	$request->get('manufacturer'),
                    'model'     		=> 	$request->get('model'),
                    'asset_no'        	=> 	$request->get('asset_no'),
                    'asset_model_id'  	=> 	$request->get('asset_model'),
                    'supplier_id'     	=> 	$request->get('supplier'),
                    'account_code'    	=> 	$request->get('account_code'),
                    'po_number'       	=> 	$request->get('po_number'),
                    'scrap_value'     	=> 	$request->get('scrap_value'),
                    'purchased_value' 	=> 	$request->get('purchased_value'),
                    'purchased_date'  	=> 	$request->get('purchased_date'),
                    'warranty_from'   	=> 	$warranty_start,
                    'warranty_to'     	=> 	$warranty_end,
                    'warranty_period' 	=> 	$request->get('warranty_period'),
                    'recovery_period' 	=> 	$request->get('recovery_period'),
                    'depreciation_id' 	=> 	1,
                    'user_id'         	=> 	$user
                ]);
       

                if($asset){

                    $emp_tmp=Sentinel::getUser()->employee_id;

                    $loc_tmp=EmployeeLocation::where('employee_id',$emp_tmp)->first();

                    if($loc_tmp){
                        $from_loc=$loc_tmp->location_id;
                    }else{
                        $from_loc=1;
                    }

                    $issueNote = IssueNote::create([
                        'from_location_id' => $from_loc,
                        'to_location_id'   => $request->get('location'),
                        'user_id'          => $emp_tmp,
                    ]);

                    if(!$issueNote){
                        throw new TransactionException('Issue Note faild', 105);
                    }else{
                        $issue_details = IssueNoteDetails::create([
                            'asset_id' => $asset->id,
                            'issue_note_id' => $issueNote->id,
                        ]);

                        if(!$issue_details){
                            throw new TransactionException('Issue Detail faild', 106);
                        }else{

                            $tt_loc=Location::find($issueNote->to_location_id);

                            $emp=Sentinel::getUser()->find($issueNote->user_id)->username;

                            $dd=Carbon::now()->format('Y-m-d');

                            $ct=IssueNote::where('created_at','like', '%' .$dd. '%')->get()->count();

                            $issueNote->issue_note_no = 'ISN-'.$ct.'/'.$emp.'/'.$tt_loc->code.'/'.$dd;

                            $issueNote->save();
                        }                      
                    }


                    if(count($cust_fields)>0){
                        foreach ($cust_fields as $device_model_id => $deviceModels) {
                            $devices = Devices::create([
                                'asset_id'        => $asset->id, 
                                'device_model_id' => $device_model_id
                            ]);

                            if(!$devices){
                                throw new TransactionException('Something wrong.Supplier wasn\'t created', 101);
                            }
                            
                            foreach ($deviceModels as $fieldset_id => $fieldsets) {
                                //array_push($dd, ["device_model_id"=>$device_model_id,"field_id"=>$fieldset_id,"value"=>$fieldsets[0]]);
                                $device_fieldset_values = FieldSetValues::create([
                                    'device_id'   => $device_model_id, 
                                    'fieldset_id' => $fieldset_id,
                                    'value'       => $fieldsets[0]
                                ]);

                                if(!$device_fieldset_values){
                                    throw new TransactionException('Something wrong.Supplier wasn\'t created', 102);
                                }
                            }
                        }

                        $asset_transaction = AssetTransaction::create([
        					'asset_id'    => $asset->id,
        					'status_id'   => 1,
        					'location_id' => $request->get('location'),
                            'user_id'     => $user,
        					'type'     => 'Upload To',
                        ]);

                        if(!$asset_transaction){
                            throw new TransactionException('Something wrong.Supplier wasn\'t created', 103);
                        }                        

                        $aa = AssetBarcode::create([
                            'asset_id'        => $asset->id,
                            'status'          => 1,
                            'barcode_type_id' => BARCODE_TYPE_ID,
                            'user_id'         => $user,
                        ]);   

                        if(!$aa){
                            throw new TransactionException('Something wrong.Supplier wasn\'t created', 104);
                        }            
                    }

                    $make = Manufacturer::find($asset->make);
                    $asset->make = ($make)?$make->name:null;
                    $assModel = AssetModal::find($request->get('asset_model'));
                    $asset->asset_model_id = ($assModel)?$assModel->name:null;
                    $sup = Supplier::find($request->get('supplier'));
                    $asset->supplier_id = ($sup)?$sup->name:null;
                    $us = Sentinel::getUser()->username;
                    $asset->user_id = ($us)?$us:null;
                    $asset->location = $tt_loc->name;

                    $this->auditLogger->addLog('Add Asset', 'New Entry', $asset->id, null, $asset->toJson());
                }else{
                    throw new TransactionException('Something wrong.Supplier wasn\'t created', 100);
                }
            });

            return redirect( 'asset/add' )->with([ 'success' => true,
                        'success.message' => 'Service added successfully!',
                        'success.title'   => 'Well Done!']);
        } catch (TransactionException $e) {
            Log::info($e);
            return redirect('supplier/add')->with([ 'error' => true,
                'error.message'=> 'Supplier not created!',
                'error.title' => 'Well Done!' ]);
        } catch (Exception $e) {
            Log::info($e);
            return redirect('supplier/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error!',
                'error.title' => 'Well Done!' ]);
        }
    }

    public function checkForDispose(Request $request)
    {
        $asset_id=$request->asset_id;
        $res=RequestDetail::where('request_type_id',3)
                    ->where('status',2)
                    ->whereIn('asset_no',function($query)use($asset_id){
                        $query->select('asset_no')->from('asset')->where('id',$asset_id);
                    })
                    ->first();
        if($res){
            return response()->json(['status' => '1']);
        }else{
            return response()->json(['status' => '0']);
        }
    }

    public function putToDamage(Request $request)
    {
    	
        try{
            
            DB::transaction(function () use ($request) {

                $trans=AssetTransaction::where('asset_id',$request->get('asset_id'))->whereNull('deleted_at')->first();
                
                if($trans){
                    $trans->delete();

                    $ass = Asset::find($request->asset_id);

        			$asset_disppose = AssetTransaction::create([
        				'asset_id'    => $request->asset_id,
        				'status_id'   => 6,
        				'location_id'=>$trans->location_id,
                        'location_type'=>'location',
                        'user_id'=>Sentinel::getUser()->employee_id,
                        'type'=>'Disposeed At'
        	        ]);

                    if(!$asset_disppose){
                        throw new TransactionException("couldn't dispose asset", 100);
                    }

                    $loc = Location::find($trans->location_id);

                    $asset_disppose->asset_id = $ass->inventory_no;
                    $asset_disppose->status_id = 'Disposed';
                    $asset_disppose->location_id = $loc->name;
                    $asset_disppose->user_id = Sentinel::getUser()->username;

                    $this->auditLogger->addLog('Asset', 'Dispose', $request->asset_id, null, $asset_disppose->toJson());
                }else{
                    throw new TransactionException("couldn't find asset", 101);
                }
            });

    	   return response()->json(['status' => 'success']);

        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                return response()->json(['status' => 'error','msg'=>"Transaction error. Asset couldn't Dispose"]);
            }else if ($e->getCode() == 101) {
                return response()->json(['status' => 'error','msg'=>"Asset couldn't found"]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error','msg'=>"Transaction error"]);
        }    		 
    }

    public function detailView($id)
    {

        $tmp=AssetCustom::getAssetDeviceFieldForView(Asset::find($id));

        $details = Asset::with(['supplier','barcode.barcodetype','manufacturer','upgradehistory.asset.assetmodel'])->find($id);

        $assignto=AssetUpgrade::where('upgrade_asset_id',$id)->whereNull('ended_at')->with(['mainAsset.assetmodel'])->get()->pluck('mainAsset');
        if(count($assignto)>0){
            $assignto=array_flatten($assignto)[0];
        }else{
            $assignto=[];
        }
        
        $timeline = AssetTransaction::withTrashed()
                ->with([
                    'location',
                    'status',
                    'employee.Location.location',
                    'user'
                ])->where('asset_id','=',$id)->orderBy('id','DESC')->get();

        $license = License::leftJoin('software_license_assign',function($qry1){
            $qry1->on('software_license.id','=','software_license_assign.software_license_id');
        })->where('software_license_assign.asset_id',$id)->with(['supplier', 'manufacture'])->get();

        if(count($details)>0){
            return view( 'assetManage::asset.view' )
                ->with([
                    "details"       =>$details,
                    'timeline'      =>$timeline,
                    'assetDetails'  =>$tmp,
                    'assignto'      =>$assignto,
                    'license'       =>$license
                ]);
        }else{
            return view( 'errors.404' );               
                
        }

    }

    public function printDetails($id)
    {
        $asset    = Asset::with(['supplier','barcode.barcodetype'])->find($id);
        $timeline = AssetTransaction::withTrashed()->with(['location','status'])->where('asset_id','=',$id)->orderBy('created_at','DESC')->get();

        if($asset){
            $page1 =  view('barcodeManage::print.barcode')->with(['asset'=>$asset])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate($asset);
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output($asset->asset_no.".pdf", 'I');
    }

	public function listView(Request $request)
    {
        $asset_models = AssetModal::where('status',1)->get();
        $status = Status::all();
        $locations = UserLocationFilter::getLocations();

        $sub_loc = 0;

        $location  = $request->location==null?0:$request->location;
        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel']);

        $data  = $data->whereIn('id',function($cc) use($locations)
        {
            $cc->select('asset_id')
            	->from('asset_transaction')
            	->whereNull('deleted_at')
            	->whereIn('location_id',$locations->lists('id'));
        });


        if($location!=null && $location>0)
        {
            if($request->sub_loc && $request->sub_loc=='on')
            {
                $all_locations = UserLocationFilter::getSubLocations($location);
                $sub_loc = 1;
            }else{
                $all_locations[] = $location;
                $sub_loc = 0;
            }

            $data  = $data->whereIn('id',function($aa) use($all_locations)
            {
                $aa->select('asset_id')->from('asset_transaction')->whereIn('location_id',$all_locations)->whereNull('deleted_at');
            });
        }

        $inv_no = $request->inv_no;
        if($inv_no!=null && $inv_no!=""){
            $data = $data->where('inventory_no', 'like', '%' .$inv_no. '%');
        }

        $ser_no = $request->ser_no;
        if($ser_no!=null && $ser_no!=""){
            $data = $data->where('asset_no', 'like', '%' .$ser_no. '%');
        }

        $stat = $request->status;
        if($stat!=null && $stat!="" && $stat>0){
            $data  = $data->whereIn('id',function($aa) use($stat)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
            });
        }else{
            $data  = $data->whereIn('id',function($aa) use($stat)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('status_id','!=',6)->whereNull('deleted_at');
            });
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
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

        // return $notcheckIn;

        $data=$data->orderBy('inventory_no','ASC');

        $data = $data->paginate(20);

        $count=$data->total();

        $locations=UserLocationFilter::locationHierarchy();

        return view('assetManage::asset.list')->with([
            'data'=>$data,
        	'row_count'=>$count,
        	'asset_models'=>$asset_models,
        	'locations'=>$locations,
            'status'=>$status,
        	'notChecked'=>$notcheckIn,
        	'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'status'=>$stat,'model'=>$model,'sub_loc'=>$sub_loc]
        	]);
	}	

	public function jsonFields(Request $request)
    {
		if ($request->ajax()) {
			$id = $request->input('id');
			$fields = AssetModal::with('deviceModels.fieldsets')->find($id);

            $inventory_no=UserLocationFilter::inventoryNo($id);

			return response()->json(['data' => $fields,'inventory'=>$inventory_no]);
		} else {
			return response()->json(['status' => 'error']);
		}
	}

	public function status(Request $request) 
    {
	}

	public function delete(Request $request)
    {
		if ($request->ajax()) {
			$id = $request->input('id');
			$service = Service::find($id);
			if ($service) {
				$service->delete();
				return response()->json(['status' => 'success']);
			} else {
				return response()->json(['status' => 'invalid_id']);
			}
		} else {
			return response()->json(['status' => 'not_ajax']);
		}
	}

	public function trashListView() 
	{
		return view('manufacturerManage::manufacturer.trash');
	}

	public function restore(Request $request) 
	{
		if ($request->ajax()) {
			$id = $request->input('id');
			try {
				$manufact = ServiceType::withTrashed()->find($id)->restore();
				return response()->json(['status' => 'success']);
			} catch (Exception $ex) {
				return response()->json(['status' => 'error']);
			}
		} else {
			return response()->json(['status' => 'not_ajax']);
		}
	}

	public function jsonTrashList(Request $request) 
    {
		if ($request->ajax()) {
			$data = ServiceType::onlyTrashed()->get();

			$jsonList = array();
			$i = 1;
			foreach ($data as $key => $val) {
				$dd = array();
				array_push($dd, $i);

				if ($val->name != '') {
					array_push($dd, $val->name);
				} else {
					array_push($dd, "-");
				}

				array_push($dd, '<a href="#" class="red item-trash" data-id="' . $val->id . '" data-toggle="tooltip" data-placement="top" title="Restore Manufacturer"><i class="fa fa-reply"></i></a>');

				array_push($jsonList, $dd);
				$i++;
			}
			return Response::json(array('data' => $jsonList));

			return Response::json(array('data' => $jsonList));
		} else {
			return Response::json(array('data' => []));
		}
	}

	public function editView($id) 
    {

        $asset=Asset::with(['assetTransaction.location.locationType','assetmodel.deviceModels.fieldsets.values'])->find($id);

        $asset_models       =   AssetModal::where('status',1)->lists('name','id')->prepend('Select Asset Modal', '0');

        $depreciation_type  =   DepreciationType::lists('name','id');
        
        $suppliers          =   Supplier::whereIn('status',[0,1])->lists('name','id')->prepend('Select Supplier', '0');
        
        $locations          =   Location::where('id',$asset->assetTransaction->location->id)->where('status',1)->lists('name','id');
        
        $loc_type           =   LocationType::where('status',1)->lists('name','id')->prepend('Select Location Type', '0');
        
        $manufacturer       =   Manufacturer::whereIn('status',[0,1])->lists('name','id')->prepend('Select Manufacturer', '0');

        $tmp=AssetCustom::getAssetDeviceField(Asset::find($id));

        return view( 'assetManage::asset.edit' )->with([
            "asset_models"      =>$asset_models,
            "suppliers"         =>$suppliers,
            "locations"         =>$locations,
            "depreciation_type" =>$depreciation_type,
            "loc_type"          =>$loc_type,
            "manufacturer"      =>$manufacturer,
            "asset"             =>$asset,
            "asset_details"     =>$tmp
        ]);
	}

	public function edit(Request $request, $id) 
    {
        try {
            DB::transaction(function () use ($request,$id) {

                $asset=Asset::with(['assetTransaction'])->find($id);

                if($asset){
                    $old = $asset->replicate();
                    $asset->inventory_no=$request->inventory_no;
                    $asset->asset_no=$request->asset_no;
                    $asset->make=$request->manufacturer;
                    $asset->model=$request->model;
                    $asset->supplier_id=$request->supplier;
                    $asset->po_number=$request->po_number;
                    $asset->purchased_date=$request->purchased_date;
                    $asset->account_code=$request->account_code;
                    $asset->scrap_value=$request->scrap_value;
                    $asset->purchased_value=$request->purchased_value;
                    
                    $asset->warranty_period=$request->warranty_period;
                    $asset->warranty_from=$request->warranty_from;

                    $tmp2=Carbon::createFromFormat('Y-m-d', $request->warranty_from);
                    $warranty_start=$tmp2->toDateString();
                    $warranty_end=$tmp2->addMonths($request->warranty_period)->toDateString();

                    $asset->warranty_to=$warranty_end;
                    
                    $asset->recovery_period=$request->recovery_period;
                    $asset->manual_no=$request->manual_no;
                    $asset->description=$request->description;

                    $asset->save();

                    $data=$request->all();

                    $fields = array();
                    foreach ($data as $key => $value) {
                        if (strpos($key, 'field_id_') === 0) {
                            
                            $fields[]=explode('_', $key)[2];
                        }
                    }

                    if($fields){

                        foreach ($fields as $value) {
                            if($request->get('field_id_'.$value)){

                                $device_id=Devices::where('asset_id',$asset->id)->first()->id;

                                $fieldSetValues=FieldSetValues::where('device_id',$device_id)->where('fieldset_id',$value)->first();
                                if($fieldSetValues){                                    
                                    $fieldSetValues->value=$request->get('field_id_'.$value);
                                    $fieldSetValues->save();
                                }else{
                                    $fieldSetValues=FieldSetValues::create([
                                        'device_id'=>$device_id,
                                        'fieldset_id'=>$value,
                                        'value'=>$request->get('field_id_'.$value)
                                    ]);

                                    if(!$fieldSetValues){
                                        throw new TransactionException('Asset field not Created', 100);
                                    }
                                               
                                }

                            }else{

                                $device_id=Devices::where('asset_id',$asset->id)->first()->id;

                                $fieldSetValues=FieldSetValues::where('device_id',$device_id)->where('fieldset_id',$value)->first();
                                if($fieldSetValues){                                    
                                    $fieldSetValues->value=$request->get('field_id_'.$value);
                                    $fieldSetValues->save();
                                }
                                // throw new TransactionException('Asset field not submited', 101);
                            }
                        }

                    }else{
                        throw new TransactionException('Asset field cannot find', 102);
                    }

                }else{
                    throw new TransactionException('Asset cannot find', 103);
                }

                $tt_loc = Location::find($asset->assetTransaction->location_id);

                $make = Manufacturer::find($asset->make);
                $asset->make = ($make)?$make->name:null;
                $assModel = AssetModal::find($asset->asset_model_id);
                $asset->asset_model_id = ($assModel)?$assModel->name:null;
                $sup = Supplier::find($asset->supplier_id);
                $asset->supplier_id = ($sup)?$sup->name:null;
                $us = Sentinel::getUser()->username;
                $asset->user_id = ($us)?$us:null;
                $asset->location = $tt_loc->name;

                $make = Manufacturer::find($old->make);
                $old->make = ($make)?$make->name:null;
                $assModel = AssetModal::find($old->asset_model_id);
                $old->asset_model_id = ($assModel)?$assModel->name:null;
                $sup = Supplier::find($old->supplier_id);
                $old->supplier_id = ($sup)?$sup->name:null;
                $us = Sentinel::getUser()->username;
                $old->user_id = ($us)?$us:null;
                $old->location = $tt_loc->name;

                $this->auditLogger->addLog('Asset', 'Edit', $asset->id, $old->toJson(), $asset->toJson());
            });

            return redirect( 'asset/list' )->with([ 'success' => true,
                        'success.message' => 'Service added successfully!',
                        'success.title'   => 'Well Done!']);
        } catch (TransactionException $e) {
            Log::info($e);
            return redirect('asset/list')->with([ 'error' => true,
                'error.message'=> 'Asset not updated!',
                'error.title' => 'Error!' ]);
        } catch (Exception $e) {
            Log::info($e);
            return redirect('asset/list')->with([ 'error' => true,
                'error.message'=> 'Asset not updated!',
                'error.title' => 'Error!' ]);
        }
	}

	public function uploadAssetView(Request $request)
    {
		$asset_models      = AssetModal::lists('name','id');        
        $asset_models->prepend('Select Asset Modal', '0');

        $locations=UserLocationFilter::locationHierarchy();

        return view( 'assetManage::asset.upload' )->with(["asset_models"=>$asset_models,"locations"=>$locations]);		
	}

	public function jsonListLocation(Request $request)
    {
		$aa = UserLocationFilter::getLocations();
		$locations         = Location::with('locationType')->whereIn('id',$aa->lists('id'))->get();       

		$list=[];
        foreach ($locations as $value) {
        	$dd=[];

        	$dd['name']=$value->name." - ".$value->locationType->name;
        	$dd['id']=$value->id;

        	array_push($list,$dd);
        }        

        return Response::json($list);
	}

	public function jsonListExcelDetail(Request $request)
    {
		
		$id = $request->input('modal');
		$loc = $request->input('location');

		$fields = AssetModal::with('deviceModels.fieldsets')->find($id);

		$headers=['Description','Manual No','Manufacturer','Model','Asset No','Supplier','Account Code','PO No','Purchased Date','Scrap Value','Purchased Value','Warranty Begin','Warranty Period','Recovery Period'];

		foreach ($fields->deviceModels as $value) {			
			foreach ($value->fieldsets as $value2) {
				$headers[]=$value2->name;
			}
		}

		$date=date('Y-m-d');

		$location=Location::find($loc);

		$filename="Upload ".$fields->name." Asset of ".$location->name." ".$date;

		// Excel::create($filename, function($excel) use($headers) {

		//     $excel->sheet('Sheetname', function($sheet) use($headers){

		//         $sheet->fromArray($headers);

		//     });

		// })->store('xls', storage_path('excel/exports'));

		Excel::create($filename, function($excel) use($headers) {

		    $excel->sheet('Sheetname', function($sheet) use($headers){

		        $sheet->fromArray($headers);

		    });

		})->download('xls');

        // return Response::json([]);
	}

    private function containsNumbers($String){
        return preg_match('/\\d/', $String) > 0;
    }

    private function hasSpecialChar($string){
	    return preg_match('/[^\s@()-_A-Za-z0-9]/',$string);
    }

	public function uploadAsset(Request $request)
	{
        try {
            DB::transaction(function () use ($request) {

                $path = $request->file('inputficons1')->getRealPath();

                $data = Excel::load($path, function($reader) { $reader->formatDates(false); })->get();

				$modal=$request->get('asset_model');

                $modal_status=AssetModal::find($modal);

                if($modal_status->status==1){

    				$logged_user=Sentinel::getUser()->employee_id;

    				$loc=$request->get('location');

    				$fields = AssetModal::with('deviceModels.fieldsets')->find($modal);

    				$field=[];
    				foreach ($fields->deviceModels as $value) {			
    					foreach ($value->fieldsets as $value2) {
    						$tmp=[];
    						$tmp['name']=strtolower(str_replace(' ', '_', $value2->name));;
    						$tmp['id']=$value2->id;
    						array_push($field, $tmp);
    					}
    				}

    				if(count($data)>0){

    					// $from_loc=Location::whereNull('parent')->where('type',1)->first();

                        $emp_tmp=Sentinel::getUser()->employee_id;

                        $loc_tmp=EmployeeLocation::where('employee_id',$emp_tmp)->first();

                        if($loc_tmp){
                            $from_loc=$loc_tmp->location_id;
                        }else{
                            $from_loc=1;
                        }

    					$issueNote = IssueNote::create([
    						'from_location_id' => $from_loc,
    						'to_location_id'   => $loc,
    						'user_id'          => $emp_tmp,
    	                ]);

    	                if(!$issueNote){
    						throw new TransactionException('Issue Note faild', 106);
    					}

    					foreach ($data as $value) {

                            $s_status=0;
                            $m_status=0;

                            if(!isset($value['supplier'])){
                                throw new TransactionException('Supplier Missing in Excel', 200);
                            }

                            if($this->hasSpecialChar($value['supplier'])){
                                throw new TransactionException('Supplier cannot have special characters', 200);
                            }

                            if($this->containsNumbers($value['supplier'])){
                                throw new TransactionException('Supplier cannot have numeric values', 200);
                            }

                            if(!isset($value['manufacturer'])){
                                throw new TransactionException('Manufacturer Missing in Excel', 201);
                            }

                            if($this->hasSpecialChar($value['manufacturer'])){
                                throw new TransactionException('Manufacturer cannot have special characters', 200);
                            }

                            if(!isset($value['model'])){
                                throw new TransactionException('Model Missing in Excel', 202);
                            }

                            if($this->hasSpecialChar($value['model'])){
                                throw new TransactionException('Model cannot have special characters', 200);
                            }

                            if(!isset($value['asset_no'])){
                                throw new TransactionException('Serial No Missing in Excel', 203);
                            }

                            if($this->hasSpecialChar($value['asset_no'])){
                                throw new TransactionException('Asset No. cannot have special characters', 200);
                            }

                            if(!isset($value['purchased_date'])){
                                throw new TransactionException('Purchased Date Missing in Excel', 204);
                            }

                            if(!date_create_from_format('d/m/Y',$value['purchased_date'])){
                                throw new TransactionException($value['purchased_date'], 204);
                            }

                            if(!isset($value['purchased_value'])){
                                throw new TransactionException('Purchased Value Missing in Excel', 205);
                            }

                            if(!isset($value['warranty_begin'])){
                                throw new TransactionException('Warranty Begin Missing in Excel', 206);
                            }

                            if(!date_create_from_format('m/d/Y',$value['warranty_begin'])){
                                throw new TransactionException('Invalid date format', 206);
                            }

                            if(!isset($value['warranty_period'])){
                                throw new TransactionException('Warranty Period Missing in Excel', 207);
                            }

                            if(!isset($value['recovery_period'])){
                                throw new TransactionException('Recovery Period Missing in Excel', 208);
                            }

    						$supplier=Supplier::where('name',$value['supplier'])->first();

    						$supplier_id='';

    						if($supplier){
                                if($supplier->status==1){
    							     $supplier_id=$supplier->id;	
                                }else{
                                    $s_status++;
                                }
    						}else{
    							$sup=Supplier::create([
    								'name'=>$value['supplier']
    							]);

                                if(!$sup){
                                    throw new TransactionException('Empty Row', 400);
                                }

    							$supplier_id=$sup->id;
    						}

    						$manufacturer=Manufacturer::where('name',$value['manufacturer'])->first();

    						$manufacturer_id='';

    						if($manufacturer){
                                if($manufacturer->status==1){
                                    $manufacturer_id=$manufacturer->id;	
                                }else{
                                    $m_status++;
                                }

    						}else{
    							$manu=Manufacturer::create([
    								'name'=>$value['manufacturer'],
    								'user_id'=>Sentinel::getUser()->employee_id
    							]);
    							$manufacturer_id=$manu->id;
    						}

    						$depreciation=DepreciationType::where('name','like','Straight-Line Depreciation')->first();

    						$depreciation_id=$depreciation->id;				

    						if(isset($value['asset_no']) || $value['asset_no']!=""){


    							if(array_key_exists('account_code', $value)){
    								$account_code=$value['account_code'];
    							}else{
    								$account_code="";
    							}

    							if(array_key_exists('po_no', $value)){
    								$po_no=$value['po_no'];
    							}else{
    								$po_no="";
    							}

    							if(array_key_exists('scrap_value', $value)){
    								$scrap_value=$value['scrap_value'];
    							}else{
    								$scrap_value="";
    							}

                                if(array_key_exists('description', $value)){
                                    $description=$value['description'];
                                }else{
                                    $description="";
                                }

    							$inv_no=UserLocationFilter::inventoryNo($modal);

                                if($inv_no==1){
                                    $inv_no="";
                                }

                                $tpp=Asset::where('inventory_no',$inv_no)->first();
                                if(is_numeric($value['asset_no'])){
                                    $tpn=Asset::where('asset_no',(int)$value['asset_no'])->first();
                                    $value['asset_no'] = (int)$value['asset_no'];
                                }else{
                                    $tpn=Asset::where('asset_no',$value['asset_no'])->first();                                    
                                    $value['asset_no'] = $value['asset_no'];
                                }

                                if(!$tpn){
                                    if(!$tpp){

                                        /*$y= $value['warranty_begin']->year;
                                        $m= $value['warranty_begin']->month;
                                        $d= $value['warranty_begin']->day;*/

                                        $tmp2 = Carbon::instance(date_create_from_format('d/m/Y',$value['warranty_begin']));
                                        $tmp1 = Carbon::instance(date_create_from_format('d/m/Y',$value['purchased_date']));

                                        $warranty_start=$tmp2->toDateTimeString();

                                        $warranty_end=$tmp2->addMonths($value['warranty_period'])->toDateTimeString();

                                        if($s_status==0 && $m_status==0){
            								$asset = Asset::create([
            									'inventory_no'		 =>		$inv_no,
                                                'description'        =>     $description,
            									'manual_no'		     =>		$value['manual_no'],
            									'make'				 =>		$manufacturer_id,
            									'model'				 =>		$value['model'],
            									'asset_no'			 =>		$value['asset_no'],
            									'asset_model_id'	 =>		$modal,
            									'supplier_id'		 =>		$supplier_id,
            									'account_code'		 =>		$account_code,
            									'po_number'			 =>		$po_no,
            									'scrap_value'		 =>		$scrap_value,
            									'purchased_date'	 =>		$tmp1->toDateTimeString(),
            									'purchased_value'	 =>		$value['purchased_value'],
            									'warranty_from'		 =>		$warranty_start,
            									'warranty_to'		 =>		$warranty_end,
            									'recovery_period'	 =>		$value['warranty_begin'],
            									'recovery_period'	 =>		$value['recovery_period'],
            									'depreciation_id'	 =>		$depreciation_id,
            									'user_id'			 =>		$logged_user
            								]);

            								if($asset){
            									$device=Devices::create(['asset_id'=>$asset->id,'device_model_id'=>$modal]);

            									if($device){
            										$fieldset=[];

            										foreach ($field as $tmp) {
            											$tp=[];
            											$tp['device_id']=$device->id;
            											$tp['fieldset_id']=$tmp['id'];

                                                        if(isset($value[$tmp['name']])){
                                                            $tp['value']=$value[$tmp['name']];
                                                        }else{
                                                            $tp['value']="";
                                                        }

            											array_push($fieldset, $tp);
            										}

            										FieldSetValues::insert($fieldset);
            									}

            									$checkout = AssetTransaction::create([
            				                        'asset_id' => $asset->id,
            				                        'location_id' => $loc,
            				                        'status_id' => 1,
                                                    'user_id' => $logged_user,
            				                        'type' => 'Upload To'
            				                    ]);

            				                    if(!$checkout){
            										throw new TransactionException('Check Out faild', 107);
            									}

            				                    $issue_details = IssueNoteDetails::create([
            				                        'asset_id' => $asset->id,
            				                        'issue_note_id' => $issueNote->id,
            				                    ]);

            				                    if(!$issue_details){
            										throw new TransactionException('Issue Detail faild', 108);
            									}
            									
            									$assetbarcode=AssetBarcode::create([
            										'asset_id'=>$asset->id,
            										'status'=>1,
            										'user_id'=> $logged_user,
            										'barcode_type_id'=>BARCODE_TYPE_ID,
            									]);

            									if(!$assetbarcode){
            										throw new TransactionException('No name', 105);
            									}

                                                $make = Manufacturer::find($asset->make);
                                                $asset->make = ($make)?$make->name:null;
                                                $assModel = AssetModal::find($request->get('asset_model'));
                                                $asset->asset_model_id = ($assModel)?$assModel->name:null;
                                                $sup = Supplier::find($request->get('supplier'));
                                                $asset->supplier_id = ($sup)?$sup->name:null;
                                                $us = Sentinel::getUser()->username;
                                                $asset->user_id = ($us)?$us:null;
                                                $tt_loc = Location::find($loc);
                                                $asset->location = ($tt_loc)?$tt_loc->name:null;

                                                $this->auditLogger->addLog('Upload Asset', 'New Entry', $asset->id, null, $asset->toJson());

            								}else{
            									throw new TransactionException('No name', 101);
            								}
                                        }else{
                                            if($s_status==0 && $m_status>0){
                                                throw new TransactionException('Manufacturer Disabled', 110);
                                            }else if($s_status>0 && $m_status==0) {
                                                throw new TransactionException('Supplier Disabled', 111);
                                            }else if($s_status>0 && $m_status>0) {
                                                throw new TransactionException('Supplier & Manufacturer Disabled', 112);
                                            }
                                        }
        							}else{
        								throw new TransactionException('No name', 102);	
        							}
                                }else{
                                    throw new TransactionException('Serial No duplicated', 300); 
                                }
    						}else{
    							throw new TransactionException('No name', 103);
    						}
    					}

                        $tt_loc=Location::find($issueNote->to_location_id);

                        $emp=Sentinel::getUser()->find($issueNote->user_id)->username;

                        $dd=Carbon::now()->format('Y-m-d');

                        $ct=IssueNote::where('created_at','like', '%' .$dd. '%')->get()->count();

                        $issueNote->issue_note_no = 'ISN-'.$ct.'/'.$emp.'/'.$tt_loc->code.'/'.$dd;

                        $issueNote->save();

    				}else{
    					throw new TransactionException('No name', 104);
    				}

    				$date=date('Y-m-d');

    				$location=Location::find($loc);

    				$filename="Upload ".$fields->name." Asset of ".$location->name." ".$date;

    				Excel::create($filename, function($excel) use($data) {

    				    $excel->sheet('Sheetname', function($sheet) use($data){

    				        $sheet->fromArray($data);

    				    });

    				})->store('xls', storage_path('excel/exports'));
                }else{
                    throw new TransactionException('Modal Deactivated', 109);
                }

			});
            return Response::json(1);
        } catch (TransactionException $e) {
            //dd($e->getMessage());
            if ($e->getCode() == 100) {
                return Response::json(2);
            }else if ($e->getCode() == 101) {
                return Response::json(3);
            }else if ($e->getCode() == 102) {
                return Response::json(4);
            }else if ($e->getCode() == 103) {
                return Response::json(5);
            }else if ($e->getCode() == 104) {
                return Response::json(6);
            }else if ($e->getCode() == 105) {
                return Response::json(7);
            }else if ($e->getCode() == 106) {
                return Response::json(8);
            }else if ($e->getCode() == 107) {
                return Response::json(9);
            }else if ($e->getCode() == 108) {
                return Response::json(10);
            }else if ($e->getCode() == 109) {
                return Response::json(11);
            }else if ($e->getCode() == 110) {
                return Response::json(12);
            }else if ($e->getCode() == 111) {
                return Response::json(13);
            }else if ($e->getCode() == 112) {
                return Response::json(14);
            }else if ($e->getCode() == 200) {
                return Response::json(200);
            }else if ($e->getCode() == 201) {
                return Response::json(201);
            }else if ($e->getCode() == 202) {
                return Response::json(202);
            }else if ($e->getCode() == 203) {
                return Response::json(203);
            }else if ($e->getCode() == 204) {
                return Response::json(204);
            }else if ($e->getCode() == 205) {
                return Response::json(205);
            }else if ($e->getCode() == 206) {
                return Response::json(206);
            }else if ($e->getCode() == 207) {
                return Response::json(207);
            }else if ($e->getCode() == 208) {
                return Response::json(208);
            }else if ($e->getCode() == 300) {
                return Response::json(300);
            }else if ($e->getCode() == 400) {
                return Response::json(400);
            }
            //return $e;
        } catch (Exception $e) {
            return Response::json(15);
        } catch(QueryException $e){
            return Response::json(500);
        }
	}	

	public function assetAssignView(Request $request)
    {
        $asset_models = AssetModal::all();

        $locations = UserLocationFilter::getLocations();

        $location  = $request->location==null?0:$request->location;
        
        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel']);

        $data  = $data->whereIn('id',function($cc) use($locations)
        {
            $cc->select('asset_id')
                ->from('asset_transaction')
                ->whereNull('deleted_at')
                ->whereIn('location_id',$locations->lists('id'));
        });

        if($location!=null && $location>0){
            $data  = $data->whereIn('id',function($aa) use($location)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
            });
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

        $data=$data->whereNotIn('id',$notcheckIn);

        $data  = $data->whereIn('id',function($aa){
                $aa->select('asset_id')->from('asset_transaction')->whereIn('status_id',[1,2])->whereNull('deleted_at');
            });

        $inv_no = $request->inv_no;
        if($inv_no!=null && $inv_no!=""){
            $data = $data->where('inventory_no', 'like', '%' .$inv_no. '%');
        }

        $ser_no = $request->ser_no;
        if($ser_no!=null && $ser_no!=""){
            $data = $data->where('asset_no', 'like', '%' .$ser_no. '%');
        }

        $stat = $request->status;
        if($stat!=null && $stat!="" && $stat>0){
            $data  = $data->whereIn('id',function($aa) use($stat)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
            });
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $model = $request->model;
        if($model!=null && $model!="" && $model>0){
            $data  = $data->where('asset_model_id',$model);
        }

        $data = $data->paginate(20);

        $count=$data->total();

        $employee=UserLocationFilter::getLocationUsersExceptLogged(Sentinel::getUser()->employee_id);

        $locations=UserLocationFilter::locationHierarchy();
        
        return view('assetManage::user.list')->with([
            'data'=>$data,
            'row_count'=>$count,
        	'asset_models'=>$asset_models,
            'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'model'=>$model,'status'=>$stat],
        	'employees'=>$employee,
            'locations'=>$locations
        	]);
	}

    public function getAssetLocationUsers(Request $request)
    {
        if($request->loc){
            return UserLocationFilter::getAssetLocationEmployee($request->loc);
        }else{
            $loc_id=AssetTransaction::where('asset_id',$request->asset)->whereNull('deleted_at')->first()->location_id;            
            return UserLocationFilter::getAssetLocationEmployee($loc_id);
        }
    }

	public function getEmployee(Request $request)
    {
		return $employee=UserLocationFilter::getLocationUsers($request->get('location'));
	}

	public function assetAssign(Request $request)
    {
		
		try {
            DB::transaction(function () use ($request) {

				$trans=AssetTransaction::where('asset_id',$request->get('asset'))->whereNull('deleted_at')->first();

                if($trans){
                    
                    $trans->delete();               
                    
                    $asset_deployee=AssetTransaction::create([
						'asset_id'=>$request->get('asset'),
						'status_id'=>2,
						'location_type'=>'employee',
						'location_id'=>$trans->location_id,
						'employee_id'=>$request->get('employee'),
                        'user_id'=>Sentinel::getUser()->employee_id,
						'type'=>'Assign To'
					]);

					if($asset_deployee){

                        $tmp=AssetUpgrade::where('asset_id',$request->get('asset'))->whereNull('ended_at')->get();

                        if(count($tmp)>0){

                            foreach ($tmp as $value) {

                                $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                
                                $trns->delete();

                                $sub_asset_deployee=AssetTransaction::create([
                                    'asset_id'=>$value->upgrade_asset_id,
                                    'status_id'=>2,
                                    'location_type'=>'employee',
                                    'location_id'=>$trans->location_id,
                                    'employee_id'=>$request->get('employee'),
                                    'user_id'=>Sentinel::getUser()->employee_id,
                                    'type'=>'Assign To'
                                ]);

                                if(!$sub_asset_deployee){
                                    throw new TransactionException("couldn't deploy to new location", 102);
                                }
                            }

                        }

                    }else{
						throw new TransactionException("couldn't deploy to new location", 103);
                    }
				}else{
					throw new TransactionException("couldn't find asset", 101);
				}

			});
            return Response::json(1);
        } catch (TransactionException $e) {
            if ($e->getCode() == 101) {
                return Response::json(2);
            }else if ($e->getCode() == 102) {
                return Response::json(3);
            }else if ($e->getCode() == 103) {
                return Response::json(4);
            }
        } catch (Exception $e) {
            return Response::json(0);
        }
	}

	public function assetUnAssign(Request $request)
    {
		
		try {
            DB::transaction(function () use ($request) {

				$trans=AssetTransaction::where('asset_id',$request->get('asset'))->whereNull('deleted_at')->first();

				if($trans){
					$trans->delete();

					$unassigned=AssetTransaction::create([
						'asset_id'=>$request->get('asset'),
						'status_id'=>1,
						'location_id'=>$trans->location_id,
						'location_type'=>'location',
                        'user_id'=>Sentinel::getUser()->employee_id,
						'type'=>'Un-Deploy To'
					]);

					if($unassigned){

                        $tmp=AssetUpgrade::where('asset_id',$request->get('asset'))->whereNull('ended_at')->get();

                        if(count($tmp)>0){

                            foreach ($tmp as $value) {

                                $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                
                                $trns->delete();

                                $sub_asset_deployee=AssetTransaction::create([
                                    'asset_id'=>$value->upgrade_asset_id,
                                    'status_id'=>1,
                                    'location_id'=>$trans->location_id,
                                    'location_type'=>'location',
                                    'employee_id'=>$request->get('employee'),
                                    'user_id'=>Sentinel::getUser()->employee_id,
                                    'type'=>'Un-Deploy To'
                                ]);

                                if(!$sub_asset_deployee){
                                    throw new TransactionException("couldn't un-deployee to new location", 102);            
                                }
                            }

                        }

                    }else{
						throw new TransactionException("couldn't un-assigned from Employee", 100);
					}
				}else{
					throw new TransactionException("couldn't find asset", 101);
				}

			});
            return Response::json(1);
        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                return Response::json(0);
            }else if ($e->getCode() == 101) {
                return Response::json(1);
            }else if ($e->getCode() == 102) {
                return Response::json(3);
            }
        } catch (Exception $e) {
            return Response::json(2);
        }
	}

    public function setWarrantyPeriod()
    {
        $res = Asset::whereNull('warranty_period')->select('*',DB::raw('TIMESTAMPDIFF(MONTH, warranty_from, warranty_to) AS difference'))->get();

        foreach ($res as $value) {
            $value->warranty_period=$value->difference;
            $value->save();
        }
    }

    public function assetBulkAssign(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $assets = $request->assets;

                foreach ($assets as $asset) {

                    $trans=AssetTransaction::where('asset_id',$asset)->whereNull('deleted_at')->first();

                    if($trans){
                        
                        $trans->delete();               
                        
                        $asset_deployee=AssetTransaction::create([
                            'asset_id'=>$asset,
                            'status_id'=>2,
                            'location_type'=>'employee',
                            'location_id'=>$trans->location_id,
                            'employee_id'=>$request->get('employee'),
                            'user_id'=>Sentinel::getUser()->employee_id,
                            'type'=>'Assign To'
                        ]);

                        if($asset_deployee){

                            $tmp=AssetUpgrade::where('asset_id',$asset)->whereNull('ended_at')->get();

                            if(count($tmp)>0){

                                foreach ($tmp as $value) {

                                    $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                    
                                    $trns->delete();

                                    $sub_asset_deployee=AssetTransaction::create([
                                        'asset_id'=>$value->upgrade_asset_id,
                                        'status_id'=>2,
                                        'location_type'=>'employee',
                                        'location_id'=>$trans->location_id,
                                        'employee_id'=>$request->get('employee'),
                                        'user_id'=>Sentinel::getUser()->employee_id,
                                        'type'=>'Assign To'
                                    ]);

                                    if(!$sub_asset_deployee){
                                        throw new TransactionException("couldn't deployee to new location", 102);            
                                    }
                                }

                            }

                        }else{
                            throw new TransactionException("couldn't deployee to new location", 103);
                        }
                    }else{
                        throw new TransactionException("couldn't find asset", 101);
                    }

                }

            });
            return Response::json(1);
        } catch (TransactionException $e) {
            if ($e->getCode() == 101) {
                return Response::json(2);
            }else if ($e->getCode() == 102) {
                return Response::json(3);
            }else if ($e->getCode() == 103) {
                return Response::json(4);
            }
        } catch (Exception $e) {
            return Response::json(0);
        }
    }

    public function assetBulkUnAssign(Request $request)
    {
        
        try {
            DB::transaction(function () use ($request) {

                $assets = $request->assets;

                foreach ($assets as $asset) {

                    $trans=AssetTransaction::where('asset_id',$asset)->whereNull('deleted_at')->first();

                    if($trans){
                        $trans->delete();

                        $unassigned=AssetTransaction::create([
                            'asset_id'=>$asset,
                            'status_id'=>1,
                            'location_id'=>$trans->location_id,
                            'location_type'=>'location',
                            'user_id'=>Sentinel::getUser()->employee_id,
                            'type'=>'Un-Deploy To'
                        ]);

                        if($unassigned){

                            $tmp=AssetUpgrade::where('asset_id',$asset)->whereNull('ended_at')->get();

                            if(count($tmp)>0){

                                foreach ($tmp as $value) {

                                    $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                    
                                    $trns->delete();

                                    $sub_asset_deployee=AssetTransaction::create([
                                        'asset_id'=>$value->upgrade_asset_id,
                                        'status_id'=>1,
                                        'location_id'=>$trans->location_id,
                                        'location_type'=>'location',
                                        'employee_id'=>$request->get('employee'),
                                        'user_id'=>Sentinel::getUser()->employee_id,
                                        'type'=>'Un-Deploy To'
                                    ]);

                                    if(!$sub_asset_deployee){
                                        throw new TransactionException("couldn't un-deployee to new location", 102);            
                                    }
                                }

                            }

                        }else{
                            throw new TransactionException("couldn't un-assigned from Employee", 100);
                        }
                    }else{
                        throw new TransactionException("couldn't find asset", 101);
                    }
                }

            });
            return Response::json(1);
        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                return Response::json(0);
            }else if ($e->getCode() == 101) {
                return Response::json(1);
            }else if ($e->getCode() == 102) {
                return Response::json(3);
            }
        } catch (Exception $e) {
            return Response::json(2);
        }
    }

    public function assetDeleteView(Request $request)
    {
        return view('assetManage::asset.delete');      
    }

    public function deleteAssets(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $path = $request->file('inputficons1')->getRealPath();

                $data = Excel::load($path, function($reader) {})->get();

                foreach ($data as $value) {
                    $inv_no = $value['inventory_no'];
                    $asset_no = $value['asset_no'];

                    $asset = Asset::where('inventory_no',$inv_no)->where('asset_no',$asset_no)->first();

                    if($asset){
                        $_transactions = AssetTransaction::where('asset_id',$asset->id)->withTrashed()->forceDelete();

                        $_devices = Devices::where('asset_id',$asset->id)->get();

                        if(count($_devices)>0){

                            $_device_field_values = FieldSetValues::where('device_id',$_devices[0]->id)->forceDelete();

                            foreach ($_devices as $value) {
                                $value->forceDelete();
                            }
                        }

                        GrnDetails::where('asset_id',$asset->id)->forceDelete();
                        IssueNoteDetails::where('asset_id',$asset->id)->forceDelete();

                        $asset->forceDelete();

                        // return ['trans'=>$_transactions,'device'=>$_devices,'Fields'=>$_device_field_values];
                    }
                }

                });
            return Response::json(1);
        } catch (TransactionException $e) {
            return Response::json($e);
        } catch (Exception $e) {
            return Response::json($e);
        } catch(QueryException $e){
            return Response::json($e);
        }

    }

}