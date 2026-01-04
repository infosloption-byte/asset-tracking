<?php
namespace Sammy\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;
use Response;
use Sammy\ManufacturerManage\Models\Manufacturer;
use Sentinel;
use App\Classes\PdfTemplate;

use App\Models\Devices;
use App\Models\FieldSetValues;
use App\Models\FieldSet;
use App\Models\AssetTransaction;
use App\Models\AssetBarcode;
use App\Models\BarcodeCategory;
use App\Models\Status;
use App\Models\AssetModelBasicField;
use App\Models\RequestType;
use App\Models\LocationType;

use App\Classes\AssetCustom;

use Sammy\AssetManage\Http\Requests\AssetRequest;
use Sammy\AssetManage\Models\Asset;
use Sammy\AssetManage\Models\DepreciationType;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\ConfigManage\Models\AppConfig;
use Sammy\Location\Models\Location;
use Sammy\SupplierManage\Models\Supplier;
use Sammy\Permissions\Models\Permission;
use Sammy\RequestManage\Models\RequestDetail;

use Sammy\UserManage\Models\User;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\EmployeeManage\Models\EmployeeType;
use Sammy\EmployeeManage\Models\EmployeeDesignation;
use Sammy\Location\Models\EmployeeLocation;
use Sammy\UserRoles\Models\UserRole;
use Sammy\UserManage\Models\RoleUsers;

use Sammy\AssetUpgradeManage\Models\AssetUpgrade;
use Sammy\AssetSoftwareManage\Models\LicenseDetails;
use Sammy\AssetSoftwareManage\Models\License;

use App\Classes\UserLocationFilter;

use DB;
use Excel;

class ReportsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	|  Asset Controller
	|--------------------------------------------------------------------------
	|
	*/

    /**
     * Create a new controller instance.
     *
     * @return \Sammy\MenuManage\Http\Controllers\ManufacturersController
     */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function depreciationAssetList(Request $request)
    {
        $asset_models = AssetModal::all();
        $status = Status::all();
        $locations = UserLocationFilter::getLocations();

        $location  = $request->location==null?0:$request->location;
        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel']);

        $data  = $data->whereIn('id',function($aa) use($locations)
        {
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        });

        if($location!=null && $location>0){
            $data  = $data->whereIn('id',function($aa) use($location)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
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

        return view('reports::reports.list')->with([
            'data'=>$data,
            'asset_models'=>$asset_models,
            'locations'=>$locations,
            'status'=>$status,
            'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'status'=>$stat,'model'=>$model]
            ]);
    }

    public function depreciation($id)
    {
        $asset = Asset::with(['depreciationtype'])->find($id);
        $locations = UserLocationFilter::getLocations();

        $history = Asset::with(['upgradehistory.asset.transaction.status','upgradehistory.asset.transaction.location','depreciationtype','transaction.status','transaction.location','assetmodel'])->selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->whereIn('id',function($aa) use($locations){
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        })->find($id);

        if(!$asset){
            return response()->view("errors.404");
        }
        return view( 'reports::reports.depreciation')->with(['asset'=>$asset,'history'=>$history]);
    }

    public function getAssetData(Request $request)
    {
        if($request->ajax()){
            $asset = Asset::with(['depreciationtype','upgrade.asset','upgrade'=>function($q){
                $q->selectRaw('*,DATE_FORMAT(upgrade_at, "%Y") upgrade_year,DATE_FORMAT(upgrade_at, "%m") upgrade_month');
            }])->find($request->id);

            return response()->json(['data' => $asset]);
        }else{
            return response()->json(['status' => 'error']);
        }
	}

    public function asset_location(Request $request)
    {
        // return $request->all();
        if($request->sub_loc && $request->sub_loc=='on'){
            $sub_loc = 1;
        }else{
            $sub_loc = 0;
        }

        $qry ='
            SELECT location.id,CONCAT(location.name," (",location_type.`name`,")") as location 
            FROM location
            LEFT JOIN location_type ON location.type=location_type.id';

        $location = DB::select(DB::raw($qry));

        $locations=UserLocationFilter::locationHierarchy();

        return view( 'reports::reports.asset_location')
            ->with([
                'location'=>array_pluck($location,"location","id"),
                'locations'=>$locations,
                'old'=>$sub_loc
            ]);
    }

    public function getAssetDataInLocation(Request $request)
    {
        if($request->ajax()){
            
            $id=$request->id;

            if($request->sub_loc && $request->sub_loc=='on'){
                $id = UserLocationFilter::getSubLocations($id)->toArray();
                $id = implode(',',$id);
                $sub_loc = 1;
            }else{
                $id = $id;
                $sub_loc = 0;
            }
            
            $qry ='SELECT
                        asset_modal.id,
                        asset_modal.`name`,
                        count(asset.id) as total_asset,
                        sum(asset.purchased_value) as total_asset_val
                    FROM
                        asset
                    LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                    LEFT JOIN(
                            SELECT
                                asset_transaction.asset_id,
                                asset_transaction.status_id as ass_status,
                                asset_transaction.location_id  as location
                            FROM
                                asset_transaction
                            where deleted_at is null
                        )tmp1 on tmp1.asset_id = asset.id
                    where tmp1.location in ('.$id.')
                    GROUP BY asset_modal.id
                    ';
            $jsonList = array();

            $locations = DB::select(DB::raw($qry));

            foreach ($locations as $key => $location) {
                $dd = array();
                array_push($dd, $key+1);

                $tt = $location->id;

                $deployed = DB::select(DB::raw('
                    SELECT 
                        COUNT(`asset`.`id`) as count
                    FROM 
                        `asset_transaction`
                            LEFT JOIN
                        `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                    where 
                        `asset_transaction`.`deleted_at` is null
                            AND
                         `asset_transaction`.`location_id` in ('.$id.')
                            AND
                         `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DEPLOY
                ));

                $undeployed = DB::select(DB::raw('
                    SELECT 
                        COUNT(`asset`.`id`) as count
                    FROM 
                        `asset_transaction`
                            LEFT JOIN
                        `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                    where 
                        `asset_transaction`.`deleted_at` is null
                            AND
                         `asset_transaction`.`location_id` in ('.$id.')
                            AND
                         `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_UNDEPLOY
                ));

                $inservice = DB::select(DB::raw('
                    SELECT 
                        COUNT(`asset`.`id`) as count
                    FROM 
                        `asset_transaction`
                            LEFT JOIN
                        `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                    where 
                        `asset_transaction`.`deleted_at` is null
                            AND
                         `asset_transaction`.`location_id` in ('.$id.')
                            AND
                         `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_INSERVICE
                ));

                $disposed = DB::select(DB::raw('
                    SELECT 
                        COUNT(`asset`.`id`) as count
                    FROM 
                        `asset_transaction`
                            LEFT JOIN
                        `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                    where 
                        `asset_transaction`.`deleted_at` is null
                            AND
                         `asset_transaction`.`location_id` in ('.$id.')
                            AND
                         `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DISPOSED
                ));

                if ($location->name != '') {
                    array_push($dd, $location->name);
                } else {
                    array_push($dd, "-");
                }

                if ($location->total_asset != '') {

                    $_total_asset = $deployed[0]->count + $undeployed[0]->count + $inservice[0]->count + $disposed[0]->count;

                    array_push($dd, $location->total_asset);
                } else {
                    array_push($dd, "-");
                }

                if ($location->total_asset_val != '') {
                    array_push($dd, number_format($location->total_asset_val,2));
                } else {
                    array_push($dd, "-");
                }                

                array_push($dd, $deployed[0]->count);
                array_push($dd, $undeployed[0]->count);
                array_push($dd, $inservice[0]->count);
                array_push($dd, $disposed[0]->count);

                array_push($jsonList, $dd);
            }
            
            return response()->json(['data' => $jsonList,'old'=>['sub_loc'=>$sub_loc,'location'=>$id]]);
        }else{
            return response()->json(['status' => 'error']);
        }
    }

    public function downloadAssetLocationExcel(Request $request)
    {

        $location = $request->location;
        $sub_loc = $request->sub_loc;

        if($sub_loc && $sub_loc=='on'){
            $location = UserLocationFilter::getSubLocations($location)->toArray();
            $location = implode(',',$location);
        }else{
            $location = $location;
        }
        
        $qry ='SELECT
                    asset_modal.id,
                    asset_modal.`name`,
                    count(asset.id) as total_asset,
                    sum(asset.purchased_value) as total_asset_val
                FROM
                    asset
                LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                LEFT JOIN(
                        SELECT
                            asset_transaction.asset_id,
                            asset_transaction.status_id as ass_status,
                            asset_transaction.location_id  as location
                        FROM
                            asset_transaction
                        where deleted_at is null
                    )tmp1 on tmp1.asset_id = asset.id
                where tmp1.location in ('.$location.')
                GROUP BY asset_modal.id                    
                ';
        $jsonList = array();

        $results = DB::select(DB::raw($qry));

        foreach ($results as $key => $val) {
            $dd = array();
            
            if ($val->name != '') {
                array_push($dd, $val->name);
            } else {
                array_push($dd, "-");
            }

            if ($val->total_asset != '') {
                array_push($dd, $val->total_asset);
            } else {
                array_push($dd, "-");
            }

            if ($val->total_asset_val != '') {
                array_push($dd, number_format($val->total_asset_val,2));
            } else {
                array_push($dd, "-");
            }

            $tt = $val->id;

            $deployed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DEPLOY
            ));

            $undeployed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_UNDEPLOY
            ));

            $inservice = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_INSERVICE
            ));

            $disposed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DISPOSED
            ));

            array_push($dd, $deployed[0]->count);
            array_push($dd, $undeployed[0]->count);
            array_push($dd, $inservice[0]->count);
            array_push($dd, $disposed[0]->count);

            array_push($jsonList, $dd);
        }

        if($request->location!=0){
            $loc=Location::find($request->location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        $filename="Report of Asset in ".$loc;

        $tmp2 = $jsonList;

        $headers=['Asset Model', 'Total Asset', 'Total Value', 'Deployed', 'Un-Deployed', 'In-service', 'Disposed'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function downloadAssetLocationPdf(Request $request)
    {

        $location = $request->location;
        $sub_loc = $request->sub_loc;

        if($sub_loc && $sub_loc=='on'){
            $location = UserLocationFilter::getSubLocations($location)->toArray();
            $location = implode(',',$location);
        }else{
            $location = $location;
        }
        
        $qry ='SELECT
                    asset_modal.id,
                    asset_modal.`name`,
                    count(asset.id) as total_asset,
                    sum(asset.purchased_value) as total_asset_val
                FROM
                    asset
                LEFT JOIN asset_modal on asset.asset_model_id = asset_modal.id
                LEFT JOIN(
                        SELECT
                            asset_transaction.asset_id,
                            asset_transaction.status_id as ass_status,
                            asset_transaction.location_id  as location
                        FROM
                            asset_transaction
                        where deleted_at is null
                    )tmp1 on tmp1.asset_id = asset.id
                where tmp1.location in ('.$location.')
                GROUP BY asset_modal.id
                ';
        $jsonList = array();

        $results = DB::select(DB::raw($qry));

        foreach ($results as $key => $val) {
            $dd = array();
            
            if ($val->name != '') {
                array_push($dd, $val->name);
            } else {
                array_push($dd, "-");
            }

            if ($val->total_asset != '') {
                array_push($dd, $val->total_asset);
            } else {
                array_push($dd, "-");
            }

            if ($val->total_asset_val != '') {
                array_push($dd, number_format($val->total_asset_val,2));
            } else {
                array_push($dd, "-");
            }

            $tt = $val->id;

            $deployed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DEPLOY
            ));

            $undeployed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_UNDEPLOY
            ));

            $inservice = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_INSERVICE
            ));

            $disposed = DB::select(DB::raw('
                SELECT 
                    COUNT(`asset`.`id`) as count
                FROM 
                    `asset_transaction`
                        LEFT JOIN
                    `asset` on `asset_transaction`.`asset_id` = `asset`.`id`        
                where 
                    `asset_transaction`.`deleted_at` is null
                        AND
                     `asset_transaction`.`location_id` in ('.$location.')
                        AND
                     `asset`.`asset_model_id`='.$tt.' AND `asset_transaction`.`status_id`='.ASSET_DISPOSED
            ));

            array_push($dd, $deployed[0]->count);
            array_push($dd, $undeployed[0]->count);
            array_push($dd, $inservice[0]->count);
            array_push($dd, $disposed[0]->count);

            array_push($jsonList, $dd);
        }

        if($request->location!=0){
            $loc=Location::find($request->location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        $filename="Report of Asset in ".$loc;

        $tmp2 = $jsonList;

        $headers=['Asset Model', 'Total Asset', 'Total Value', 'Deployed', 'Un-Deployed', 'In-service', 'Disposed'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.assetLocationReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Asset Location Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Asset Location");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    Public function customReportView(Request $request)
    {

        // return $request->all();

        $asset_models = AssetModal::where('status',1)->get();
        $status = Status::all();
        $locations=UserLocationFilter::locationHierarchy();
        $location_types = LocationType::lists('name','id');

        $location  = $request->location==null?0:$request->location;

        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        if($basic_field==""){
            $basic_field=[];
        }

        $type = ($request->location_type != "")?$request->location_type:null;

        $specs_field=$request->get('modal-field-specs');

        $select_col=[];

        if(count($basic_field)>0){
            $select_basic=AssetModelBasicField::whereIn('id',$basic_field)->select('column_name')->get();
            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

            if($request->sub_loc && $request->sub_loc=='on'){
                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location,$type)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location,$type));
                    });
                }

                $sub_loc=1;
            }else{
                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')
                            ->from('asset_transaction')
                            ->where('location_id',$location)
                            ->whereNull('deleted_at');
                    });
                }
                $sub_loc=0;
            }

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }else{
                $data  = $data->whereIn('id',function($aa) {
                    $aa->select('asset_id')->from('asset_transaction')->whereNotIn('status_id',[6])->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }
            
            $data=$data->paginate(10);

            $fields_spec=FieldSet::whereIn('id',$specs_field)->get()->pluck('name');

            foreach ($data as $key => $value) {
                $field_values=FieldSetValues::whereIn('fieldset_id',$specs_field)
                        ->join('fieldset', 'device_fieldset_values.fieldset_id', '=', 'fieldset.id')
                        ->join('devices', 'device_fieldset_values.device_id', '=', 'devices.id')
                        ->where('devices.asset_id',$value->id)
                        ->select('name','value')
                        ->get();

                foreach ($field_values as $tt) {
                    
                    $key=str_replace(' ','_',strtolower($tt->name));
                    
                    $value[$key]=$tt->value;
                }
            }
            
            foreach ($fields_spec as $value) {
                array_push($select_col, str_replace(' ','_',strtolower($value)));
            }

        }else{
            if($model==0){

                $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

                if($request->sub_loc && $request->sub_loc=='on'){
                    if($location!=null){
                        $data  = $data->whereIn('id',function($cc) use($location,$type)
                        {
                            $cc->select('asset_id')
                                ->from('asset_transaction')
                                ->whereNull('deleted_at')
                                ->whereIn('location_id',UserLocationFilter::getSubLocations($location,$type));
                        });
                    }

                    $sub_loc=1;
                }else{
                    if($location!=null){
                        $data  = $data->whereIn('id',function($aa) use($location)
                        {
                            $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                        });
                    }
                    $sub_loc=0;
                }

                if($stat!=null && $stat!="" && $stat>0){
                    $data  = $data->whereIn('id',function($aa) use($stat)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                    });
                }else{
                    $data  = $data->whereIn('id',function($aa) {
                        $aa->select('asset_id')->from('asset_transaction')->where('status_id','!=',6)->whereNull('deleted_at');
                    });
                }

                if(in_array("make", $select_col)){
                    $data=$data->with(['manufacturerName']);
                }

                if(in_array("supplier_id", $select_col)){
                    $data=$data->with(['supplierName']);
                }
                
                $data=$data->paginate(10);
                $fields_spec=[];
            }else{
                $data=[];
                $fields_spec=[];
                $sub_loc=0;                
            }
        }

        $field_basic=AssetModelBasicField::all()->lists('name','id');

        if($request->location == null && $request->stat == null && $request->model == null){
            $data = [];
        }
                
        return view('reports::reports.custom_report')->with([
            'locations'=>$locations,
            'asset_models'=>$asset_models,
            'status'=>$status,
            'fields_basic'=>$field_basic,
            'spec_col'=>$fields_spec,
            'data'=>$data,
            'selected_col'=>$select_col,
            'location_types' => $location_types,
            'old'=>['location'=>$location,'location_type' => $request->location_type,'sub_loc'=>$sub_loc,'status'=>$stat,'model'=>$model,'basic_field'=>$basic_field,'spec_field'=>$specs_field]
        ]);
    }

    public function getSpecField(Request $request)
    {
        return $tmp=AssetCustom::getAssetDeviceFieldUsingModel($request->model);
    }

    public function downloadExcel(Request $request)
    {
        // return $request->all();

        ini_set('memory_limit','200M');
        ini_set('max_execution_time',0);

        $location  = $request->location==null?0:$request->location;
        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        $basic_field=explode(',', $basic_field);

        if($basic_field==""){
            $basic_field=[];
        }

        $type = ($request->loc_type != "")?$request->loc_type:null;

        $specs_field=$request->get('modal-field-specs');

        $specs_field=explode(',', $specs_field);

        $select_col=[];

        //$select_col[]="description";

        if(count($basic_field)>0){
            $select_basic=AssetModelBasicField::whereIn('id',$basic_field)->select('column_name')->get();
            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

            if($request->sub_loc && $request->sub_loc=='on'){

                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location, $type)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location, $type));
                    });
                }
            }else{

                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                    });
                }
            }

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }
            
            $data=$data->get();

            $fields_spec=FieldSet::whereIn('id',$specs_field)->get()->pluck('name');

            foreach ($data as $key => $value) {
                $field_values=FieldSetValues::whereIn('fieldset_id',$specs_field)
                        ->join('fieldset', 'device_fieldset_values.fieldset_id', '=', 'fieldset.id')
                        ->join('devices', 'device_fieldset_values.device_id', '=', 'devices.id')
                        ->where('devices.asset_id',$value->id)
                        ->select('name','value')
                        ->get();

                foreach ($field_values as $tt) {
                    
                    $key=str_replace(' ','_',strtolower($tt->name));
                    
                    $value[$key]=$tt->value;
                }
            }
            
            foreach ($fields_spec as $value) {
                array_push($select_col, str_replace(' ','_',strtolower($value)));
            }

        }else{
            if($model==00){
                $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

                if($request->sub_loc && $request->sub_loc=='on'){
                    if($location!=null){
                        $data  = $data->whereIn('id',function($cc) use($location, $type)
                        {
                            $cc->select('asset_id')
                                ->from('asset_transaction')
                                ->whereNull('deleted_at')
                                ->whereIn('location_id',UserLocationFilter::getSubLocations($location, $type));
                        });
                    }

                    $sub_loc=1;
                }else{
                    if($location!=null){
                        $data  = $data->whereIn('id',function($aa) use($location)
                        {
                            $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                        });
                    }
                    $sub_loc=0;
                }

                if($stat!=null && $stat!="" && $stat>0){
                    $data  = $data->whereIn('id',function($aa) use($stat)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                    });
                }

                if(in_array("make", $select_col)){
                    $data=$data->with(['manufacturerName']);
                }

                if(in_array("supplier_id", $select_col)){
                    $data=$data->with(['supplierName']);
                }
                
                $data=$data->get();
            }else{
                $data=[];
            }
        }

        $tmp=[];

        $lTypes = LocationType::orderBy('id','DESC')->get();

        $lTypesR = $lTypes->reverse();

        foreach ($data as $detail) {
            $dd=[];
            //$dd[]=($detail->transaction[0]->location->parentLocation)?$detail->transaction[0]->location->parentLocation->name:'-';
            //$dd[]=$detail->transaction[0]->location->name;

            foreach($lTypesR as $lT){
                $dd[]=($detail->transaction[0]->location->ancestorsAndSelf()->where('type',$lT->id)->first())?$detail->transaction[0]->location->ancestorsAndSelf()->where('type',$lT->id)->first()->name:'-';
            }

            $dd[]=$detail->transaction[0]->status->name;

            foreach($select_col as $value){
                if($value=='make'){
                    if($detail['manufacturerName']){
                        $dd[]=$detail['manufacturerName']->name;
                    }else{
                        $dd[]='';
                    }
                }elseif($value=='supplier_id'){
                    if($detail['supplierName']){
                        $dd[]=$detail['supplierName']->name;
                    }else{
                        $dd[]='';
                    }
                }else{
                    $dd[]=$detail[$value];
                }                
            }

            array_push($tmp, $dd);
        }

        $tmp2=[];


        foreach ($tmp as $value) {
            $tt=[];
            foreach($value as $key=>$last){
                //if($key!=0){
                    $tt[]=$last;
                //}

            }
            array_push($tmp2, $tt);
        }

        $date=date('Y-m-d');

        if($location!=0){
            $loc=Location::find($location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        if($model==00){
            $modal = "All Modal";
        }else{
            $modal=AssetModal::find($model)->name;
        }

        $filename="Report of ".$modal." in ".$loc;

        $headers=[];

        foreach ($select_col as $value) {
            $headers[]=ucwords(str_replace('_', ' ', $value));
        }

        array_unshift($headers, 'Status');

        foreach($lTypes as $lT){
            array_unshift($headers,$lT->name);
        }

        //array_unshift($headers, 'Status', 'Parent Location','Location');
        array_unshift($tmp2, $headers);

        if(count($tmp2)>10000){
            $_pages = array_chunk($tmp2,10000);
            
            Excel::create($filename, function($excel) use($_pages) {

                foreach ($_pages as $value) {

                    $excel->sheet('Sheetname', function($sheet) use($value){

                        $sheet->fromArray($value, null, 'A1', false, false);

                    });

                }

            })->download('xls');

        }else{
            Excel::create($filename, function($excel) use($tmp2) {

                $excel->sheet('Sheetname', function($sheet) use($tmp2){

                    $sheet->fromArray($tmp2, null, 'A1', false, false);

                });

            })->download('xls');
        }

        // return Response::json(storage_path('excel/downloads/').$filename.'.xls');
    }

    public function downloadPdf(Request $request)
    {

        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 30000);
        $location  = $request->location==null?0:$request->location;
        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        $basic_field=explode(',', $basic_field);

        if($basic_field==""){
            $basic_field=[];
        }

        $specs_field=$request->get('modal-field-specs');

        $specs_field=explode(',', $specs_field);

        $type = ($request->loc_type != "")?$request->loc_type:null;

        $select_col=[];

        //$select_col[]="location";

        if(count($basic_field)>0){
            $select_basic=AssetModelBasicField::whereIn('id',$basic_field)->select('column_name')->get();
            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

            if($request->sub_loc && $request->sub_loc=='on'){
                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location, $type)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location, $type));
                    });
                }

                $sub_loc=1;
            }else{
                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                    });
                }
                $sub_loc=0;
            }

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }
            
            $data=$data->get();

            $fields_spec=FieldSet::whereIn('id',$specs_field)->get()->pluck('name');

            foreach ($data as $key => $value) {
                $field_values=FieldSetValues::whereIn('fieldset_id',$specs_field)
                        ->join('fieldset', 'device_fieldset_values.fieldset_id', '=', 'fieldset.id')
                        ->join('devices', 'device_fieldset_values.device_id', '=', 'devices.id')
                        ->where('devices.asset_id',$value->id)
                        ->select('name','value')
                        ->get();

                foreach ($field_values as $tt) {
                    
                    $key=str_replace(' ','_',strtolower($tt->name));
                    
                    $value[$key]=$tt->value;
                }
            }
            
            foreach ($fields_spec as $value) {
                array_push($select_col, str_replace(' ','_',strtolower($value)));
            }

        }else{
            if($model==00){
                $data=Asset::whereNull('deleted_at')->with(['transaction.location.parentLocation','transaction.status']);

                if($request->sub_loc && $request->sub_loc=='on'){
                    if($location!=null){
                        $data  = $data->whereIn('id',function($cc) use($location, $type)
                        {
                            $cc->select('asset_id')
                                ->from('asset_transaction')
                                ->whereNull('deleted_at')
                                ->whereIn('location_id',UserLocationFilter::getSubLocations($location, $type));
                        });
                    }

                    $sub_loc=1;
                }else{
                    if($location!=null){
                        $data  = $data->whereIn('id',function($aa) use($location)
                        {
                            $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                        });
                    }
                    $sub_loc=0;
                }

                if($stat!=null && $stat!="" && $stat>0){
                    $data  = $data->whereIn('id',function($aa) use($stat)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                    });
                }

                if(in_array("make", $select_col)){
                    $data=$data->with(['manufacturerName']);
                }

                if(in_array("supplier_id", $select_col)){
                    $data=$data->with(['supplierName']);
                }
                
                $data=$data->get();
            }else{
                $data=[];
            }
        }

        $tmp=[];

        foreach ($data as $detail) {
            $dd=[];
            $dd[]=$detail->transaction[0]->status->name;
            $dd[]=($detail->transaction[0]->location->parentLocation)?$detail->transaction[0]->location->parentLocation->name:'-';
            $dd[]=$detail->transaction[0]->location->name;

            foreach($select_col as $value){
                if($value=='make'){
                    if($detail['manufacturerName']){
                        $dd[]=$detail['manufacturerName']->name;
                    }else{
                        $dd[]='';
                    }
                }elseif($value=='supplier_id'){
                    if($detail['supplierName']){
                        $dd[]=$detail['supplierName']->name;
                    }else{
                        $dd[]='';
                    }
                }else{
                    $dd[]=$detail[$value];
                }                
            }

            array_push($tmp, $dd);
        }

        $tmp2=[];

        foreach ($tmp as $value) {
            $tt=[];
            foreach($value as $key=>$last){
                //if($key!=3){
                    $tt[]=$last;
                //}

            }
            array_push($tmp2, $tt);
        }

        $date=date('Y-m-d');

        if($location!=0){
            $loc=Location::find($location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        if($model==00){
            $modal = "All Modal";
        }else{
            $modal=AssetModal::find($model)->name;
        }

        $filename="Report of ".$modal." in ".$loc;

        $headers=[];

        foreach ($select_col as $value) {
            $headers[]=ucwords(str_replace('_', ' ', $value));
        }

        array_unshift($headers, 'Status', 'Parent Location', 'Location');
        array_unshift($tmp2, $headers);

        $_pages = array_chunk($tmp2,1000);

        $pdfArray=[];

        foreach ($_pages as $value) {
            if($value){
                $page1 =  view('reports::prints.customReportPdf')->with(['data'=>$value])->render();
            }else{
                return response()->view("errors.404");
            }

            $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Asset Master List']);
            $pdf->SetMargins(5, 30, 5);
            $pdf->SetTitle("Report - Custom");
            $pdf->SetFont('helvetica', 5);
            $pdf->SetAutoPageBreak(TRUE, 30);
            $pdf->AddPage('L', 'A3');
            $pdf->writeHtml($page1);
            $_tmp_file = "tmp_".date('YmdHis').".pdf";

            $pdf->output(storage_path("tmp_uploads/".$_tmp_file), 'F');

            $pdfArray[]="tmp_uploads/".$_tmp_file;

        }

        $pdf = new \Clegginabox\PDFMerger\PDFMerger;

        foreach($pdfArray as $pdfA){
            $pdf->addPDF(storage_path($pdfA));
        }

        $pdf->merge('download', $filename.'.pdf');

        foreach($pdfArray as $pdfA){
            \File::delete(storage_path($pdfA));
        }
    }

    Public function dynamicReportView(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');

        // return $request->all();

        $asset_models = AssetModal::where('status',1)->get();
        $status = Status::all();
        $locations=UserLocationFilter::locationHierarchy();

        $location  = $request->location==null?0:$request->location;

        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        if($basic_field==""){
            $basic_field=[];
        }

        $select_col=[];

        if(count($basic_field)>0){
            $select_basic=AssetModelBasicField::whereIn('id',$basic_field)->select('column_name')->get();
            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location']);

            if($request->sub_loc && $request->sub_loc=='on'){
                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                    });
                }

                $sub_loc=1;
            }else{
                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                    });
                }
                $sub_loc=0;
            }            

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }

            if($from_date!="" && $to_date!=""){
                $data = $data->whereBetween('warranty_to', array($from_date, $to_date));
            }
            
            $data=$data->paginate(10);            

        }else{
            $data=[];
            $sub_loc=0;
        }

        $field_basic=AssetModelBasicField::all()->lists('name','id');        

        // return $select_col;
        // return $data;
        // return ['location'=>$location,'sub_loc'=>$sub_loc,'status'=>$stat,'model'=>$model,'basic_field'=>$basic_field,'from-days'=>$from_days,'to-days'=>$to_days,'middle_date'=>$mid_date];
                
        return view('reports::reports.dynamic_report')->with([
            'locations'=>$locations,
            'asset_models'=>$asset_models,
            'status'=>$status,
            'fields_basic'=>$field_basic,
            'data'=>$data,
            'selected_col'=>$select_col,
            'old'=>[
                'location'=>$location,
                'sub_loc'=>$sub_loc,
                'status'=>$stat,
                'model'=>$model,
                'basic_field'=>$basic_field,
                'from_date'=>$from_date,
                'to_date'=>$to_date
            ]
        ]);
    }

    public function downloadDynamicExcel(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');

        // return $request->all();

        $asset_models = AssetModal::where('status',1)->get();
        $status = Status::all();
        $locations=UserLocationFilter::locationHierarchy();

        $location  = $request->location==null?0:$request->location;

        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        if($basic_field==""){
            $basic_field=[];
        }

        $select_col=[];

        $ff = explode(',', $basic_field);

        if(count($ff)>0){
            
            $select_basic=AssetModelBasicField::whereIn('id',$ff)->select('column_name')->get();

            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location']);

            if($request->sub_loc && $request->sub_loc=='on'){
                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                    });
                }

                $sub_loc=1;
            }else{
                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                    });
                }
                $sub_loc=0;
            }            

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }

            if($from_date!="" && $to_date!=""){
                $data = $data->whereBetween('warranty_to', array($from_date, $to_date));
            }
            
            $data=$data->get();            

        }else{
            $data=[];
            $sub_loc=0;
        }

        $tmp=[];

        foreach ($data as $detail) {
            $dd=[];
            $dd[]=$detail->transaction[0]->location->name;

            foreach($select_col as $value){
                if($value=='make'){
                    $dd[]=$detail['manufacturerName']->name;
                }elseif($value=='supplier_id'){
                    $dd[]=$detail['supplierName']->name;
                }else{
                    $dd[]=$detail[$value];
                }                
            }

            array_push($tmp, $dd);
        }

        $tmp2=[];

        foreach ($tmp as $value) {
            $tt=[];
            foreach($value as $key=>$last){
                if($key!=1){
                    $tt[]=$last;
                }

            }
            array_push($tmp2, $tt);
        }

        $date=date('Y-m-d');

        if($location!=0){
            $loc=Location::find($location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        $filename="Dynamic Report in ".$loc;

        $headers=[];

        foreach ($select_col as $value) {
            $headers[]=ucwords(str_replace('_', ' ', $value));
        }

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function downloadDynamicPdf(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');

        // return $request->all();

        $asset_models = AssetModal::where('status',1)->get();
        $status = Status::all();
        $locations=UserLocationFilter::locationHierarchy();

        $location  = $request->location==null?0:$request->location;

        $stat = $request->status==null?0:$request->status;
        $model = $request->model==null?0:$request->model;

        $basic_field=$request->get('modal-field-basic');

        if($basic_field==""){
            $basic_field=[];
        }

        $select_col=[];

        $ff = explode(',', $basic_field);

        if(count($ff)>0){
            
            $select_basic=AssetModelBasicField::whereIn('id',$ff)->select('column_name')->get();

            foreach ($select_basic as $value) {
                array_push($select_col, $value->column_name);
            }            
        }

        if(($location!=null && $location>0) || ($model!=null && $model!="" && $model>0) || ($stat!=null && $stat>0)){
            $data=Asset::whereNull('deleted_at')->with(['transaction.location']);

            if($request->sub_loc && $request->sub_loc=='on'){
                if($location!=null){
                    $data  = $data->whereIn('id',function($cc) use($location)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                    });
                }

                $sub_loc=1;
            }else{
                if($location!=null){
                    $data  = $data->whereIn('id',function($aa) use($location)
                    {
                        $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location)->whereNull('deleted_at');
                    });
                }
                $sub_loc=0;
            }            

            if($model!=null && $model!="" && $model>0){
                $data  = $data->where('asset_model_id',$model);
            }

            if($stat!=null && $stat!="" && $stat>0){
                $data  = $data->whereIn('id',function($aa) use($stat)
                {
                    $aa->select('asset_id')->from('asset_transaction')->where('status_id',$stat)->whereNull('deleted_at');
                });
            }

            if(in_array("make", $select_col)){
                $data=$data->with(['manufacturerName']);
            }

            if(in_array("supplier_id", $select_col)){
                $data=$data->with(['supplierName']);
            }

            if($from_date!="" && $to_date!=""){
                $data = $data->whereBetween('warranty_to', array($from_date, $to_date));
            }
            
            $data=$data->get();            

        }else{
            $data=[];
            $sub_loc=0;
        }

        $tmp=[];

        foreach ($data as $detail) {
            $dd=[];
            $dd[]=$detail->transaction[0]->location->name;

            foreach($select_col as $value){
                if($value=='make'){
                    $dd[]=$detail['manufacturerName']->name;
                }elseif($value=='supplier_id'){
                    $dd[]=$detail['supplierName']->name;
                }else{
                    $dd[]=$detail[$value];
                }                
            }

            array_push($tmp, $dd);
        }

        $tmp2=[];

        foreach ($tmp as $value) {
            $tt=[];
            foreach($value as $key=>$last){
                if($key!=1){
                    $tt[]=$last;
                }

            }
            array_push($tmp2, $tt);
        }

        $date=date('Y-m-d');

        if($location!=0){
            $loc=Location::find($location);
            $loc=$loc->name;
        }else{
            $loc="All Location";
        }

        $filename="Dynamic Report in ".$loc;

        $headers=[];

        foreach ($select_col as $value) {
            $headers[]=ucwords(str_replace('_', ' ', $value));
        }

        if($tmp2){
            $page1 =  view('reports::prints.customReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Dynamic Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Custom");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    Public function getLocation(Request $request)
    {
        return $locations  = Location::where('type',$request->type)->get();
    }

    static function _getRequestDataAllLocationWithoutSub($type,$from_date,$to_date,$model,$search)
    {

        if($type==0){
            $data_copy = RequestDetail::whereNull('deleted_at');
        }else{
            $data_copy = RequestDetail::where('request_type_id',$type);
        }

        if($from_date!="" && $to_date!=""){
            $data_copy = $data_copy->whereBetween('created_at',[$from_date,$to_date]);
        }

        if($model != 0){            
            $data_copy = $data_copy->where('asset_type_id',$model);
        }

        $data_copy = $data_copy->where('send_by',$search)->with(['requestModal','employee.location.location','RequestType'])->select('*',DB::raw('quantity as total'))->get();

        $tp = [];

        foreach ($data_copy as $_data) {
            $tpp = [];
            if(count($_data)>0){
                $tpp['location'] = $_data['employee']['location']['location']->name;
                $tpp['modal'] = $_data['requestModal']->name;
                $tpp['modal_code'] = $_data['requestModal']->code;
                $tpp['quantity'] = $_data->total;
                $tpp['type'] = $_data['RequestType']->name;

                array_push($tp, $tpp);
            }
        }

        return $tp;
    }

    static function _getRequestDataLocationWithSub($type,$from_date,$to_date,$model,$search,$location)
    {

        if($type==0){
            $data_copy = RequestDetail::whereNull('deleted_at');
        }else{
            $data_copy = RequestDetail::where('request_type_id',$type);
        }

        if($from_date!="" && $to_date!=""){
            $data_copy = $data_copy->whereBetween('created_at',[$from_date,$to_date]);
        }

        if($model != 0){            
            $data_copy = $data_copy->where('asset_type_id',$model);
        }

        if(is_int($search)){
            $data_copy = $data_copy->where('send_by',$search);
        }else{
            $data_copy = $data_copy->whereIn('send_by',$search);
        }

        $data_copy = $data_copy->with(['requestModal','employee.location.location','RequestType'])->select('*',DB::raw('quantity as total'))->get();

        $tp = [];

        foreach ($data_copy as $_data) {
            $tpp = [];
            if(count($_data)>0){

                if($location!=0){
                    $tpp['location'] = $_data['employee']['location']['location']->name;
                }else{
                    $tpp['location'] = $_data['employee']['location']['location']->name;                    
                }
                $tpp['modal'] = $_data['requestModal']->name;
                $tpp['modal_code'] = $_data['requestModal']->code;
                $tpp['quantity'] = $_data->total;
                $tpp['type'] = $_data['RequestType']->name;

                array_push($tp, $tpp);
            }
        }

        return $tp;
    }

    Public function requestSummeryReportView(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?0:$request->model;

        $types          = RequestType::all();
        $asset_models   = AssetModal::where('status',1)->get();
        
        $pp = [];

        if($location!=0){
            if($request->sub_loc && $request->sub_loc=='on'){
                
                $pp = [];

                $usr_loc = UserLocationFilter::getEmployees(UserLocationFilter::getSubLocations($location));

                // foreach ($usr_loc as $valueDF) {
                $pp[] = $this->_getRequestDataLocationWithSub($request->type, $from_date, $to_date, $model, $usr_loc,$location);
                // }                

                $data =  $pp;

                $sub_loc=1;
            }else{
                
                $pp = [];
                
                $usr_loc = UserLocationFilter::getEmployees([$location]);

                foreach ($usr_loc as $valueDF) {
                    $pp[] = $this->_getRequestDataAllLocationWithoutSub($request->type, $from_date, $to_date, $model, $valueDF);
                }                

                $data =  $pp;

                $sub_loc=0;
            }
        }else{
            $data=[];
            $sub_loc=0;
        }

        $locations=UserLocationFilter::locationHierarchy();

        return view('reports::reports.request_summery_report')->with([
            'locations'=>$locations,
            'asset_models'=>$asset_models,
            'types'=>$types,
            'data'=>$data,
            'old'=>[
                'location'=>$location,
                'sub_loc'=>$sub_loc,
                'model'=>$model,
                'type'=>$request->type,
                'from_date'=>$from_date,
                'to_date'=>$to_date
            ]
        ]);
    }

    public function downloadRequestSummeryExcel(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?0:$request->model;

        $types          = RequestType::all();
        $asset_models   = AssetModal::where('status',1)->get();        

        $pp = [];

        if($location!=0){
            if($request->sub_loc && $request->sub_loc=='on'){
                
                $pp = [];

                $usr_loc = UserLocationFilter::getEmployees(UserLocationFilter::getSubLocations($location));

                // foreach ($usr_loc as $valueDF) {
                $pp[] = $this->_getRequestDataLocationWithSub($request->type, $from_date, $to_date, $model, $usr_loc,$location);
                // }                

                $data =  $pp;

                $sub_loc=1;
            }else{
                
                $pp = [];
                
                $usr_loc = UserLocationFilter::getEmployees([$location]);

                foreach ($usr_loc as $valueDF) {
                    $pp[] = $this->_getRequestDataAllLocationWithoutSub($request->type, $from_date, $to_date, $model, $valueDF);
                }                

                $data =  $pp;

                $sub_loc=0;
            }
        }

        $filename="Request Summery Report";

        $headers=['Location','Request Type','Asset Model','Model Code','Quantity'];

        $_sheet_data = [];

        foreach ($data as $value20) {
            foreach ($value20 as $value25) {

                $top = [];
                $top[] = $value25['location'];
                $top[] = $value25['type'];
                $top[] = $value25['modal'];
                $top[] = $value25['modal_code'];
                $top[] = $value25['quantity'];

                array_push($_sheet_data, $top);
            }
        }

        array_unshift($_sheet_data, $headers);

        Excel::create($filename, function($excel) use($_sheet_data) {

            $excel->sheet('Sheetname', function($sheet) use($_sheet_data){

                $sheet->fromArray($_sheet_data, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function downloadRequestSummeryPdf(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?0:$request->model;

        $types          = RequestType::all();
        $asset_models   = AssetModal::where('status',1)->get();        

        $pp = [];

        if($location!=0){
            if($request->sub_loc && $request->sub_loc=='on'){
                
                $pp = [];

                $usr_loc = UserLocationFilter::getEmployees(UserLocationFilter::getSubLocations($location));

                // foreach ($usr_loc as $valueDF) {
                $pp[] = $this->_getRequestDataLocationWithSub($request->type, $from_date, $to_date, $model, $usr_loc,$location);
                // }                

                $data =  $pp;

                $sub_loc=1;
            }else{
                
                $pp = [];
                
                $usr_loc = UserLocationFilter::getEmployees([$location]);

                foreach ($usr_loc as $valueDF) {
                    $pp[] = $this->_getRequestDataAllLocationWithoutSub($request->type, $from_date, $to_date, $model, $valueDF);
                }                

                $data =  $pp;

                $sub_loc=0;
            }
        }

        $filename="Request Summery Report";

        $headers=['Location','Request Type','Asset Model','Model Code','Quantity'];

        $_sheet_data = [];

        foreach ($data as $value20) {
            foreach ($value20 as $value25) {

                $top = [];
                $top[] = $value25['location'];
                $top[] = $value25['type'];
                $top[] = $value25['modal'];
                $top[] = $value25['modal_code'];
                $top[] = $value25['quantity'];

                array_push($_sheet_data, $top);
            }
        }

        array_unshift($_sheet_data, $headers);


        if($_sheet_data){
            $page1 =  view('reports::prints.requestSummeryReportPdf')->with(['data' => $_sheet_data])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Request Summery Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Request Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A4');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    static function _getAssetDataAllLocationWithoutSub($from_date,$to_date,$model,$search)
    {

        if($from_date!="" && $to_date!=""){
            $data_copy = $data_copy->whereBetween('created_at',[$from_date,$to_date]);
        }

        if($model != 0){            
            $data_copy = $data_copy->where('asset_type_id',$model);
        }

        $data_copy = $data_copy->where('send_by',$search)->with(['requestModal','employee.location.location','RequestType'])->groupBy('asset_type_id')->select('*',DB::raw('SUM(quantity) as total'))->get();

        $tp = [];

        foreach ($data_copy as $_data) {
            $tpp = [];
            if(count($_data)>0){
                $tpp['location'] = $_data['employee']['location']['location']->name;
                $tpp['modal'] = $_data['requestModal']->name;
                $tpp['modal_code'] = $_data['requestModal']->code;
                $tpp['quantity'] = $_data->total;
                $tpp['type'] = $_data['RequestType']->name;

                array_push($tp, $tpp);
            }
        }

        return $tp;
    }

    static function _getAssetDataLocationWithSub($from_date,$to_date,$model,$search,$location)
    {

        if($from_date!="" && $to_date!=""){
            $data_copy = $data_copy->whereBetween('created_at',[$from_date,$to_date]);
        }

        if($model != 0){            
            $data_copy = $data_copy->where('asset_type_id',$model);
        }

        if(is_int($search)){
            $data_copy = $data_copy->where('send_by',$search);
        }else{
            $data_copy = $data_copy->whereIn('send_by',$search);
        }

        $data_copy = $data_copy->with(['requestModal','employee.location.location','RequestType'])->groupBy('asset_type_id')->select('*',DB::raw('SUM(quantity) as total'))->get();

        $tp = [];

        foreach ($data_copy as $_data) {
            $tpp = [];
            if(count($_data)>0){

                if($location!=0){
                    $tpp['location'] = Location::find($location)->name;                    
                }else{
                    $tpp['location'] = $_data['employee']['location']['location']->name;                    
                }
                $tpp['modal'] = $_data['requestModal']->name;
                $tpp['modal_code'] = $_data['requestModal']->code;
                $tpp['quantity'] = $_data->total;
                $tpp['type'] = $_data['RequestType']->name;

                array_push($tp, $tpp);
            }
        }

        return $tp;
    }

    static function _getAssetSummeryData($location,$models,$option)
    {
        $models = AssetModal::whereIn('id',$models)->get();
        
        if($option=="on"){

            $tdd = [];

            $html = '<table class="table table-bordered" style="max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;"><thead style="background:#ddd"><tr><td>Location</td>';

            foreach ($models as $model) {
                $html .= '<td>'.$model->name.'</td>';
            }

            $html .= '</tr></thead><tbody>';

            foreach ($location as $value) {

                $array_loc = Location::find($value->id);

                $html .= '<tr><td>'.$array_loc->name.'</td>';
                
                $location_lot = UserLocationFilter::getSubLocations($value->id);

                foreach ($models as $model) {

                    $data  = Asset::whereIn('id',function($cc) use($location_lot,$model)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->whereIn('location_id',$location_lot);
                    })->where('asset_model_id',$model->id)->get();
                    
                    $html .= '<td>'.count($data).'</td>';
                }

                $html .= '</tr>';
                
            }

            $html .='</tbody></table>';

            return $html;

        }else if($option=="off"){

            $tdd = [];

            $html = '<table class="table table-bordered" style="max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;"><thead style="background:#ddd"><tr><td>Location</td>';
            foreach ($models as $model) {
                $html .= '<td>'.$model->name.'</td>';
            }

            $html .= '</tr></thead><tbody>';
            
            
            foreach ($location as $value) {

                $array_loc = Location::find($value->id);

                $html .= '<tr><td>'.$array_loc->name.'</td>';

                foreach ($models as $model) {

                    $data  = Asset::whereIn('id',function($cc) use($value,$model)
                    {
                        $cc->select('asset_id')
                            ->from('asset_transaction')
                            ->whereNull('deleted_at')
                            ->where('location_id',$value->id);
                    })->where('asset_model_id',$model->id)->get();

                    $html .= '<td>'.count($data).'</td>';                   
                    
                }

                $html .= '</tr>';
            }

            $html .='</tbody></table>';

            return $html;

        }
    }

    Public function assetSummeryReportView(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $loc_type   = $request->loc_type==null?0:$request->loc_type;
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?[]:$request->model;

        $loc_types      = LocationType::all();
        $asset_models   = AssetModal::where('status',1)->get(); 
        
        $data = [];

        $sub_loc = 0;

        if($loc_type==0){
            $data='<table class="table table-bordered" style="max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;">
                    <tbody>
                        <tr><td>No data</td></tr>
                    </tbody>
                </table>';
        }else if($loc_type>0){

            if($location==0){

                $tmp_loc = Location::where('type',$loc_type)->get();//Return Array
                
                if($request->sub_loc && $request->sub_loc=='on'){
                    $data = $this->_getAssetSummeryData($tmp_loc,$model,'on');
                    $sub_loc=1;
                }else{
                    $data = $this->_getAssetSummeryData($tmp_loc,$model,'off');
                    $sub_loc=0;
                }

            }else if($location>0){

                $tmp_loc = Location::where('id',$location)->get();//Return Single Location in array

                if($request->sub_loc && $request->sub_loc=='on'){
                    $data = $this->_getAssetSummeryData($tmp_loc,$model,'on');
                    $sub_loc=1;
                }else{
                    $data = $this->_getAssetSummeryData($tmp_loc,$model,'off');
                    $sub_loc=0;
                }

            }

        }

        if($loc_type == 0){
            $locations  = Location::where('type',1)->get();
        }else{
            $locations  = Location::where('type',$loc_type)->get();
        }
        
        return view('reports::reports.asset_summery_report')->with([
            'loc_types'=>$loc_types,
            'locations'=>$locations,
            'asset_models'=>$asset_models,
            'data'=>$data,
            'old'=>[
                'loc_type'=>$loc_type,
                'location'=>$location,
                'sub_loc'=>$sub_loc,
                'model'=>$model,
                'from_date'=>$from_date,
                'to_date'=>$to_date
            ]
        ]);
    }

    static function _getAssetRequestSummeryData($_request_type,$emp,$_model,$_from_date,$_to_date)
    {

        if($_request_type==0){
            $query = RequestDetail::whereNull('deleted_at');
        }else{
            $query = RequestDetail::where('request_type_id',$_request_type);
        }

        if($_from_date!="" && $_to_date!=""){
            $query = $query->whereBetween('created_at',[$_from_date,$_to_date]);
        }
        
        $query = $query->whereIn('send_by',$emp)
                        ->where('asset_type_id',$_model)
                        ->select(DB::raw('SUM(quantity) as total'))
                        ->get();
        
        if($query[0]->total){
            return $query[0]->total;
        }else{
            return 0;
        }
    }

    Public function assetRequestSummeryReportView(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $loc_type   = $request->loc_type==null?0:$request->loc_type;
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?[]:$request->model;
        $request_type  = $request->type==null?0:$request->type;

        $types          = RequestType::all();
        $loc_types      = LocationType::all();
        $asset_models   = AssetModal::where('status',1)->get(); 
        
        $html = '';

        $total_values = [];

        $sub_loc = 0;

        $_models = AssetModal::whereIn('id',$model)->get();

        if($loc_type==0){
            $html='<table class="table table-bordered" style="max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;">
                    <tbody>
                        <tr><td>No data</td></tr>
                    </tbody>
                </table>';
        }else if($loc_type>0){

            $html = '<table class="table table-bordered" style="max-height: 400px;overflow-y: auto;overflow-x: auto;white-space: nowrap;"><thead style="background:#ddd"><tr><td>Location</td>';

            foreach ($_models as $_model) {
                $html .= '<td>'.$_model->name.'</td>';
            }

            $html .= '</tr></thead><tbody>';

            if($location==0){

                $tmp_loc = Location::where('type',$loc_type)->get();//Return Array
                
                if($request->sub_loc && $request->sub_loc=='on'){
                    
                    $sub_loc=1;                                        
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);
                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                        
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }else{
                    
                    $sub_loc=0;                    
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                            
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }

            }else if($location>0){

                $tmp_loc = Location::where('id',$location)->get();//Return Single Location in array

                if($request->sub_loc && $request->sub_loc=='on'){
                    
                    $sub_loc=1;                    
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);

                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {
                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }else{
                    // $data = $this->_getAssetRequestSummeryData(1,$from_date,$to_date,$tmp_loc,$model,'off');
                    $sub_loc=0;                   
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';
                }

            }

        }

        if($loc_type == 0){
            $locations  = Location::where('type',1)->get();
        }else{
            $locations  = Location::where('type',$loc_type)->get();
        }
        
        return view('reports::reports.asset_request_summery_report')->with([
            'loc_types'=>$loc_types,
            'locations'=>$locations,
            'asset_models'=>$asset_models,
            'types'=>$types,
            'data'=>$html,
            'old'=>[
                'loc_type'=>$loc_type,
                'location'=>$location,
                'sub_loc'=>$sub_loc,
                'model'=>$model,
                'type'=>$request->type,
                'from_date'=>$from_date,
                'to_date'=>$to_date
            ]
        ]);
    }

    Public function downloadAssetRequestSummeryPdf(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $loc_type   = $request->loc_type==null?0:$request->loc_type;
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?[]:$request->model;

        $request_type  = $request->type==null?0:$request->type;

        $loc_types      = LocationType::all();
        $asset_models   = AssetModal::where('status',1)->get(); 
        
        $html = '';

        $total_values = [];

        $sub_loc = 0;
        $model = explode(',',$model);
        $_models = AssetModal::whereIn('id',$model)->get();

        if($loc_type==0){
            $html='<table border="1px" width="100%">
                    <tbody>
                        <tr><td>No data</td></tr>
                    </tbody>
                </table>';
        }else if($loc_type>0){

            $html = '<table border="1px" width="100%"><thead style="background:#ddd"><tr><td>Location</td>';

            foreach ($_models as $_model) {
                $html .= '<td>'.$_model->name.'</td>';
            }

            $html .= '</tr></thead><tbody>';

            if($location==0){

                $tmp_loc = Location::where('type',$loc_type)->get();//Return Array
                
                if($request->sub_loc && $request->sub_loc=='on'){
                    
                    $sub_loc=1;                                        
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);
                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                        
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }else{
                    
                    $sub_loc=0;                    
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                            
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }

            }else if($location>0){

                $tmp_loc = Location::where('id',$location)->get();//Return Single Location in array

                if($request->sub_loc && $request->sub_loc=='on'){
                    
                    $sub_loc=1;                    
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);

                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {
                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';

                }else{
                    // $data = $this->_getAssetRequestSummeryData(1,$from_date,$to_date,$tmp_loc,$model,'off');
                    $sub_loc=0;                   
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $html .= '<tr><td>'.$array_loc->name.'</td>';

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $html .= '<td>'.$data_copy.'</td>';
                        }

                        $html .= '</tr>';
                    }

                    $html .='</tbody></tfoot><tr><td><strong>Total</strong></td>';

                    foreach ($_models as $_model) {
                        $html .= '<td>'.array_sum($total_values[$_model->name]).'</td>';
                    }

                    $html .='</tr></tfoot></table>';
                }

            }

        }

        if($html){
            $page1 =  view('reports::prints.assetRequestSummeryReportPdf')->with(['data' => $html])->render();
        }else{
            return response()->view("errors.404");
        }

        $filename="Asset Request Summery Report";

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Asset Request Summery Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Request Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    Public function downloadAssetRequestSummeryExcel(Request $request)
    {

        $from_date  = $request->get('from_date');
        $to_date    = $request->get('to_date');
        $loc_type   = $request->loc_type==null?0:$request->loc_type;
        $location   = $request->location==null?0:$request->location;
        $model      = $request->model==null?[]:$request->model;

        $request_type  = $request->type==null?0:$request->type;

        $loc_types      = LocationType::all();
        $asset_models   = AssetModal::where('status',1)->get(); 
        
        $data = [];
        $headers = [];

        $total_values = [];

        $sub_loc = 0;
        $model = explode(',',$model);
        $_models = AssetModal::whereIn('id',$model)->get();

        if($loc_type==0){
            $html=[];
        }else if($loc_type>0){

            $headers[] = 'Location';

            foreach ($_models as $_model) {
                $headers[] = $_model->name;
            }

            array_push($data, $headers);

            if($location==0){

                $tmp_loc = Location::where('type',$loc_type)->get();//Return Array
                
                if($request->sub_loc && $request->sub_loc=='on'){
                    
                    $sub_loc=1;                                        
            
                    foreach ($tmp_loc as $value) {

                        $excel_body = [];

                        $array_loc = Location::find($value->id);

                        $excel_body[] = $array_loc->name;
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);
                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $excel_body[] = $data_copy;
                        }

                        array_push($data, $excel_body);
                        
                    }

                    $excel_foot = [];

                    $excel_foot[] = 'Total';

                    foreach ($_models as $_model) {
                        $excel_foot[] = array_sum($total_values[$_model->name]);
                    }
                    
                    array_push($data, $excel_foot);

                }else{
                    
                    $sub_loc=0;                    
            
                    foreach ($tmp_loc as $value) {
                        $excel_body = [];

                        $array_loc = Location::find($value->id);

                        $excel_body[] = $array_loc->name;

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $excel_body[] = $data_copy;
                            
                        }

                        array_push($data, $excel_body);
                    }

                    $excel_foot = [];

                    $excel_foot[] = 'Total';

                    foreach ($_models as $_model) {
                        $excel_foot[] = array_sum($total_values[$_model->name]);
                    }
                    
                    array_push($data, $excel_foot);

                }

            }else if($location>0){

                $tmp_loc = Location::where('id',$location)->get();//Return Single Location in array

                if($request->sub_loc && $request->sub_loc=='on'){
                    $sub_loc=1;                    
            
                    foreach ($tmp_loc as $value) {
                        $excel_body = [];

                        $array_loc = Location::find($value->id);

                        $excel_body[] = $array_loc->name;
                        
                        $location_lot = UserLocationFilter::getSubLocations($value->id);

                        $emp = [];

                        foreach ($location_lot as $_loc) {
                            $emp_t = UserLocationFilter::getEmployees([$_loc]);

                            foreach ($emp_t as $emp_id) {
                                $emp[] = $emp_id;
                            }
                        }

                        foreach ($_models as $_model) {
                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $excel_body[] = $data_copy;
                        }

                        array_push($data, $excel_body);
                    }

                    $excel_foot = [];

                    $excel_foot[] = 'Total';

                    foreach ($_models as $_model) {
                        $excel_foot[] = array_sum($total_values[$_model->name]);
                    }
                    
                    array_push($data, $excel_foot);

                }else{
                    // $data = $this->_getAssetRequestSummeryData(1,$from_date,$to_date,$tmp_loc,$model,'off');
                    $sub_loc=0;                   
            
                    foreach ($tmp_loc as $value) {

                        $array_loc = Location::find($value->id);

                        $excel_body[] = $array_loc->name;

                        $emp = UserLocationFilter::getEmployees([$array_loc->id]);

                        foreach ($_models as $_model) {

                            $data_copy = $this->_getAssetRequestSummeryData($request_type,$emp,$_model->id,$from_date,$to_date);

                            $total_values[$_model->name][] = intval($data_copy);

                            $excel_body[] = $data_copy;
                        }

                        array_push($data, $excel_body);
                    }

                    $excel_foot = [];

                    $excel_foot[] = 'Total';

                    foreach ($_models as $_model) {
                        $excel_foot[] = array_sum($total_values[$_model->name]);
                    }
                    
                    array_push($data, $excel_foot);
                }

            }

        }

        // return $data;

        $filename="Asset Request Summery Report";

        Excel::create($filename, function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data){

                $sheet->fromArray($data, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function employeeSummeryReportView(Request $request)
    {
        $data = Employee::with(['parentEmployee','type','location.location','createdBy.employee','verifiedBy']);

        $types  = EmployeeType::orderBy('parent')->get();

        $code = $request->code;
        if($code!=null){
            $data  = $data->where('code','like','%'.$code.'%');
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data  = $data->where('varified_status',$old_status);
        }

        $name = $request->name;
        if($name!=null){
            $data  = $data->where('first_name','like','%'.$name.'%')
                        ->orWhere('last_name','like','%'.$name.'%');
        } 

        $keyword = $request->keyword;
        if($keyword!=null){
            $data  = $data->where('address','like','%'.$keyword.'%')
                    ->orWhere('mobile','like','%'.$keyword.'%')
                    ->orWhere('email','like','%'.$keyword.'%');
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->where('employee_type_id',$type);
        }

        $location = $request->location;
        if($location!=null && $location>0){
            if($request->sub_loc && $request->sub_loc=='1'){
                $dt = Location::where('id',$location)->first()->getDescendantsAndSelf()->pluck('id');
                $data = $data->whereIn('employee.id',function($q) use ($dt){
                    $q->select('employee_id')->from('user_location')->whereIn('location_id',$dt);
                });

            }else{
                $data = $data->whereIn('employee.id',function($q)use($location){
                    $q->select('employee_id')->from('user_location')->where('location_id',$location);
                });
            }
        }

        $data = $data->orderBy('code')->paginate(10);
        $count=$data->total();

        $status=array(3=>'All',1=>'Varified',2=>'Rejected',0=>'Not Varified');

        $locations=UserLocationFilter::locationHierarchy();

        return view('reports::reports.employee_report')->with([
            'data'      => $data,
            'types'     => $types,
            'row_count' =>$count,
            'status'    => $status,
            'locations' => $locations,
            'old'       => [
                'code'      =>$code,
                'name'      =>$name,
                'keyword'   =>$keyword,
                'type'      =>$type,
                'status'    =>$old_status,
                'sub_loc'    =>$request->sub_loc,
                'location'  =>$location
            ]
        ]);
    }

    public function downloadEmployeeSummeryExcel(Request $request)
    {
        $data   = Employee::where('parent','>',0)->with(['parentEmployee','type','location.location','createdBy','verifiedBy']);

        $types  = EmployeeType::orderBy('parent')->get();

        $code = $request->code;
        if($code!=null){
            $data->where('code','like','%'.$code.'%');
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data->where('varified_status',$old_status);
        }

        $name = $request->name;
        if($name!=null){
            $data->where('first_name','like','%'.$name.'%')
                        ->orWhere('last_name','like','%'.$name.'%');
        } 

        $keyword = $request->keyword;
        if($keyword!=null){
            $data->where('address','like','%'.$keyword.'%')
                ->orWhere('mobile','like','%'.$keyword.'%')
                ->orWhere('email','like','%'.$keyword.'%');
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data->where('employee_type_id',$type);
        }

        $location = $request->location;
        if($location!=null && $location>0){
            if($request->sub_loc && $request->sub_loc=='1'){
                $dt = Location::where('id',$location)->first()->getDescendantsAndSelf()->pluck('id');
                $data = $data->whereIn('employee.id',function($q) use ($dt){
                    $q->select('employee_id')->from('user_location')->whereIn('location_id',$dt);
                });

            }else{
                $data = $data->whereIn('employee.id',function($q)use($location){
                    $q->select('employee_id')->from('user_location')->where('location_id',$location);
                });
            }
        }

        $data = $data->orderBy('code')->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->type->name);
            array_push($dd,$value->code);
            array_push($dd,$value->first_name." ".$value->last_name);
            array_push($dd,$value->nic);
            array_push($dd,$value->address);
            array_push($dd,$value->mobile!=null?$value->mobile:'-');
            array_push($dd,$value->email!=null?$value->email:'-');
            array_push($dd,$value->location!=null?$value->location->location->name:'-');
            array_push($dd,$value->parentEmployee->getFullNameAttribute());

            if($value->status==1){
                array_push($dd,'Activated');                
            }else if($value->status==2){
                array_push($dd,'Rejected');                
            }else if($value->status==0){
                array_push($dd,'Deactivated');                
            }

            array_push($dd, ($value->createdBy)?$value->createdBy->first_name.' '.$value->createdBy->last_name:'-');
            
            array_push($dd, $value->created_at);
            
            array_push($dd, ($value->verifiedby)?$value->verifiedby->first_name.' '.$value->verifiedby->last_name:'-');
            
            array_push($dd, ($value->varified_date)?$value->varified_date:'-');

            array_push($jsonList, $dd);
            
        }

        $filename="Report of Employees";

        $tmp2 = $jsonList;

        $headers=['Role', 'Employee Code', 'Name', 'NIC', 'Address', 'Mobile', 'Email', 'Location', 'Supervisor', 'Status', 'created By', 'created Date', 'Verified By', 'Verified Date'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function downloadEmployeeSummeryPdf(Request $request)
    {
        $data   = Employee::where('parent','>',0)->with(['parentEmployee','type','location.location','createdBy','verifiedBy']);

        $types  = EmployeeType::orderBy('parent')->get();

        $code = $request->code;
        if($code!=null){
            $data->where('code','like','%'.$code.'%');
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data->where('varified_status',$old_status);
        }

        $name = $request->name;
        if($name!=null){
            $data->where('first_name','like','%'.$name.'%')
                        ->orWhere('last_name','like','%'.$name.'%');
        } 

        $keyword = $request->keyword;
        if($keyword!=null){
            $data->where('address','like','%'.$keyword.'%')
                ->orWhere('mobile','like','%'.$keyword.'%')
                ->orWhere('email','like','%'.$keyword.'%');
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data->where('employee_type_id',$type);
        }

        $location = $request->location;
        if($location!=null && $location>0){
            if($request->sub_loc && $request->sub_loc=='1'){
                $dt = Location::where('id',$location)->first()->getDescendantsAndSelf()->pluck('id');
                $data = $data->whereIn('employee.id',function($q) use ($dt){
                    $q->select('employee_id')->from('user_location')->whereIn('location_id',$dt);
                });

            }else{
                $data = $data->whereIn('employee.id',function($q)use($location){
                    $q->select('employee_id')->from('user_location')->where('location_id',$location);
                });
            }
        }

        $data = $data->orderBy('code')->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->type->name);
            array_push($dd,$value->code);
            array_push($dd,$value->first_name." ".$value->last_name);
            array_push($dd,$value->nic);
            array_push($dd,$value->address);
            array_push($dd,$value->mobile!=null?$value->mobile:'-');
            array_push($dd,$value->email!=null?$value->email:'-');
            array_push($dd,$value->location!=null?$value->location->location->name:'-');
            array_push($dd,$value->parentEmployee->getFullNameAttribute());

            if($value->status==1){
                array_push($dd,'Activated');                
            }else if($value->status==2){
                array_push($dd,'Rejected');                
            }else if($value->status==0){
                array_push($dd,'Deactivated');                
            }

            array_push($dd, ($value->createdBy)?$value->createdBy->first_name.' '.$value->createdBy->last_name:'-');
            
            array_push($dd, $value->created_at);
            
            array_push($dd, ($value->verifiedby)?$value->verifiedby->first_name.' '.$value->verifiedby->last_name:'-');
            
            array_push($dd, ($value->varified_date)?$value->varified_date:'-');

            array_push($jsonList, $dd);
            
        }

        $filename="Report of Employees";

        $tmp2 = $jsonList;

        $headers=['Role', 'Employee Code', 'Name', 'NIC', 'Address', 'Mobile', 'Email', 'Location', 'Supervisor', 'Status', 'created By', 'created Date', 'Verified By', 'Verified Date'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.employeeSummeryReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Employee Detail Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Employee Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function assetDetailSummeryReportView(Request $request)
    {
        if(isset($request->code) && $request->code!=''){
            
            $res = Asset::where('inventory_no',$request->code)->first();

            if($res){

                $tmp=AssetCustom::getAssetDeviceFieldForView($res);

                $details = Asset::with(['supplier','barcode.barcodetype','manufacturer','upgradehistory.asset.assetmodel'])->find($res->id);

                $assignto=AssetUpgrade::where('upgrade_asset_id',$res->id)->whereNull('ended_at')->with(['mainAsset.assetmodel'])->get()->pluck('mainAsset');
                if(count($assignto)>0){
                    $assignto=array_flatten($assignto)[0];
                }else{
                    $assignto=[];
                }
                
                $license = License::leftJoin('software_license_assign',function($qry1){
                    $qry1->on('software_license.id','=','software_license_assign.software_license_id');
                })->where('software_license_assign.asset_id',$res->id)->with(['supplier', 'manufacture'])->get();

                $timeline = AssetTransaction::withTrashed()->with(['location','status','employee.Location.location','user'])->where('asset_id','=',$res->id)->orderBy('id','DESC')->get();

                if(count($details)>0){
                    return view( 'reports::reports.asset_detail_summery_report' )
                        ->with([
                            "details"       =>$details,
                            'assetDetails'  =>$tmp,
                            'assignto'      =>$assignto,
                            'license'       =>$license,
                            'timeline'      =>$timeline,
                            'old'           => ['code'=>$request->code]
                        ]);
                }else{
                    return view( 'errors.404' );               
                        
                }
            }else{
                return view( 'reports::reports.asset_detail_summery_report' )->with([
                    'old' => ['code'=>$request->code],
                    'error' => 'Item not exist'
                ]);
            }

        }else{
            return view( 'reports::reports.asset_detail_summery_report' )->with([
                'old' => ['code'=>'']
            ]);
        }
    }

    public function downloadAssetDetailSummeryPdf(Request $request)
    {

        $res = Asset::find($request->id);

        $tmp=AssetCustom::getAssetDeviceFieldForView($res);

        $details = Asset::with([
            'supplier',
            'barcode.barcodetype',
            'manufacturer',
            'upgradehistory.asset.assetmodel'
        ])->find($res->id);

        $assignto = AssetUpgrade::where('upgrade_asset_id',$res->id)
            ->whereNull('ended_at')
            ->with(['mainAsset.assetmodel'])
            ->get()
            ->pluck('mainAsset');

        if(count($assignto)>0){
            $assignto=array_flatten($assignto)[0];
        }else{
            $assignto=[];
        }
        
        $license = License::leftJoin('software_license_assign',function($qry1){
            $qry1->on('software_license.id','=','software_license_assign.software_license_id');
        })->where('software_license_assign.asset_id',$res->id)->with(['supplier', 'manufacture'])->get();

        $filename="Report of Asset Details";

        if($details){
            $page1 = view('reports::prints.assetDetailSummeryReportPdf')->with(['details' => $details,'assetDetails' =>$tmp, 'assignto' =>$assignto, 'license'=>$license])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Asset Detail Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Asset Detail Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function downloadAssetDetailTimelineSummeryPdf(Request $request)
    {

        $details = Asset::find($request->id);

        $timeline = AssetTransaction::withTrashed()->with(['location','status','employee.Location.location','user'])->where('asset_id','=',$details->id)->orderBy('id','DESC')->get();

        $filename="Time Line of".$details->inventory_no;

        if($details){
            $page1 = view('reports::prints.assetDetailTimelineSummeryReportPdf')->with(['details' => $details,'timeline' => $timeline])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Time Line']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Asset Time line Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function userSummeryReportView(Request $request)
    {
        $data = User::with(['employee.parent','UserRole','employee.Location.location','verifiedby','createdBy.employee']);

        $types = UserRole::orderBy('name','ASC')->get();
        $loc = UserLocationFilter::locationHierarchy();

        $txt = $request->search_keyword;
        if($txt!=null || $txt!=''){
            
            $data  = $data->whereIn('employee_id',function($query)use($txt){
                        $query->select('id')->from('employee')
                            ->where('first_name','like','%'.$txt.'%')
                            ->orWhere('last_name','like','%'.$txt.'%')
                            ->orWhere('code','like','%'.$txt.'%');
                    });
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data  = $data->where('varified_status',$old_status);
        }  

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->whereIn('id',function($query)use($type){
                $query->select('user_id')->from('role_users')
                    ->where('role_id',$type);
            });
        }  

        $location = $request->location;
        if($location!=null && $location>0){

            if($request->sub_loc && $request->sub_loc == 1) {
                $usr_loc = UserLocationFilter::getSubLocations($location);

                $data = $data->whereIn('employee_id', function ($query) use ($location, $usr_loc) {
                    $query->select('employee_id')->from('user_location')
                        ->whereIn('location_id', $usr_loc);
                });
            }else{
                $data = $data->whereIn('employee_id', function ($query) use ($location) {
                    $query->select('employee_id')->from('user_location')
                        ->where('location_id', $location);
                });
            }
        }

        $status=array(3=>'All',1=>'Varified',2=>'Rejected',0=>'Not Varified');

        $data = $data->paginate(20);
        $count = $data->total();

        return view('reports::reports.user_report')->with([
            'data'    => $data,
            'types' => $types,
            'locations' => $loc,
            'status' => $status,
            'row_count' =>$count,
            'old'     => [
                'search_keyword'=>$txt,
                'type'=>$type,
                'location'=>$location,
                'status'=>$old_status,
                'sub_loc'=>$request->sub_loc
            ]
        ]);
    }

    public function userAssetReportView(Request $request)
    {
        $data = User::with(['employee.parent','UserRole','employee.Location.location','verifiedby','createdBy.employee']);

        $types = UserRole::orderBy('name','ASC')->get();
        $loc = UserLocationFilter::locationHierarchy();

        $txt = $request->search_keyword;
        if($txt!=null || $txt!=''){

            $data  = $data->whereIn('employee_id',function($query)use($txt){
                $query->select('id')->from('employee')
                    ->where('first_name','like','%'.$txt.'%')
                    ->orWhere('last_name','like','%'.$txt.'%')
                    ->orWhere('code','like','%'.$txt.'%');
            });
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data  = $data->where('varified_status',$old_status);
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->whereIn('id',function($query)use($type){
                $query->select('user_id')->from('role_users')
                    ->where('role_id',$type);
            });
        }

        $location = $request->location;
        if($location!=null && $location>0){

            if($request->sub_loc && $request->sub_loc == 1) {
                $usr_loc = UserLocationFilter::getSubLocations($location);

                $data = $data->whereIn('employee_id', function ($query) use ($location, $usr_loc) {
                    $query->select('employee_id')->from('user_location')
                        ->whereIn('location_id', $usr_loc);
                });
            }else{
                $data = $data->whereIn('employee_id', function ($query) use ($location) {
                    $query->select('employee_id')->from('user_location')
                        ->where('location_id', $location);
                });
            }
        }

        $status=array(3=>'All',1=>'Varified',2=>'Rejected',0=>'Not Varified');

        $data = $data->paginate(20);
        $count = $data->total();

        return view('reports::reports.user_wise_asset_report')->with([
            'data'    => $data,
            'types' => $types,
            'locations' => $loc,
            'status' => $status,
            'row_count' =>$count,
            'old'     => [
                'search_keyword'=>$txt,
                'type'=>$type,
                'location'=>$location,
                'status'=>$old_status,
                'sub_loc'=>$request->sub_loc
            ]
        ]);
    }

    public function downloadUserSummeryExcel(Request $request)
    {
        $data = User::with(['employee.parent','UserRole','employee.Location.location','verifiedby','createdBy.employee']);

        $txt = $request->search_keyword;
        if($txt!=null || $txt!=''){
            
            $data  = $data->whereIn('employee_id',function($query)use($txt){
                        $query->select('id')->from('employee')
                            ->where('first_name','like','%'.$txt.'%')
                            ->orWhere('last_name','like','%'.$txt.'%')
                            ->orWhere('code','like','%'.$txt.'%');
                    });
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data  = $data->where('varified_status',$old_status);
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->whereIn('id',function($query)use($type){
                $query->select('user_id')->from('role_users')
                    ->where('role_id',$type);
            });
        }

        $location = $request->location;
        if($location!=null && $location>0){

            if($request->sub_loc && $request->sub_loc == 1) {
                $usr_loc = UserLocationFilter::getSubLocations($location);

                $data = $data->whereIn('employee_id', function ($query) use ($location, $usr_loc) {
                    $query->select('employee_id')->from('user_location')
                        ->whereIn('location_id', $usr_loc);
                });
            }else{
                $data = $data->whereIn('employee_id', function ($query) use ($location) {
                    $query->select('employee_id')->from('user_location')
                        ->where('location_id', $location);
                });
            }
        }

        $data = $data->orderBy('username')->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->username);
            array_push($dd,$value['employee'][0]->first_name);
            array_push($dd,$value['employee'][0]->last_name);
            if(count($value['UserRole'])>0){
                array_push($dd,$value->UserRole[0]->name);
            }else{
                array_push($dd,'-');
            }
            array_push($dd,$value['employee'][0]->location->location->name);
            array_push($dd,$value['employee'][0]->email);
            array_push($dd,$value->last_login);

            array_push($dd, ($value->createdBy)?$value->createdBy->first_name.' '.$value->createdBy->last_name:'-');
            
            array_push($dd, $value->created_at);
            
            array_push($dd, ($value->verifiedby)?$value->verifiedby->first_name.' '.$value->verifiedby->last_name:'-');
            
            array_push($dd, ($value->varified_date)?$value->varified_date:'-');

            if($value->varified_status==1){
                array_push($dd,'Verified');                
            }else if($value->varified_status==2){
                array_push($dd,'Rejected');                
            }

            if($value->status==1){
                array_push($dd,'Activated');                
            }else if($value->status==2){
                array_push($dd,'Rejected');                
            }else if($value->status==0){
                array_push($dd,'Deactivated');                
            }

            array_push($jsonList, $dd);
            
        }

        $filename="Report of Users";

        $tmp2 = $jsonList;

        $headers=['User Name', 'First Name', 'Last Name', 'Role', 'Location', 'Email', 'Last Login', 'created By', 'created Date', 'Verified By', 'Verified Date', 'Verify Status', 'Status'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

            });

        })->download('xls');
    }

    public function downloadUserSummeryPdf(Request $request)
    {
        $data = User::with(['employee.parent','UserRole','employee.Location.location','verifiedby','createdBy.employee']);

        $types = UserRole::orderBy('name','ASC')->get();
        $loc = UserLocationFilter::locationHierarchy();

        $txt = $request->search_keyword;
        if($txt!=null || $txt!=''){
            
            $data  = $data->whereIn('employee_id',function($query)use($txt){
                        $query->select('id')->from('employee')
                            ->where('first_name','like','%'.$txt.'%')
                            ->orWhere('last_name','like','%'.$txt.'%')
                            ->orWhere('code','like','%'.$txt.'%');
                    });
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3){
            $data  = $data->where('varified_status',$old_status);
        }  

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->whereIn('id',function($query)use($type){
                $query->select('user_id')->from('role_users')
                    ->where('role_id',$type);
            });
        }  

        $location = $request->location;
        if($location!=null && $location>0){
            if($request->sub_loc && $request->sub_loc == 1) {
                $usr_loc = UserLocationFilter::getSubLocations($location);

                $data = $data->whereIn('employee_id', function ($query) use ($location, $usr_loc) {
                    $query->select('employee_id')->from('user_location')
                        ->whereIn('location_id', $usr_loc);
                });
            }else{
                $data = $data->whereIn('employee_id', function ($query) use ($location) {
                    $query->select('employee_id')->from('user_location')
                        ->where('location_id', $location);
                });
            }
        }

        $data = $data->orderBy('username')->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->username);
            array_push($dd,$value['employee'][0]->first_name);
            array_push($dd,$value['employee'][0]->last_name);
            if(count($value['UserRole'])>0){
                array_push($dd,$value->UserRole[0]->name);
            }else{
                array_push($dd,'-');
            }
            array_push($dd,$value['employee'][0]->location->location->name);
            array_push($dd,$value['employee'][0]->email);
            array_push($dd,$value->last_login);

            array_push($dd, ($value->createdBy)?$value->createdBy->first_name.' '.$value->createdBy->last_name:'-');
            
            array_push($dd, $value->created_at);
            
            array_push($dd, ($value->verifiedby)?$value->verifiedby->first_name.' '.$value->verifiedby->last_name:'-');
            
            array_push($dd, ($value->varified_date)?$value->varified_date:'-');

            if($value->varified_status==1){
                array_push($dd,'Verified');                
            }else if($value->varified_status==2){
                array_push($dd,'Rejected');                
            }

            if($value->status==1){
                array_push($dd,'Activated');                
            }else if($value->status==2){
                array_push($dd,'Rejected');                
            }else if($value->status==0){
                array_push($dd,'Deactivated');                
            }

            array_push($jsonList, $dd);
            
        }

        $filename="Report of Users";

        $tmp2 = $jsonList;

        $headers=['User Name', 'First Name', 'Last Name', 'Role', 'Location', 'Email', 'Last Login', 'created By', 'created Date', 'Verified By', 'Verified Date', 'Verify Status', 'Status'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.userSummeryReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'User Detail Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - User Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function SoftwareSummeryReportView(Request $request)
    {
        $loc = UserLocationFilter::locationHierarchy();

        $licenses = License::all();

        $data = LicenseDetails::whereNull('deleted_at')->with(['software','asset.manufacturer','asset.assetTransaction.location.parentLocation']);

        $license_basic = null;

        $license_id = $request->license;
        if($license_id!=null && $license_id!='0'){
            $data = $data->where('software_license_id',$license_id);
            $license_basic = License::with(['supplier','manufacture'])->find($license_id);
        }

        $location = $request->location;

        if($request->sub_loc && $request->sub_loc=='on'){
            if($location!=null){
                $data  = $data->whereIn('asset_id',function($cc) use($location)
                {
                    $cc->select('asset_id')
                        ->from('asset_transaction')
                        ->whereNull('deleted_at')
                        ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                });
            }

            $sub_loc=1;
        }else{
            if($location!=null){
                if($location == 0) {
                    $data = $data->whereIn('asset_id', function ($aa) use ($location) {
                        $aa->select('asset_id')
                            ->from('asset_transaction')
                            ->whereIn('location_id', UserLocationFilter::getSubLocations($location))
                            ->whereNull('deleted_at');
                    });
                }else{
                    $data = $data->whereIn('asset_id', function ($aa) use ($location) {
                        $aa->select('asset_id')
                            ->from('asset_transaction')
                            ->where('location_id', $location)
                            ->whereNull('deleted_at');
                    });
                }
            }
            $sub_loc=0;
        }

        $data = $data->paginate(20);
        
        $count = $data->total();

        $used_count = $count;

        return view('reports::reports.software_report')->with([
            'data'          => $data,
            'data_license'  => $license_basic,
            'licenses'      => $licenses,
            'locations'     => $loc,
            'row_count'     => $count,
            'used_count'    => $used_count,
            'old' => [
                'license_id'   =>$license_id,
                'location'     =>$location,
                'sub_loc'      =>$sub_loc
            ]
        ]);
    }

    public function downloadSoftwareSummeryExcel(Request $request)
    {
        $loc = UserLocationFilter::locationHierarchy();

        $licenses = License::all();

        $data = LicenseDetails::whereNull('deleted_at')->with(['software','asset.manufacturer','asset.assetTransaction.location.parentLocation']);

        $license_basic = null;

        $sub_data = [];

        $license_id = $request->license;
        if($license_id!=null && $license_id!='0'){
            $data = $data->where('software_license_id',$license_id);
        }

        $location = $request->location;

        if($request->sub_loc && $request->sub_loc=='on'){
            if($location!=null){
                $data  = $data->whereIn('asset_id',function($cc) use($location)
                {
                    $cc->select('asset_id')
                        ->from('asset_transaction')
                        ->whereNull('deleted_at')
                        ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                });
            }

            $sub_loc=1;
        }else{
            if($location!=null){
                $data  = $data->whereIn('asset_id',function($aa) use($location)
                {
                    $aa->select('asset_id')
                        ->from('asset_transaction')
                        ->where('location_id',$location)
                        ->whereNull('deleted_at');
                });
            }
            $sub_loc=0;
        }

        $data = $data->get();

        $row_count = $data->count();

        $used_count = LicenseDetails::whereNull('deleted_at')->with(['software','asset.manufacturer'])->get();
        $used_count = $used_count->count();

        if($license_id!=null && $license_id!='0'){
            $license_basic = License::with(['supplier','manufacture'])->find($license_id);

            $subd1[] = ['','',''];
            $subd1[] = ['No of License','Usage of License','Remaining License','','','Supplier','License Start Date','License End Date'];
            $subd1[] = [$license_basic->max_users,$used_count,$license_basic->max_users-$used_count,'','',$license_basic['supplier']->name,$license_basic->license_from,$license_basic->license_to];
            $subd1[] = ['','',''];

            array_push($sub_data,$subd1);
        }else{
            $subd1[] = ['','',''];
            $subd1[] = ['No of License','Usage of License','Remaining License','','','Supplier','License Start Date','License End Date'];
            $subd1[] = ['','','','','','','',''];
            $subd1[] = ['','',''];

            array_push($sub_data,$subd1);
        }

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,(($value['asset']->assetTransaction->location->parentLocation)?$value['asset']->assetTransaction->location->parentLocation->name:'-'));
            array_push($dd,$value['asset']->assetTransaction->location->name);
            array_push($dd,$value['asset']->inventory_no);
            array_push($dd,$value['asset']->asset_no);
            array_push($dd,$value['asset']['manufacturer']->name);
            array_push($dd,$value['asset']->model);
            array_push($dd,$value->note);
            array_push($dd,$value->reference_no);
            array_push($dd,date_format($value->created_at, 'Y-M-d'));
            array_push($dd,$value['software']->license_to);

            array_push($jsonList, $dd);
        }

        $filename="Software Asset Usage Report";

        $tmp2 = $jsonList;

        $headers=['Parent Location','Location','Inventory No', 'Serial No', 'Manufacture', 'Model', 'IP Address', 'Reference No', 'Install Date', 'Expiry Date'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2,$sub_data) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2,$sub_data){

                $sheet->fromArray($sub_data[0], null, 'A1', false, false);

                $sheet->fromArray($tmp2, null, 'A1', false, false);

                $sheet->prependRow(array(
                    'Software Asset Usage Report'
                ));

                $sheet->mergeCells('A1:H1');

                $sheet->row(3, function($row) {
                    $row->setBackground('#FFB42A');
                    $row->setBorder('thin');
                });
                $sheet->row(4, function($row) {
                    $row->setBackground('#FFB42A');
                    $row->setBorder('thin');
                });

                $sheet->cell('A1:H1', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('A6:H6', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('A3:A4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('B3:B4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('C3:C4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('F3:F4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('G3:G4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

                $sheet->cell('H3:H4', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                        'bold'       =>  true
                    ));
                });

            });

        })->download('xls');
    }

    public function downloadSoftwareSummeryPdf(Request $request)
    {
        $loc = UserLocationFilter::locationHierarchy();

        $licenses = License::all();

        $data = LicenseDetails::whereNull('deleted_at')->with(['software','asset.manufacturer','asset.assetTransaction.location.parentLocation']);

        $license_basic = null;

        $license_id = $request->license;
        if($license_id!=null && $license_id!='0'){
            $data = $data->where('software_license_id',$license_id);
            $license_basic = License::with(['supplier','manufacture'])->find($license_id);
        }

        $location = $request->location;

        if($request->sub_loc && $request->sub_loc=='on'){
            if($location!=null){
                $data  = $data->whereIn('asset_id',function($cc) use($location)
                {
                    $cc->select('asset_id')
                        ->from('asset_transaction')
                        ->whereNull('deleted_at')
                        ->whereIn('location_id',UserLocationFilter::getSubLocations($location));
                });
            }

            $sub_loc=1;
        }else{
            if($location!=null){
                $data  = $data->whereIn('asset_id',function($aa) use($location)
                {
                    $aa->select('asset_id')
                        ->from('asset_transaction')
                        ->where('location_id',$location)
                        ->whereNull('deleted_at');
                });
            }
            $sub_loc=0;
        }

        $data = $data->get();

        $row_count = $data->count();

        $used_count = LicenseDetails::whereNull('deleted_at')->with(['software','asset.manufacturer'])->get();
        $used_count = $used_count->count();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,(($value['asset']->assetTransaction->location->parentLocation)?$value['asset']->assetTransaction->location->parentLocation->name:'-'));
            array_push($dd,$value['asset']->assetTransaction->location->name);
            array_push($dd,$value['asset']->inventory_no);
            array_push($dd,$value['asset']->asset_no);
            array_push($dd,$value['asset']['manufacturer']->name);
            array_push($dd,$value['asset']->model);
            array_push($dd,$value->note);
            array_push($dd,$value->reference_no);
            array_push($dd,date_format($value->created_at, 'Y-M-d'));
            array_push($dd,$value['software']->license_to);

            array_push($jsonList, $dd);
        }

        $filename="Report of software";

        $tmp2 = $jsonList;

        $headers=['Parent Location','Location','Inventory No', 'Serial No', 'Manufacture', 'Model', 'IP Address', 'Reference No', 'Install Date', 'Expiry Date'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.softwareSummeryReportPdf')->with(['data'=>$tmp2,'basic'=>$license_basic,'used_count'=>$used_count])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Software Detail Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Software Summery");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function SoftwareReportView(Request $request)
    {
        $supplier = Supplier::lists('name','id');
        $manufacturers = Manufacturer::lists('name','id');
        $data = License::whereNull('deleted_at')->with(['details','supplier','manufacture']);

        if($request->supplier != ''){
            $data->where('supplier_id',$request->supplier);
        }

        if($request->name != ''){
            $data->where('name', 'like','%'.$request->name.'%');
        }

        if($request->serial != ''){
            $data->where('asset_no', 'like','%'.$request->serial.'%');
        }

        if($request->manufacturer != ''){
            $data->where('manufacture_id',$request->manufacturer);
        }

        $data = $data->paginate(20);
        
        return view('reports::reports.software_list')->with([
            'data' => $data,
            'suppliers' => $supplier,
            'manufacturers' => $manufacturers,
            'old' => $request
        ]);
    }

    public function downloadSoftwareReportExcel(Request $request)
    {
        $data = License::whereNull('deleted_at')->with(['details','supplier','manufacture']);

        if($request->supplier != ''){
            $data->where('supplier_id',$request->supplier);
        }

        if($request->name != ''){
            $data->where('name', 'like','%'.$request->name.'%');
        }

        if($request->serial != ''){
            $data->where('asset_no', 'like','%'.$request->serial.'%');
        }

        if($request->manufacturer != ''){
            $data->where('manufacture_id',$request->manufacturer);
        }

        $data = $data->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->asset_no);
            array_push($dd,$value->name);
            array_push($dd,$value['supplier']->name);
            array_push($dd,$value['manufacture']->name);
            array_push($dd,$value->max_users);
            array_push($dd,count($value['details']));
            array_push($dd,$value->max_users-count($value['details']));
            array_push($dd,$value->license_from);
            array_push($dd,$value->license_to);

            array_push($jsonList, $dd);
        }

        $filename="Software Asset Report";

        $tmp2 = $jsonList;

        $headers=['Serial No', 'Software', 'Supplier', 'Manufacture', 'No of License', 'No of Allocation', 'Remaining License', 'License Start Date', 'License Expiry Date'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

                $sheet->prependRow(array(
                    'Software Asset Report'
                ));

                $sheet->mergeCells('A1:I1');

                $sheet->row(2, function($row) {
                    $row->setBackground('#FFB42A');
                    $row->setBorder('thin');
                });

                $sheet->cell('A1:I1', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                    ));
                });

            });

        })->download('xls');
    }

    public function downloadSoftwareReportPdf(Request $request)
    {
        
        $data = License::whereNull('deleted_at')->with(['details','supplier','manufacture']);

        if($request->supplier != ''){
            $data->where('supplier_id',$request->supplier);
        }

        if($request->name != ''){
            $data->where('name', 'like','%'.$request->name.'%');
        }

        if($request->serial != ''){
            $data->where('asset_no', 'like','%'.$request->serial.'%');
        }

        if($request->manufacturer != ''){
            $data->where('manufacture_id',$request->manufacturer);
        }

        $data = $data->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->asset_no);
            array_push($dd,$value->name);
            array_push($dd,$value['supplier']->name);
            array_push($dd,$value['manufacture']->name);
            array_push($dd,$value->max_users);
            array_push($dd,count($value['details']));
            array_push($dd,$value->max_users-count($value['details']));
            array_push($dd,$value->license_from);
            array_push($dd,$value->license_to);

            array_push($jsonList, $dd);
        }

        $filename="Software Asset Report";

        $tmp2 = $jsonList;

        $headers=['Serial No', 'Software', 'Supplier', 'Manufacture', 'No of License', 'No of Allocation', 'Remaining License', 'License Start Date', 'License Expiry Date'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.softwareReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Software Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Software Report");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function supplierReportView(Request $request)
    {
        $supplier = Supplier::where('status',1);

        if($request->keywords != ''){
            $supplier->where(function($q) use ($request){
               $q->where('name','like','%'.$request->keywords.'%')
                   ->orWhere('address','like','%'.$request->keywords.'%')
                   ->orWhere('city','like','%'.$request->keywords.'%')
                   ->orWhere('phone','like','%'.$request->keywords.'%')
                   ->orWhere('fax','like','%'.$request->keywords.'%')
                   ->orWhere('email','like','%'.$request->keywords.'%');
            });
        }


        $data = $supplier->paginate(20);

        return view('reports::reports.supplier_list')->with([
            'data' => $data,
            'old' => $request
        ]);
    }

    public function downloadSupplierReportExcel(Request $request)
    {
        $supplier = Supplier::where('status',1);

        if($request->keywords != ''){
            $supplier->where(function($q) use ($request){
                $q->where('name','like','%'.$request->keywords.'%')
                    ->orWhere('address','like','%'.$request->keywords.'%')
                    ->orWhere('city','like','%'.$request->keywords.'%')
                    ->orWhere('phone','like','%'.$request->keywords.'%')
                    ->orWhere('fax','like','%'.$request->keywords.'%')
                    ->orWhere('email','like','%'.$request->keywords.'%');
            });
        }


        $data = $supplier->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->name);
            array_push($dd,$value->address);
            array_push($dd,$value->city);
            array_push($dd,$value->phone);
            array_push($dd,$value->fax);
            array_push($dd,$value->email);

            array_push($jsonList, $dd);
        }

        $filename="Supplier Report";

        $tmp2 = $jsonList;

        $headers=['Supplier Name', 'Address', 'City', 'Phone No', 'Fax No', 'E-Mail'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

                $sheet->prependRow(array(
                    'Supplier Report'
                ));

                $sheet->mergeCells('A1:I1');

                $sheet->row(2, function($row) {
                    $row->setBackground('#FFB42A');
                    $row->setBorder('thin');
                });

                $sheet->cell('A1:I1', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                    ));
                });

            });

        })->download('xls');
    }

    public function downloadSupplierReportPdf(Request $request)
    {

        $supplier = Supplier::where('status',1);

        if($request->keywords != ''){
            $supplier->where(function($q) use ($request){
                $q->where('name','like','%'.$request->keywords.'%')
                    ->orWhere('address','like','%'.$request->keywords.'%')
                    ->orWhere('city','like','%'.$request->keywords.'%')
                    ->orWhere('phone','like','%'.$request->keywords.'%')
                    ->orWhere('fax','like','%'.$request->keywords.'%')
                    ->orWhere('email','like','%'.$request->keywords.'%');
            });
        }


        $data = $supplier->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->name);
            array_push($dd,$value->address);
            array_push($dd,$value->city);
            array_push($dd,$value->phone);
            array_push($dd,$value->fax);
            array_push($dd,$value->email);

            array_push($jsonList, $dd);
        }

        $filename="Supplier Report";

        $tmp2 = $jsonList;

        $headers=['Supplier Name', 'Address', 'City', 'Phone No', 'Fax No', 'E-Mail'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.supplierReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Supplier Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Supplier Report");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

    public function manufacturerReportView(Request $request)
    {
        $manufacturer = Manufacturer::where('status',1);

        if($request->keywords != ''){
            $manufacturer->where('name','like','%'.$request->keywords.'%');
        }


        $data = $manufacturer->paginate(20);

        return view('reports::reports.manufacturer_list')->with([
            'data' => $data,
            'old' => $request
        ]);
    }

    public function downloadManufacturerReportExcel(Request $request)
    {
        $manufacturer = Manufacturer::where('status',1);

        if($request->keywords != ''){
            $manufacturer->where('name','like','%'.$request->keywords.'%');
        }


        $data = $manufacturer->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->name);

            array_push($jsonList, $dd);
        }

        $filename="Manufacturer Report";

        $tmp2 = $jsonList;

        $headers=['Manufacturer Name'];

        array_unshift($tmp2, $headers);

        Excel::create($filename, function($excel) use($tmp2) {

            $excel->sheet('Sheetname', function($sheet) use($tmp2){

                $sheet->fromArray($tmp2, null, 'A1', false, false);

                $sheet->prependRow(array(
                    'Manufacturer Report'
                ));

                $sheet->mergeCells('A1:I1');

                $sheet->row(2, function($row) {
                    $row->setBackground('#FFB42A');
                    $row->setBorder('thin');
                });

                $sheet->cell('A1:I1', function($cell) {
                    $cell->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                    ));
                });

            });

        })->download('xls');
    }

    public function downloadManufacturerReportPdf(Request $request)
    {

        $manufacturer = Manufacturer::where('status',1);

        if($request->keywords != ''){
            $manufacturer->where('name','like','%'.$request->keywords.'%');
        }


        $data = $manufacturer->get();

        $jsonList = array();

        foreach ($data as $value) {
            $dd = array();

            array_push($dd,$value->name);

            array_push($jsonList, $dd);
        }

        $filename="Manufacturer Report";

        $tmp2 = $jsonList;

        $headers=['Manufacturer Name'];

        array_unshift($tmp2, $headers);

        if($tmp2){
            $page1 =  view('reports::prints.manufacturerReportPdf')->with(['data'=>$tmp2])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf = new PdfTemplate(["no"=>date('Y-m-d'),'title'=>'Supplier Report']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("Report - Manufacturer Report");
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage('L', 'A3');
        $pdf->writeHtml($page1);
        $pdf->output($filename.".pdf", 'I');
    }

}
