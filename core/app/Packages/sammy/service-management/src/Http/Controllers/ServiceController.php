<?php
namespace Sammy\ServiceManage\Http\Controllers;


use App\Classes\AuditLogger;
use App\Classes\UserLocationFilter;
use App\Http\Controllers\Controller;
use App\Models\AssetTransaction;

use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;
use Sentinel;
use App\Classes\PdfTemplate;
use DB;
use Response;

use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;
use Sammy\ServiceManage\Http\Requests\BarcodeRequest;
use Sammy\ServiceManage\Models\Service;
use Sammy\ServiceTypeManage\Models\ServiceType;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\RequestManage\Models\RequestDetail;

class ServiceController extends Controller {

	/*
	|--------------------------------------------------------------------------
	|  Manufacturers Controller
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
	    $this->auditLogger = $auditLogger;
		//$this->middleware('guest');
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addView(Request $request)
	{
	    $types       = ServiceType::lists('name','id')->prepend('select type', '0');
	    $asset_modal = AssetModal::lists('name', 'id')->prepend('Select Modal',0);

	    $old_inv_no = $request->inv_no;
	    $location = $request->location;
        $serial_no = $request->serial_no;
        
        $old_modal = $request->asset_modal;
        
        $assets = Asset::with(['assetmodel','supplier','transaction.location']);
        
        if($old_inv_no!=null && $old_inv_no!="" && $old_inv_no!=0){
            $assets = $assets->where('inventory_no', 'like', '%' .$old_inv_no. '%');
        }
        
        $users = UserLocationFilter::getLocationsId();

        $users=array_flatten($users);

        array_push($users, Sentinel::getUser()->employee_id);

        $service_approved_asset = RequestDetail::whereIn('send_by',$users)
                ->where('request_type_id',2)
                ->where('status',2)
                ->where('service_status',0)
                ->with(['asset']);

        if($old_modal!=null && $old_modal!="" && $old_modal!="0"){
            $assets = $assets->where('asset_model_id',$old_modal);
            $service_approved_asset=$service_approved_asset->where('asset_type_id',$old_modal);
        }

        $service_approved_asset=$service_approved_asset->get()->pluck(['asset']);

        $tmp_spa=[];
        
        foreach ($service_approved_asset as $value) {
            array_push($tmp_spa, intval($value->id));
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

        if($location!=null && $location>0)
        {
             $assets = $assets->whereIn('asset.id',function($aa) use($location)
             {
                 $aa->select('asset_id')->from('asset_transaction')
                 ->where('location_id',$location)
                 ->whereNull('deleted_at');
             });
        }

        if($serial_no!=null && $serial_no!="")
        {
            $assets = $assets->where('asset_no','like','%'.$serial_no.'%');
        }

        if($request->date_from!=null && $request->date_from!="")
        {
            $assets = $assets->where('created_at','>=',$request->date_from.' 00:00:00');
        }

        if($request->date_to!=null && $request->date_to!="")
        {
            $assets = $assets->where('created_at','<=',$request->date_to.' 23:59:59');
        }

        $assets = $assets->whereNotIn('id',$notcheckIn);
        
        $assets = $assets->whereIn('id',$tmp_spa);

        $assets = $assets->get();

        $locations = UserLocationFilter::getLocations();

        return view( 'serviceManage::views.add' )->with([
            "types" =>$types,
             "locations"=>$locations,
             "asset_modal"=>$asset_modal,
             "assets"=>$assets,
             "old" => [
                 'modal' => $request->asset_modal,
                 'location' => $request->location,
                 'serial_no' => $request->serial_no,
                 'inventory' => $request->inv_no,
                 'date_from' => $request->date_from,
                 'date_to' => $request->date_to
             ]
        ]);
	}

    /**
     * Add new entity to database
     *
     * @param ManufacturerRequest $request
     * @return Redirect to menu add
     */
	public function add(Request $request)
	{
	    $user = Sentinel::getUser();

        try{
            DB::transaction(function () use ($request,$user) {
                $asset = AssetTransaction::where('asset_id', $request->get('asset'))->first();

                $service      = Service::create([
                    'service_type_id'=> $request->get('type'),
                    'asset_id'       => $request->get('asset'),
                    'cost'           => $request->get('cost'),
                    'service_in_date'=> $request->get('service_date'),
                    'serviced_by'    => $request->get('serviced_by'),
                    'notes'          => $request->get('notes'),
                    'user_id'        => $user->employee_id
                ]);

                $service->service_no = "SER_".$request->get('asset')."_".$service->id;
                $service->save();

                AssetTransaction::where('asset_id', $request->get('asset'))
                ->whereNull('deleted_at')->delete();

                $aa = AssetTransaction::create([
                    'asset_id'    => $request->get('asset'),
                    'location_id' => $asset->location_id,
                    'status_id'   => 5,
                    'user_id'     => $user->employee_id,
                    'type'     => 'To Service From',
                ]);

                $this->auditLogger->addLog('Service', 'Add Entry', $service->id, null, $service->toJson());

                if (!$service) {
                    throw new TransactionException('Record wasn\'t updated', 100);
                }
            });
        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                Log::info("Transaction Error");
                return Response::json(['status'=>0]);
            }
        } catch (Exception $e) {
            return Response::json(['status'=>0]);
        }

        return Response::json(['status'=>1]);


    }

	/**
     * Show the list.
     *
     * @return Response
     */
    public function listView(Request $request)
    {
        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');
        $locations = UserLocationFilter::getLocations();
        $location_id = $request->location;
        $serial_no = $request->serial_no;

        $service = Service::with(['type','asset.transaction.location','asset.supplier','asset.assetmodel']);

        $service  = $service->whereIn('asset_id',function($aa) use($locations)
        {
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        });


        if($location_id!=null && $location_id>0){
            $service = $service->whereIn('asset_id',function($aa) use($location_id)
            {
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$location_id)->whereNull('deleted_at');
            });
        }

        if($serial_no!=null && $serial_no!=""){
            $service = $service->whereIn('asset_id',function($aa) use($serial_no)
            {
                $aa->select('id')->from('asset')->where('asset_no',$serial_no);
            });
        }

        $no = $request->no;
        if($no!=null && $no!=""){
            $service = $service->where('service_no', 'like', '%' .$no. '%');
        }

        $service = $service->get();

        return view( 'serviceManage::views.list' )->with([
            "asset_modal"=>$asset_modal,
            "locations"=>$locations,
            "services"=>$service
        ]);



    }


    /**
     * Show the list.
     *
     * @return Response
     */
    public function detailView(Request $request,$id)
    {
      
        $service = Service::selectRaw("*,
            TIMESTAMPDIFF(DAY,service_in_date,now()) as service_days
            ")->with(['type','asset.transaction.location','asset.supplier','asset.assetmodel']);

        $service = $service->find($id);

        if(!$service){
            return response()->view("errors.404");
        }

        return view( 'serviceManage::views.details' )->with([
            "service"=>$service
        ]);



    }

    /**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function printView(Request $request,$id)
	{
      
        $service = Service::selectRaw("*,
            TIMESTAMPDIFF(DAY,service_in_date,now()) as service_days
            ")->with(['type','asset.transaction.location','asset.supplier','asset.assetmodel','asset.barcode.barcodetype']);

        $service = $service->find($id);

        if($service){
            $page1 =  view('serviceManage::print.service')->with(['service'=>$service])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'), 'title' => '' ]);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("service_".$service->service_no);
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output("service_".$service->service_no.".pdf", 'I');



	}

	/**
	 * json list data.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		if($request->ajax()){
            $data = Service::with('asset')->where('deleted_at', '=', NULL)->get();

            $jsonList = array();
            $i = 1;
            foreach ($data as $key => $service) {
                $dd = array();
                array_push($dd, $i);

                if ($service->asset->asset_no != '') {
                    array_push($dd, '<a class="blue" href="'.url('asset/view/' . $service->asset->id).'"><u>'.$service->asset->asset_no.'</u></a>');
                } else {
                    array_push($dd, "-");
                }

                if ($service->name != '') {
                    array_push($dd, $service->description);
                } else {
                    array_push($dd, "-");
                }

                if($service->cost != '') {
                    array_push($dd, $service->cost);
                } else {
                    array_push($dd, "-");
                }

                if($service->completed_date != '') {
                    array_push($dd, $service->completed_date);
                } else {
                    array_push($dd, "-");
                }

                if($service->next_date != '') {
                    array_push($dd, $service->next_date);
                } else {
                    array_push($dd, "-");
                }

                if($service->serviced_by != '') {
                    array_push($dd, $service->serviced_by);
                } else {
                    array_push($dd, "-");
                }



                $permissions = Permission::whereIn('name', ['service.edit', 'admin'])->where('status', '=', 1)->lists('name');
                if (Sentinel::hasAnyAccess($permissions)) {
                    array_push($dd, '<a href="#" class="blue" onclick="window.location.href=\'' . url('service/edit/' . $service->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="fa fa-pencil"></i></a>');
                } else {
                    array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
                }

                $permissions = Permission::whereIn('name', ['service.delete', 'admin'])->where('status', '=', 1)->lists('name');
                if (Sentinel::hasAnyAccess($permissions)) {
                    array_push($dd, '<a href="#" class="red item-delete" data-id="' . $service->id . '" data-toggle="tooltip" data-placement="top" title="Delete Service Type"><i class="fa fa-trash-o"></i></a>');
                } else {
                    array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
                }

                array_push($jsonList, $dd);
                $i++;
            }
            return Response::json(array('data' => $jsonList));


			return Response::json(array('data'=>$jsonList));
		}else{
			return Response::json(array('data'=>[]));
		}
	}


	/**
	 * Activate or Deactivate
	 * @param  Request $request id
	 * @return json
	 */
	public function status(Request $request)
	{

	}

	/**
	 * Delete
	 * @param  Request $request id
	 * @return Json
	 */
	public function delete(Request $request)
	{
        if($request->ajax()){
            $id = $request->input('id');
            $service = Service::find($id);
            if($service){
                $service->delete();
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
	}


    /**
     * Show the list.
     *
     * @return Response
     */
    public function trashListView()
    {

        return view( 'manufacturerManage::manufacturer.trash' );
    }

    /**
	 * RESTORE
	 * @param  Request $request id
	 * @return Json
	 */
	public function restore(Request $request)
	{
        if($request->ajax()){
            $id = $request->input('id');
            try{
                $manufact = ServiceType::withTrashed()->find($id)->restore();
                return response()->json(['status' => 'success']);
            }catch (Exception $ex){
                return response()->json(['status' => 'error']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
	}

	/**
	 * RESTORE
	 * @param  Request $request id
	 * @return Json
	 */
	public function startService(Request $request)
	{
        if($request->ajax()){
            $id = $request->input('id');
            try{
                $aa = Service::find($id)->find($id);
                $old = $aa->replicate();
                $aa->start_date = date('Y-m-d');
                $aa->save();
                $this->auditLogger->addLog('Service', 'Start Service', $aa->id, $old->toJson(), $aa->toJson());
                return response()->json(['status' => 1]);
            }catch (Exception $ex){
                return response()->json(['status' => 0]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
	}

	/**
	 * RESTORE
	 * @param  Request $request id
	 * @return Json
	 */
	public function completeService(Request $request)
	{
        if($request->ajax()){
            $id = $request->input('id');
            $user = Sentinel::getUser();

            try{
                $aa = Service::find($id)->find($id);
                $old = $aa->replicate();
                $aa->completed_date = date('Y-m-d');
                $aa->save();

                $asset = AssetTransaction::where('asset_id', $aa->asset_id)->first();
                AssetTransaction::where('asset_id', $aa->asset_id)->whereNull('deleted_at')->delete();

                $aa = AssetTransaction::create([
                    'asset_id' => $aa->asset_id,
                    'location_id' => $asset->location_id,
                    'status_id' => ASSET_UNDEPLOY,
                    'user_id' => $user->employee_id,
                    'type' => 'Check-In To',
                ]);

                $this->auditLogger->addLog('Service', 'Complete Service', $aa->id, $old->toJson(), $aa->toJson());
                return response()->json(['status' => 1]);
            }catch (Exception $ex){
                return response()->json(['status' => 0]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
	}


    /**
     * show edit view.
     *
     * @return Response
     */
    public function jsonTrashList(Request $request)
    {
        if($request->ajax()){
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


            return Response::json(array('data'=>$jsonList));
        }else{
            return Response::json(array('data'=>[]));
        }
    }

	/**
	 * show edit view.
	 *
	 * @return Response
	 */
	public function editView($id)
	{

	}

	/**
	 * save edit
	 *
	 * @return Redirect to menu add
	 */
	public function edit(MenuRequest $request, $id)
	{

	}
}
