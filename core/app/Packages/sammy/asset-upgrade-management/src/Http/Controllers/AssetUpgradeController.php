<?php
namespace Sammy\AssetUpgradeManage\Http\Controllers;

use App\Classes\PdfTemplate;
use App\Classes\UserLocationFilter;
use App\Models\Category;
use App\Models\DeviceModal;
use App\Models\FieldSet;
use App\Models\Image;
use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Models\AssetTransaction;

use Illuminate\Http\Request;
use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Http\Requests\AssetModalRequest;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;
use Sammy\AssetUpgradeManage\Http\Requests\AssetUpgradeRequest;
use Sammy\AssetUpgradeManage\Models\AssetUpgrade;
use Sammy\CheckInout\Models\IssueNote;

use App\Exceptions\TransactionException;
use PhpSpec\Exception\Exception;

use DB;
use Excel;
use File;
use Log;
use Response;
use Sentinel;

class AssetUpgradeController extends Controller {

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//$this->middleware('guest');
	}

  
    /**
     * add view.
     *
     * @return Response
     */
    public function addView(Request $request,$id){
        $asset_models = AssetModal::all();
        $status = Status::all();
        $tmp=Asset::with(['assetTransaction'])->find($id);
        $loc=$tmp->assetTransaction->location_id;
        $locations = UserLocationFilter::getLocations();

        $asset = Asset::whereIn('id',function($aa) use($locations,$loc)
        {
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            // ->where('location_id',$loc)
            ->whereNull('deleted_at');
        })->find($id);

        if(!$asset){
            return view( 'errors.404');       
        }

        $location  = $request->location==null?0:$request->location;
        
        $tmp1=AssetUpgrade::whereNull('ended_at')->get();

        $t1=$tmp1->pluck('upgrade_asset_id');
        $t2=$tmp1->pluck('asset_id');


        $onUpgrade[]=intval($id);

        $onUpgrade=array_flatten(array_unique(array_merge($onUpgrade,array_flatten($t1),array_flatten($t2))));
        
        $data = Asset::selectRaw("*,TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period")
                ->with(['upgrade','depreciationtype','transaction.status','transaction.location','assetmodel'])
                ->whereNotIn('id',$onUpgrade);     

        
        $data  = $data->whereIn('id',function($aa) use($locations,$loc)
        {
            $aa->select('asset_id')->from('asset_transaction')
            // ->whereIn('location_id',$locations->lists('id'))
            ->where('location_id',$loc)
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

        $data = $data->paginate(20);

        $locations=UserLocationFilter::locationHierarchy();

        return view('views::views.add')->with([
            'assets'       =>$data,
            'asset'        =>$asset,
            'asset_models' =>$asset_models,
            'locations'    =>$locations,
            'status'       =>$status,
            'old'          => [
                'ser_no'=>$ser_no,
                'inv_no'=>$inv_no,
                'location'=>$location,
                'status'=>$stat,
                'model'=>$model
            ]]);

    }


    /**
     * add view.
     *
     * @return Response
     */
    public function historyView(Request $request,$id){
        $asset_models = AssetModal::all();
        $status = Status::all();
        $locations = UserLocationFilter::getLocations();

        $asset = Asset::with(['upgradehistory.asset.transaction.status','upgradehistory.asset.transaction.location','depreciationtype','transaction.status','transaction.location','assetmodel'])->selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->whereIn('id',function($aa) use($locations){
            $aa->select('asset_id')->from('asset_transaction')
            ->whereIn('location_id',$locations->lists('id'))
            ->whereNull('deleted_at');
        })->find($id);

        if(!$asset){
            return view( 'errors.404');       
        }
        
        return view('views::views.history')->with(['asset'=>$asset]);

    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function add(Request $request,$id){

        try {
            DB::transaction(function () use ($request,$id) {
        
                if($request->asset==null && $id==null){
                    throw new TransactionException('please select asset to upgrade', 100);
                }else{

                    $locations = UserLocationFilter::getLocations();

                    $asset = Asset::whereIn('id',function($aa) use($locations){
                        $aa->select('asset_id')->from('asset_transaction')
                            ->whereIn('location_id',$locations->lists('id'))
                            ->whereNull('deleted_at');
                    })->find($id);

                    if(!$asset){
                        throw new TransactionException('unauthorized transation your tyring to access some funtion beyond your permission grade', 101);
                    }else{
                        $assetUpgrade = AssetUpgrade::create([
                            'asset_id'         => $asset->id,
                            'upgrade_asset_id' => $request->asset,
                            'upgrade_at'       => date('Y-m-d H:i:s')
                        ]);

                        $trans=AssetTransaction::where('asset_id',$request->asset)->whereNull('deleted_at')->first();
                
                        if($trans){
                            $trans->delete();

                            $tmp2=AssetTransaction::where('asset_id',$id)->whereNull('deleted_at')->first();
                            
                            $sub_asset = AssetTransaction::create([
                                'asset_id'    => $request->asset,
                                'status_id'   => $tmp2->status_id,
                                'location_id'=>$tmp2->location_id,
                                'location_type'=>$tmp2->location_type,
                                'employee_id'=>$tmp2->employee_id,
                                'user_id'=>Sentinel::getUser()->employee_id,
                                'type'=>'Upgraded In-To Asset'
                            ]);

                            if(!$sub_asset){
                                throw new TransactionException("couldn't dispose asset", 100);
                            }
                        }else{
                            throw new TransactionException("couldn't find asset", 101);
                        }

                    }

                }

            });
            
            return redirect('asset/upgrade/add/'.$id)->with([ 
                'success' => true,
                'success.message' => 'Success! successfully upgrade the asset',
                'success.title'   => 'Success!' 
            ]);

        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                Log::info($e);
                return redirect('asset/upgrade/add/'.$id)->with([ 
                    'error' => true,
                    'error.message' => 'Error! please select asset to upgrade',
                    'error.title'   => 'Error!' 
                ]);
            }else if ($e->getCode() == 101) {
                Log::info($e);
                return redirect('asset/upgrade/add/'.$id)->with([ 
                    'error' => true,
                    'error.message' => 'Error! unauthorized transation your tyring to access some funtion beyond your permission grade',
                    'error.title'   => 'Critical!' 
                ]);
            }
        } catch (Exception $e) {
            Log::info($e);
            return redirect('supplier/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error!',
                'error.title' => 'Well Done!' ]);
        }

    }

    /**
     * Delete
     * @param  Request $request id
     * @return Json
     */
    public function unassignAsset(Request $request) {
        if ($request->ajax()) {
            $asset_id = $request->input('asset_id');
            $id = $request->input('id');
            $locations = UserLocationFilter::getLocations();

            $asset = Asset::whereIn('id',function($aa) use($locations)
            {
                $aa->select('asset_id')->from('asset_transaction')
                ->whereIn('location_id',$locations->lists('id'))
                ->whereNull('deleted_at');
            })->find($asset_id);

            if($asset){
                $upgrade  = AssetUpgrade::find($id);
                $upgrade->ended_at = date('Y-m-d H:i:s');
                $upgrade->save();
            }else{
                return response()->json(['status' => 'error']); 
            }
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
    



}
