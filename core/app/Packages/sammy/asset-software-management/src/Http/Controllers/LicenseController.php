<?php
namespace Sammy\AssetSoftwareManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Classes\PdfTemplate;
use App\Classes\UserLocationFilter;

use App\Http\Controllers\Controller;
use App\Exceptions\TransactionException;

use App\Models\AssetBarcode;
use App\Models\AssetTransaction;
use App\Models\BarcodeCategory;

use PhpSpec\Exception\Exception;

use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\AssetSoftwareManage\Models\License;
use Sammy\AssetSoftwareManage\Models\LicenseDetails;
use Sammy\AssetSoftwareManage\Models\SoftwareType;
use Sammy\ConfigManage\Models\AppConfig;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;
use Sammy\ServiceManage\Models\Service;
use Sammy\ServiceTypeManage\Models\ServiceType;
use Sammy\ManufacturerManage\Models\Manufacturer;
use Sammy\SupplierManage\Models\Supplier;
use Sammy\AssetSoftwareManage\Http\Requests\SoftwareAssetRequest;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\CheckInout\Models\IssueNoteDetails;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Sentinel;
use Response;
use DB;

class LicenseController extends Controller {


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
		//$this->middleware('guest');

        $this->auditLogger = $auditLogger;
	}

    /**
     * Show the list.
     *
     * @return Response
     */
    public function addView(Request $request){
        $suppliers       =   Supplier::lists('name','id')->prepend('-select supplier-',0);
        $manufacturers   =   Manufacturer::lists('name','id')->prepend('-select manufacturer-',0);

        $categories = SoftwareType::lists('name','id')->prepend('-select category-',0);

        return view('licViews::views.add')->with([
            'category' => [],
            'suppliers'=>$suppliers,
            'manufacturers'=>$manufacturers,
            'categories'=>$categories
        ]);
    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function add(SoftwareAssetRequest $request){            

        try{
            DB::transaction(function () use ($request) {
                $user           = Sentinel::getUser();
                $users          = $request->get('unlimited')==null?$request->get('users'):-1;
                $tmp2           = Carbon::createFromFormat('Y-m-d', $request->get('from'));
                $warranty_start = $tmp2->toDateTimeString();
                $warranty_end   = $request->get('unlimited_time')==null?$tmp2->addMonths($request->get('period'))->toDateTimeString():null;

                $category = SoftwareType::find($request->get('category'));

                $license = License::create([
                    'name'           => $request->get('name'),
                    'version'        => $request->get('version'),
                    'license_to'     => $warranty_end,
                    'license_from'   => $warranty_start,
                    'manufacture_id' => $request->get('manufacturer'),
                    'supplier_id'    => $request->get('supplier'),
                    'category'       => $category->name,
                    'category_id'    => $category->id,
                    'description'    => $request->get('notes'),
                    'max_users'      => $users,
                ]);

                $license->asset_no ='SOFT_'.str_pad($license->id, 8, '0', STR_PAD_LEFT);
                $license->save();

                $this->auditLogger->addLog('Software Asset', 'Add Entry', $license->id, null, $license->toJson());

                if(!$license){
                    throw new TransactionException('No name', 102);
                }
            });
            return redirect('software/license/add')->with([
                'success' => true,
                'success.message' => 'Software License added successfully!',
                'success.title' => 'Successful!',
            ]);
        } catch (Exception $e) {
            return redirect('software/license/add')->with([
                'error' => true,
                'error.message' => 'Error Occured!',
                'error.title' => 'Error!',
            ]);
        }
    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function listView(Request $request){
        $user          = Sentinel::getUser();    
        $locations     = UserLocationFilter::getLocations();
        $suppliers     = Supplier::all();
        $manufacturers = Manufacturer::all(); 
        $categories    = SoftwareType::all(); 
        $employee      = Employee::find($user->employee_id);

        
        $data = License::with(['details','supplier','manufacture','category']);

        $manufacturer = $request->manufacturer;
        if($manufacturer!=null && $manufacturer>0){
            $data  = $data->where('manufacture_id',$manufacturer);
        }

        $supplier = $request->supplier;
        if($supplier!=null && $supplier>0){
            $data  = $data->where('supplier_id',$supplier);
        }

        $category = $request->category;
        if($category!=null && $category>0){
            $data  = $data->where('category_id',$category);
        }

        $keyword = $request->keyword;
        if($keyword!=null && $keyword!=""){
            $data = $data->orWhere('name', 'like', '%' .$keyword. '%')
                        ->orWhere('asset_no', 'like', '%' .$keyword. '%')
                        ->orWhere('category', 'like', '%' .$keyword. '%');
        }

        $sversion = $request->sversion;
        if($keyword!=null && $keyword!=""){
            $data = $data->where('version', 'like', '%' .$sversion. '%');
        }

        $data = $data->paginate(20);


        return view('licViews::views.list')->with([
            'data'          =>$data,
            'locations'     =>$locations,
            'suppliers'     =>$suppliers,
            'manufacturers' =>$manufacturers,
            'categories'   =>$categories,
            'old'           =>[
                'category'=>$category,
                'supplier'=>$supplier,
                'keyword'=>$keyword,
                'manufacturer'=>$manufacturer,
                'sversion'=>$sversion
            ]
        ]);        

    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function assignView(Request $request,$id){
        
        $aa = License::with('details.asset')->find($id);

        $modal=AssetModal::where('status',1)->lists('name','id')->prepend('Please Select..',0);

        $locations=UserLocationFilter::locationHierarchyOption();

        return view('licViews::views.assign1')->with(['data'=>$aa,'modal'=>$modal,'location'=>$locations]);

    }

    /**
     * Get asset of the location add screen to the user.
     *
     * @return Response
     */
    public function getAsset(Request $request,$id) {
        
        $locations = UserLocationFilter::getLocationOfUser();

        $data = Asset::selectRaw("*,
            TIMESTAMPDIFF(MONTH,warranty_from,warranty_to) warranty_period
            ")->with(['depreciationtype','transaction.status','transaction.location','assetmodel','manufacturer'])->where('asset_model_id',$request->modal);

        $data  = $data->whereIn('id',function($aa) use($request)
            {
                // $aa->select('asset_id')->from('asset_transaction')->whereIn('location_id',$locations)->whereNull('deleted_at');
                $aa->select('asset_id')->from('asset_transaction')->where('location_id',$request->loc)->whereNull('deleted_at');
            }
        );

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

        // $license_exist=array_flatten(LicenseDetails::whereNull('deleted_at')->get()->pluck('asset_id'));

        // $data=$data->whereNotIn('id',$license_exist);
        
        return $data->select('*',DB::raw('CONCAT("SN : ",asset_no," - INO : ",inventory_no) as name'))->get();
    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function detailsView(Request $request,$id){
        $aa = License::with('details.asset.transaction.location')->find($id);
        return view('licViews::views.details')->with(['data'=>$aa]);

    }

    /**
     * Show the list.
     *
     * @return Response
     */
    public function assign(Request $request,$id){

        try{
            DB::transaction(function () use ($request,$id) {
                $user = Sentinel::getUser();
                $array  = $request->asset_id;

                $lic = License::find($id);
                $data = [];

                for($i=0;$i<count($array);$i++){
                    $license = LicenseDetails::create([
                        'software_license_id' => $id,
                        'asset_id' => $request->asset_id[$i],
                        'reference_no' => $request->reference_no[$i],
                        'note' => $request->note[$i],
                        'user_id' => $user->id,
                    ]);

                    array_push($data, $license);
                }

                $lic->assigned = $data;
                $this->auditLogger->addLog('Software Asset', 'Assign', $lic->id, null, $lic->toJson());
            });

            return redirect('software/license/list')->with([
                'success' => true,
                'success.message' => 'Software License assigned completed !',
                'success.title' => 'Weldone !',
            ]);

        } catch (TransactionException $e) {
            
            return redirect('software/license/list')->with([
                'error' => true,
                'error.message' => 'Software License assigned error!',
                'error.title' => 'Error!',
            ]);

        } catch (Exception $e) {
            
            return redirect('software/license/list')->with([
                'error' => true,
                'error.message' => 'Software License assigned error!',
                'error.title' => 'Error!',
            ]);

        }        

    }

    /**
     * Remove license.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unAssign(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;

            $details = LicenseDetails::with(['software'])->find($id);
            if($details){
                $this->auditLogger->addLog('Software Asset', 'Unassign', $details->software_license_id, null, $details->toJson());
                $details->delete();

                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
    }

}
