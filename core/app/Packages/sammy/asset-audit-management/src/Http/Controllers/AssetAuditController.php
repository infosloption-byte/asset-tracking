<?php
namespace Sammy\AuditManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Classes\PdfTemplate;
use App\Classes\UserLocationFilter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeviceModal;
use App\Models\FieldSet;
use App\Models\Image;
use App\Models\Status;
use DB;
use Excel;
use File;
use Illuminate\Http\Request;
use Log;
use Response;
use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Http\Requests\AssetModalRequest;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;
use Sentinel;

class AssetAuditController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| AssetModal Controller
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
     * Show the list.
     *
     * @return Response
     */
    public function listView(Request $request){
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

        return view('views::views.list')->with([
            'assets'=>$data,
            'asset_models'=>$asset_models,
            'locations'=>$locations,
            'status'=>$status,
            'old'=>['ser_no'=>$ser_no,'inv_no'=>$inv_no,'location'=>$location,'status'=>$stat,'model'=>$model]
            ]);

    }


    /**
     * Show the list.
     *
     * @return Response
     */
    public function printAll(Request $request)
    {

        $assets = $request->assets;

        if(count($assets)==0){
            return redirect( 'audit/asset/list' )->with([ 
                'error' => true,
                'error.message' => 'Error! please select atleast one asset',
                'error.title'   => 'Error!' 
            ]);
        }

        $user = Sentinel::getUser();

        $data = Asset::with(['depreciationtype','transaction.status','transaction.location'])
            ->whereIn('id', $assets);
        $data = $data->get();

        if($data){
            $page1 =  view('views::print.assets')->with(['assets'=>$data,'user'=>$user])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'), 'title' => 'Asset Audit']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("audit_".date('Y_m_d'));
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output("audit_".date('Y_m_d').".pdf", 'I');


    }




}
