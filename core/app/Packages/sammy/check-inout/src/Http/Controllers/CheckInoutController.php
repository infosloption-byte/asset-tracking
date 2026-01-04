<?php
namespace Sammy\CheckInout\Http\Controllers;

use App\Classes\AuditLogger;
use Illuminate\Http\Request;

use App\Classes\UserLocationFilter;
use App\Http\Controllers\Controller;
use App\Models\AssetTransaction;
use App\Classes\PdfTemplate;
use App\Exceptions\TransactionException;

use Sammy\AssetManage\Models\Asset;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\CheckInout\Http\Requests\CheckInoutRequest;
use Sammy\CheckInout\Models\CheckInout;
use Sammy\CheckInout\Models\Grn;
use Sammy\CheckInout\Models\GrnDetails;
use Sammy\CheckInout\Models\IssueNote;
use Sammy\CheckInout\Models\IssueNoteDetails;
use Sammy\Permissions\Models\Permission;
use Sammy\Location\Models\Location;
use Sammy\Location\Models\EmployeeLocation;
use Sammy\ServiceManage\Models\Service;
use Sammy\AssetUpgradeManage\Models\AssetUpgrade;

use DB;
use Response;
use Sentinel;
use Log;
use Carbon\Carbon;


class CheckInoutController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| CheckInout Controller
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
	 * Show the CheckInout add screen to the user.
	 *
	 * @return Response
	 */
	public function checkinView(Request $request) {

        $location_id = $request->location;

        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');

        $locations = UserLocationFilter::getLocations();

        $issnotes = IssueNote::with(['details.asset.assetmodel','tolocation','fromlocation','employee'])
        			->whereIn('id',function ($aa)
        			{
        				$aa->select('issue_note_id')
        				->from('issue_note_details')
        				->where('status',0);
        			})->whereIn('id',function ($aa) use($locations)
        			{
        				$aa->select('id')
        				->from('issue_notes')
        				->wherein('to_location_id',$locations->lists('id'));
        			});

        if($location_id!=null && $location_id>0){
            $issnotes = $issnotes->where('to_location_id',$location_id);
        }

        $no = $request->no;
        if($no!=null && $no!=""){
            $issnotes = $issnotes->where('issue_note_no', 'like', '%' .$no. '%');
        }

        $issnotes = $issnotes->orderBy('created_at','asc')->paginate(10);

        $count=$issnotes->total();

        $locations=UserLocationFilter::locationHierarchy();

		return view('checkinout::checkinout.checkin')
				->with(['asset_modal' => $asset_modal,'locations'=>$locations,'data'=>$issnotes,'no'=>$no,'location_id'=>$location_id,'row_count'=>$count]);
	}

    public function rejectListView(Request $request) {

        $location_id = $request->location;

        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');

        $locations = UserLocationFilter::getLocations();
        
        $issnotes = IssueNote::leftJoin('issue_note_details','issue_notes.id','=','issue_note_details.issue_note_id')
                        ->where('issue_note_details.status',2)
                        ->whereIn('from_location_id',$locations->lists('id'))
                        ->groupBy('issue_notes.id')
                        ->with(['tolocation','fromlocation']);

        if($location_id!=null && $location_id>0){
            $issnotes = $issnotes->where('from_location_id',$location_id);
        }

        $no = $request->no;
        if($no!=null && $no!=""){
            $issnotes = $issnotes->where('issue_note_no', 'like', '%' .$no. '%');
        }

        $issnotes = $issnotes->paginate();

        $locations=UserLocationFilter::locationHierarchy();

        return view('checkinout::checkinout.rejected')->with([
                    'asset_modal' => $asset_modal,
                    'locations'=>$locations,
                    'data'=>$issnotes,
                    'no'=>$no,
                    'location_id'=>$location_id,
                    'old'=>['no'=>$no,'location'=>$location_id]
                ]);
    }

    public function rejectDetailView(Request $request,$id) {


        $issnote= IssueNote::with(['fromlocation','tolocation','employee'])->find($id);

        $details = IssueNoteDetails::where('issue_note_id',$id)
                        ->where('status',2)
                        ->with(['asset.supplier','asset.transaction.status','asset.assetmodel'])
                        ->get();

        return view('checkinout::checkinout.rejectedDetails')->with(['note'=>$issnote, 'details'=>$details]);
    }   

	/**
	 * Show the CheckInout add screen to the user.
	 *
	 * @return Response
	 */
	public function issuenoteListView(Request $request) {

        $location_id = $request->location;

        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');

        $locations = UserLocationFilter::getLocations();
        
        $issnotes= IssueNote::with(['details','tolocation','fromlocation','employee'])
        			->whereIn('from_location_id',$locations->lists('id'));

        if($location_id!=null && $location_id>0){
            $issnotes = $issnotes->where('from_location_id',$location_id);
        }

        $no = $request->no;
        if($no!=null && $no!=""){
            $issnotes = $issnotes->where('issue_note_no', 'like', '%' .$no. '%');
        }

        $issnotes = $issnotes->paginate();

        $locations=UserLocationFilter::locationHierarchy();

		return view('checkinout::checkinout.issuenote_list')->with([
                    'asset_modal' => $asset_modal,
                    'locations'=>$locations,
                    'notes'=>$issnotes,
                    'no'=>$no,
                    'location_id'=>$location_id,
                    'old'=>['no'=>$no,'location'=>$location_id]
                ]);
	}

	public function issuenoteDetails(Request $request,$id) {
        $issnote= IssueNote::with(['details','details.asset.supplier','fromlocation','tolocation','employee','details.asset.transaction.status','details.asset.assetmodel'])->find($id);

		return view('checkinout::checkinout.issuenoteDetails')->with(['note'=>$issnote]);
	}	

	/**
	 * Show the CheckInout add screen to the user.
	 *
	 * @return Response
	 */
	public function grnListView(Request $request) {

        $location_id = $request->location;

        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');
        $locations = UserLocationFilter::getLocations();

        $grn= Grn::with(['details.asset.supplier','fromlocation','tolocation','employee','details.asset.transaction.status'])
       				->whereIn('to_location_id',$locations->lists('id'));


        if($location_id!=null && $location_id>0){
            $grn = $grn->where('to_location_id',$location_id);
        }

        $no = $request->no;
        if($no!=null && $no!=""){
            $grn = $grn->where('grn_no', 'like', '%' .$no. '%');
        }

        $grn =$grn->paginate();

        $locations=UserLocationFilter::locationHierarchy();

        return view('checkinout::checkinout.grn_list')->with(['locations'=>$locations,'grns'=>$grn,'no'=>$no,'location_id'=>$location_id]);
	}

	public function checkinDetailsView(Request $request,$id) {
        $issnote= IssueNote::with(['detailsWithoutUpgrade','detailsWithoutUpgrade.asset.supplier','fromlocation','tolocation','employee','detailsWithoutUpgrade.asset.transaction.status','detailsWithoutUpgrade.asset.assetmodel'])->find($id);

        $usr=Sentinel::getUser();

        $tmp=EmployeeLocation::where('employee_id',$usr->employee_id)->first();

        $checkinPermission=false;

        $userLoc = Location::where('id',$tmp->location_id)->first();
        $assetLoc = Location::where('id',$issnote->to_location_id)->first();


        if($usr->employee[0]->employee_type_id==1){
            $checkinPermission=true;
        }else{
            if($tmp->location_id==$issnote->to_location_id || $assetLoc->isSelfOrDescendantOf($userLoc)){
                $checkinPermission=true;
            }else{
                $checkinPermission=false;
            }
        }

		return view('checkinout::checkinout.checkinDetails')->with(['note'=>$issnote,'checkinPermission'=>$checkinPermission]);
	}

	public function issueNotePrint(Request $request,$id) {

        $issnote= IssueNote::with(['details'=>function($aa){
         $aa->selectRaw('*,(select count(id)>0 from grn_details where asset_id=issue_note_details.asset_id) as isAsset');
        },'details.asset.supplier','fromlocation','tolocation','employee','details.asset.transaction.status','details.asset.assetmodel'])->find($id);

		if($issnote){
			$page1 =  view('checkinout::print.issuenote')->with(['note'=>$issnote])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'),'title' => '']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("issuenote_".$issnote->issue_note_no);
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output("issuenote_".$issnote->issue_note_no.".pdf", 'I');
	}

	public function grnDetailsView(Request $request,$id) {

        $grn= Grn::with(['details.asset.supplier','fromlocation','tolocation','employee','details.asset.transaction.status'])->find($id);
		return view('checkinout::checkinout.grnDetails')->with(['grn'=>$grn]);
	}

	public function grnPrint(Request $request,$id) {

        $grn= Grn::with(['details.asset.supplier','fromlocation','tolocation','employee','details.asset.transaction.status'])->find($id);

        if($grn){
			$page1 =  view('checkinout::print.grn')->with(['note'=>$grn])->render();
        }else{
            return response()->view("errors.404");
        }

        $pdf   = new PdfTemplate(["no"=>date('Y-m-d'), 'title' => '']);
        $pdf->SetMargins(5, 30, 5);
        $pdf->SetTitle("grn".$grn->grn_no);
        $pdf->SetFont('helvetica', 5);
        $pdf->SetAutoPageBreak(TRUE, 30);
        $pdf->AddPage();
        $pdf->writeHtml($page1);
        $pdf->output("grn_".$grn->grn_no.".pdf", 'I');
	}

    public function checkoutView(Request $request) {

        $location_id = $request->location;
     
        $issues = IssueNote::where('to_location_id',$location_id)->with(['details','grn'])->get();

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

        $inserviceAsset = array_flatten(Service::whereNull('completed_date')->get()->pluck('asset_id'));

        $notcheckIn=array_merge($notcheckIn,$inserviceAsset);

        $upgradedAsset=array_flatten(AssetUpgrade::whereNull('ended_at')->get()->pluck('upgrade_asset_id'));
        
        $notcheckIn=array_merge($notcheckIn,$upgradedAsset);

        $assets = Asset::with(['assetmodel','supplier'])
            ->from('asset')
            ->select(\DB::raw('*, (SELECT location.name FROM location where location.id in (select location_id from asset_transaction where asset_id=asset.id and deleted_at is null)) AS location'));


        $asset_modal = AssetModal::all()->lists('name', 'id')->prepend('Choose Modal');
        // $locations = UserLocationFilter::getLocations();

		$no = $request->no;
        if($no!=null && $no!=""){
            $issnotes = $assets->where('asset.asset_no', 'like', '%' .$no. '%');
        }


        if($location_id!=null && $location_id>0){
            $assets = $assets->whereIn('asset.id',function($aa) use($location_id)
            {
                $aa->select('asset_id')->from('asset_transaction')
	                ->whereNull('deleted_at')
                    ->where('location_type','location')
	                ->where('location_id',$location_id);
            })->whereNotIn('asset.id',$notcheckIn);

            $assets = $assets->whereNotNull('inventory_no');

            $assets =$assets->get();
        }

        $locations=UserLocationFilter::locationHierarchyToCheckout();
        $checkin_location=UserLocationFilter::locationHierarchyListWithoutRoot();

        return view('checkinout::checkinout.checkout')
            ->with(['asset_modal' => $asset_modal,'locations'=>$locations,'assets'=>$assets,'no'=>$no,'location_id'=>$location_id,'checkin_location'=>$checkin_location]);
    }

    public function checkout(Request $request) {
        $checkinlocatoin = $request->checkinloc;
        $assets = $request->assets;
        $user = Sentinel::getUser();

        $condition=true;

        if($user->employee_id!=1){
            $tmp=EmployeeLocation::where('employee_id',$user->employee_id)->where('location_id',$request->asset_loc)->first();
            if(!$tmp){
                $condition=false;
            }
        }

        if($condition){
            $aa = Asset::with(['assetmodel','supplier'])->whereIn('asset.id',$assets)->get();

            try {
                DB::transaction(function () use ($assets,$checkinlocatoin,$user) {
                    $old_location = AssetTransaction::whereIn('asset_id', $assets)
                                        ->whereNull('deleted_at')->get();

                    if(!count($old_location)>0){
                        throw new TransactionException('Record wasn\'t updated', 100);
                    }

                    $issue = IssueNote::create([
                        'from_location_id' => $old_location[0]->location_id,
                        'to_location_id'   => $checkinlocatoin,
                        'user_id'          => $user->employee_id,
                    ]);
                    $issueDet = [];

                    if($issue){
                        AssetTransaction::whereIn('asset_id', $assets)->whereNull('deleted_at')->delete();  

                        foreach ($assets as $asset) {
                            $checkout = AssetTransaction::create([
                                'asset_id' => $asset,
                                'location_id' => $checkinlocatoin,
                                'status_id' => 1,
                                'user_id' => $user->employee_id,
                                'type' => 'Check-Out To',
                            ]);

                            if ($checkout){
                                
                                $issue_details = IssueNoteDetails::create([
                                    'asset_id' => $asset,
                                    'issue_note_id' => $issue->id
                                ]);

                                array_push($issueDet, $issue_details);

                                if(!$issue_details){
                                    throw new TransactionException('Issue Note Details wasn\'t created', 101);
                                }

                                $tmp=AssetUpgrade::where('asset_id',$asset)->whereNull('ended_at')->get();

                                if(count($tmp)>0){
                                    foreach ($tmp as $value) {

                                        $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                        
                                        $trns->delete();

                                        $sub_asset_transfer=AssetTransaction::create([
                                            'asset_id'=>$value->upgrade_asset_id,
                                            'status_id'=>1,
                                            'location_type'=>'location',
                                            'location_id'=>$checkinlocatoin,
                                            'user_id'=>$user->employee_id,
                                            'type' => 'Check-Out To',
                                        ]);

                                        if($sub_asset_transfer){
                                            $issue_details1 = IssueNoteDetails::create([
                                                'asset_id'=>$value->upgrade_asset_id,
                                                'issue_note_id' => $issue->id
                                            ]);

                                            array_push($issueDet, $issue_details1);

                                            if(!$issue_details1){
                                                throw new TransactionException('Issue Note Details wasn\'t created', 102);
                                            }
                                        }else{
                                            throw new TransactionException("couldn't transfer to new location", 103);            
                                        }
                                    }
                                }

                            }else{
                                throw new TransactionException("couldn't transfer to new location", 104);
                            }

                        }

                        $tt_loc=Location::find($checkinlocatoin);

                        $emp=Sentinel::getUser()->where('employee_id',$issue->user_id)->first()->username;

                        $dd=Carbon::now()->format('Y-m-d');

                        $ct=IssueNote::where('created_at','like', '%' .$dd. '%')->get()->count();

                        $issue->issue_note_no = 'ISN-'.$ct.'/'.$emp.'/'.$tt_loc->code.'/'.$dd;

                        $issue->save();

                        $issue->detail = $issueDet;
                        $this->auditLogger->addLog('Check-In Check-Out', 'Checkout', $issue->id, null, $issue->toJson());

                    }else{
                        throw new TransactionException('Issue Note wasn\'t created', 105);
                    }
                });
                return Response::json(['status'=>1]);

            } catch (TransactionException $e) {
                if ($e->getCode() == 100) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }else if ($e->getCode() == 101) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }else if ($e->getCode() == 102) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }else if ($e->getCode() == 103) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }else if ($e->getCode() == 104) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }else if ($e->getCode() == 105) {
                    Log::info("Transaction Error");
                    return Response::json(['status'=>0]);
                }
            } catch (Exception $e) {
                return Response::json(['status'=>0]);
            }
        }else{
            return Response::json(['status'=>2]);
        }
    }


	/**
	 * Check-In screen to the user.
	 *
	 * @return Response
	 */
	public function checkin(CheckInoutRequest $request) {

        $from_location      =  $request->from_location;
        $to_location        =  $request->to_location;
        $selectedAssets     =  $request->selectedAssets;
        $issid              =  $request->issid;
        $assets             =  $request->assets;
        $usr               = Sentinel::getUser()->employee_id;

        try {
            DB::transaction(function () use ($from_location,$to_location,$selectedAssets,$issid,$assets,$usr) {
                
                $tmp=AssetTransaction::whereIn('asset_id', $assets)->whereNull('deleted_at')->delete();

                $issueNote = IssueNote::with('details')->find($issid);
                $old = $issueNote->replicate();

                $issueDet = [];
                
                if($issueNote){
                    
                    if($issueNote->user_id!=$usr || $usr==1){
                        $issueNote->status = 0;
                        $issueNote->save();

                        $grn = Grn::create([
                            'from_location_id'  => $from_location,
                            'to_location_id'    => $to_location,
                            'issue_note_id'     => $issueNote->id,
                            'user_id'           => $usr,
                        ]);

                        if($grn){
                            
                            foreach ($assets as $asset) {
                                $checkin = AssetTransaction::create([
                                    'asset_id'      => $asset,
                                    'location_id'   => $to_location,
                                    'status_id'     => ASSET_UNDEPLOY,
                                    'user_id'       => $usr,
                                    'type'       => 'Check-In To',
                                    'checkin_text' => ''
                                ]);

                                if(!$checkin){
                                    throw new TransactionException('Checkin wasn\'t completed', 103);
                                }

                                $grn_details = GrnDetails::create([
                                    'asset_id'  => $asset,
                                    'grn_id'    => $grn->id
                                ]);

                                array_push($issueDet, $grn_details);

                                if(!$grn_details){
                                    throw new TransactionException('GRN Details wasn\'t Created', 104);
                                }

                                $tmp1=AssetUpgrade::where('asset_id',$asset)->whereNull('ended_at')->get();

                                if(count($tmp1)>0){

                                    foreach ($tmp1 as $value) {

                                        $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                        
                                        $trns->delete();

                                        $sub_asset_transfer=AssetTransaction::create([
                                            'asset_id'=>$value->upgrade_asset_id,
                                            'status_id'=>ASSET_UNDEPLOY,
                                            'location_type'=>'location',
                                            'location_id'=>$to_location,
                                            'user_id'=>$usr,
                                            'type' => 'Check-In To',
                                        ]);

                                        if($sub_asset_transfer){
                                            $grn_details = GrnDetails::create([
                                                'asset_id'  => $value->upgrade_asset_id,
                                                'grn_id'    => $grn->id
                                            ]);

                                            array_push($issueDet, $grn_details);

                                            if(!$grn_details){
                                                throw new TransactionException('GRN Details wasn\'t Created', 104);
                                            }
                                        }else{
                                            throw new TransactionException("couldn't transfer to new location", 105);            
                                        }
                                    }
                                }

                            }

                            $updateStatus = IssueNoteDetails::where('issue_note_id',$issid)->whereIn('asset_id',$assets)->get();

                            foreach ($updateStatus as $aa) {
                                $aa->status = 1;
                                $aa->save();
                            }
                            
                            $tt_loc=Location::find($to_location);

                            $emp=Sentinel::getUser()->where('employee_id',$grn->user_id)->first()->username;

                            $dd=Carbon::now()->format('Y-m-d');

                            $ct=Grn::where('created_at','like', '%' .$dd. '%')->get()->count();

                            $grn->grn_no = 'GRN-'.$ct.'/'.$emp.'/'.$tt_loc->code.'/'.$dd;
                            $grn->save();

                            $grn->detail = $issueDet;
                            $this->auditLogger->addLog('Check-In Check-Out', 'Checkin', $grn->id, $old->toJson(), $grn->toJson());

                        }  else{
                            throw new TransactionException('GRN wasn\'t Created', 101);
                        }
                    }else{
                        throw new TransactionException('You cannot check-in,which asset you Check-Out', 106);
                    }
                }else{
                    throw new TransactionException('Issue Note couldn\'t found', 102);
                }
            });

            return Response::json(['status'=>1]);

        } catch (TransactionException $e) {
            if ($e->getCode() == 101) {
                Log::info($e);
                return Response::json(['status'=>2]);
            }else if ($e->getCode() == 102) {
                Log::info($e);
                return Response::json(['status'=>3]);
            }else if ($e->getCode() == 103) {
                Log::info($e);
                return Response::json(['status'=>4]);
            }else if ($e->getCode() == 104) {
                Log::info($e);
                return Response::json(['status'=>5]);
            }else if ($e->getCode() == 105) {
                Log::info($e);
                return Response::json(['status'=>6]);
            }else if ($e->getCode() == 106) {
                Log::info($e);
                return Response::json(['status'=>7]);
            }
        } catch (Exception $e) {
            Log::info($e);
            return Response::json(['status'=>0]);
        }
        
    }

    public function reject(CheckInoutRequest $request) {

        $from_location      =   $request->from_location;
        $to_location        =   $request->to_location;
        $loc                = Location::find($to_location);
        $issid              =   $request->issid;
        $assets             =   $request->assets;
        $usr                =   Sentinel::getUser()->employee_id;

		try {
			DB::transaction(function () use ($from_location,$to_location,$issid,$assets,$usr, $loc) {

                $ast = array_column($assets, 'id');
                
                $tmp=AssetTransaction::whereIn('asset_id', $ast)->whereNull('deleted_at')->delete();

    			$issueNote = IssueNote::with('details')->find($issid);
    			$old = $issueNote->replicate();

                if($issueNote){
                    
                    if($issueNote->user_id!=$usr || $usr==1){
                        $issueNote->status = 0;
                        $issueNote->save();                        
                            
                        foreach ($assets as $asset) {
                            $checkin = AssetTransaction::create([
                                'asset_id'      => $asset['id'],
                                'location_id'   => $from_location,
                                'status_id'     => ASSET_UNDEPLOY,
                                'user_id'       => $usr,
                                'type'          => 'Rejected Back To',
                                'checkin_text' => (($asset['reason'] != "")?$asset['reason'].'<br/>'.'Rejected By '.$loc->name:'Rejected By '.$loc->name)
                            ]);

                            if(!$checkin){
                                throw new TransactionException('Checkin wasn\'t completed', 103);
                            }

                            $tmp1=AssetUpgrade::where('asset_id',$asset['id'])->whereNull('ended_at')->get();

                            if(count($tmp1)>0){

                                foreach ($tmp1 as $value) {

                                    $trns=AssetTransaction::where('asset_id',$value->upgrade_asset_id)->whereNull('deleted_at')->first();
                                    
                                    $trns->delete();

                                    $sub_asset_transfer=AssetTransaction::create([
                                        'asset_id'      =>  $value->upgrade_asset_id,
                                        'location_id'   =>  $from_location,
                                        'status_id'     =>  ASSET_UNDEPLOY,
                                        'location_type' =>  'location',
                                        'user_id'       =>  $usr,
                                        'type'          =>  'Rejected Back To',
                                        'checkin_text' => (($asset['reason'] != "")?$asset['reason'].'<br/>'.'Rejected By '.$loc->name:'Rejected By '.$loc->name)
                                    ]);                                    
                                }
                            }

                        }

                        $updateStatus = IssueNoteDetails::where('issue_note_id',$issid)->whereIn('asset_id',$ast)->get();

                        foreach ($updateStatus as $aa) {

                            foreach ($assets as $value) {
                                if($aa->asset_id==$value['id']){
                                    $aa->status = 2;
                    				$aa->reason = $value['reason'];
                    				$aa->save();                                    
                                }
                            }
                        }

                        $issueNoteD = IssueNote::with('details')->find($issid);
                        $this->auditLogger->addLog('Check-In Check-Out', 'Reject', $issueNote->id, $old->toJson(), $issueNoteD->toJson());
                    }else{
                        throw new TransactionException('You cannot check-in,which asset you Check-Out', 106);
                    }
                }else{
                    throw new TransactionException('Issue Note couldn\'t found', 102);
                }
            });

            return Response::json(['status'=>1]);

        } catch (TransactionException $e) {
            if ($e->getCode() == 102) {
                Log::info($e);
                return Response::json(['status'=>3]);
            }else if ($e->getCode() == 103) {
                Log::info($e);
                return Response::json(['status'=>4]);
            }else if ($e->getCode() == 106) {
                Log::info($e);
                return Response::json(['status'=>7]);
            }
        } catch (Exception $e) {
            Log::info($e);
            return Response::json(['status'=>0]);
        }
        
	}



	/**
	 * Check-it Asset.
	 *
	 * @return Response
	 */
	public function checkit(CheckInoutRequest $request) {

		try {
			DB::transaction(function () use ($request) {
				$asset = AssetTransaction::where('asset_id', $request->get('asset_id'))
					->where('status_id', 3)
					->whereNull('deleted_at')
					->get();

				$location = $asset[0]->location_id;
				AssetTransaction::where('asset_id', $request->get('asset_id'))->whereNull('deleted_at')->delete();

				$checkit = AssetTransaction::create([
					'asset_id' => $request->get('asset_id'),
					'location_id' => $location,
					'status_id' => 1,
				]);
				if (!$checkit) {
					throw new TransactionException('Record wasn\'t updated', 100);
				}
			});

		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {
				Log::info("Transaction Error");
				return Response::json(['Error']);
			}
		} catch (Exception $e) {

		}

		return Response::json(['Added']);
	}


	public function getDevice(CheckInoutRequest $request) {
		if ($request->ajax()) {
			$modal_id = $request->get('asset-modal');
			$location = $request->get('location');
			$asset = DB::select(
				DB::raw(
					"SELECT
						asset_no,
						asset.id,
						asset_transaction.deleted_at
					FROM
						asset_transaction
							LEFT JOIN
						asset on asset_transaction.asset_id=asset.id
					WHERE
						asset_transaction.status_id=2
							and asset.asset_model_id=$modal_id
							and asset_transaction.location_id=$location"
				)
			);
			return Response::json($asset);
		} else {
			return Response::json([]);
		}
	}



	/**
	 * Branch asset details according to dashboard.
	 *
	 * @return return asset details
	 */
	public function assetList(CheckInoutRequest $request) {
		if ($request->ajax()) {
			$dd = [];
			if ($request->get('location') == '0') {
				if ($request->get('type') == '0') {
					$asset = AssetTransaction::whereNull('deleted_at')->get();

					if (count($asset) > 0) {
						foreach ($asset as $value) {
							$dd[] = Asset::with('depreciationType')->find($value->asset_id);
						}
					}

				} else {
					$asset = AssetTransaction::where('status_id', $request->get('type'))->whereNull('deleted_at')->get();

					if (count($asset) > 0) {
						foreach ($asset as $value) {
							$dd[] = Asset::with('depreciationType')->find($value->asset_id);
						}
					}

				}
			} else {
				if ($request->get('type') == '0') {
					$asset = AssetTransaction::where('location_id', $request->get('location'))->whereNull('deleted_at')->get();

					if (count($asset) > 0) {
						foreach ($asset as $value) {
							$dd[] = Asset::with('depreciationType')->find($value->asset_id);
						}
					}

				} else {
					$asset = AssetTransaction::where('location_id', $request->get('location'))->where('status_id', $request->get('type'))->whereNull('deleted_at')->get();

					if (count($asset) > 0) {
						foreach ($asset as $value) {
							$dd[] = Asset::with('depreciationType')->find($value->asset_id);
						}
					}

				}
			}

			$asset_data = array();
			$i = 1;
			foreach ($dd as $value) {
				$bb = array();
				array_push($bb, $i);

				if ($value->asset_no != '') {
					array_push($bb, $value->asset_no);
				} else {
					array_push($bb, "-");
				}

				if ($value->account_code != '') {
					array_push($bb, $value->account_code);
				} else {
					array_push($bb, "-");
				}

				if ($value->po_number != '') {
					array_push($bb, $value->po_number);
				} else {
					array_push($bb, "-");
				}

				if ($value->purchased_value != '') {
					array_push($bb, $value->purchased_value);
				} else {
					array_push($bb, "-");
				}

				if ($value->warranty_from != '' && $value->warranty_to != '') {
					array_push($bb, "From " . $value->warranty_from . " To " . $value->warranty_to);
				} else {
					array_push($bb, "-");
				}

				if ($value->recovery_period != '') {
					array_push($bb, $value->recovery_period . " Months");
				} else {
					array_push($bb, "-");
				}

				if ($value->depreciation_id != '') {
					array_push($bb, $value->depreciationType->name);
				} else {
					array_push($bb, "-");
				}

				$permissions = Permission::whereIn('name', ['asset.view', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($bb, '<a href="#" class="blue" onclick="window.location.href=\'' . url('asset/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Item"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($bb, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-pencil"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['asset.barcode', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($bb, '<a href="#" class="red item-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Genarate Barcode"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($bb, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Genarate Barcode Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($asset_data, $bb);
				$i++;
			}
			return Response::json(array('data' => $asset_data));
		} else {
			return Response::json(array('data' => []));
		}
	}


	/**
	 * Branch asset details according to dashboard.
	 *
	 * @return return asset details
	 */
	public function loadAssets(Request $request) {
		if ($request->ajax()) {
			$assets = $request->assets;
            $assets = Asset::with(['assetmodel','supplier'])->whereIn('asset.id',$assets)->get();
			return Response::json(array('data' => $assets));
		} else {
			return Response::json(array('data' => []));
		}
	}

	public function checkitView() {
		return view('checkinout::checkinout.checkit');
	}

	public function getAssets(Request $request) {
		if ($request->ajax()) {
			$location = $request->get('id');
			$str = "";
			if ($location != '0') {
				$str = "and asset_transaction.location_id=" . $location;
			}
			$assets = DB::select(
				DB::raw(
					"SELECT
						asset.id  as id,
						asset.asset_no  as asset_no,
						asset.po_number as po_number,
						suppliers.name  AS supplier_name,
						asset_transaction.deleted_at
					FROM
						asset_transaction
							LEFT JOIN
						asset on asset_transaction.asset_id=asset.id
							LEFT JOIN
						suppliers on asset.supplier_id=suppliers.id
					WHERE
						asset_transaction.status_id=1 $str"
				)
			);

			$jsonList = array();

			foreach ($assets as $key => $asset) {
				$dd = array();
				array_push($dd, $key + 1);

				if ($asset->asset_no != '') {
					array_push($dd, $asset->asset_no);
				} else {
					array_push($dd, "-");
				}

				if ($asset->po_number != '') {
					array_push($dd, $asset->po_number);
				} else {
					array_push($dd, "-");
				}

				if ($asset->supplier_name != '') {
					array_push($dd, $asset->supplier_name);
				} else {
					array_push($dd, "-");
				}

				array_push($dd, '<button type="button" data-id="' . $asset->id . '" class="btn btn-sm btn-warning btn-checkout">Check Out</button>');
				if ($asset->deleted_at == NULL) {
					array_push($jsonList, $dd);
				}
			}

			return Response::json(["data" => $jsonList]);
		} else {
			return Response::json([]);
		}
	}

	public function getPendingAssets(Request $request) {
		if ($request->ajax()) {
			$location = $request->get('id');
			$str = "";
			if ($location != '0') {
				$str = "and asset_transaction.location_id=" . $location;
			}
			$assets = DB::select(
				DB::raw(
					"SELECT
						asset.id  as id,
						asset.asset_no  as asset_no,
						asset.po_number as po_number,
						suppliers.name  AS supplier_name,
						asset_transaction.deleted_at
					FROM
						asset_transaction
							LEFT JOIN
						asset on asset_transaction.asset_id=asset.id
							LEFT JOIN
						suppliers on asset.supplier_id=suppliers.id
					WHERE
						asset_transaction.status_id=3 $str"
				)
			);

			$jsonList = array();

			foreach ($assets as $key => $asset) {
				$dd = array();
				array_push($dd, $key + 1);

				if ($asset->asset_no != '') {
					array_push($dd, $asset->asset_no);
				} else {
					array_push($dd, "-");
				}

				if ($asset->po_number != '') {
					array_push($dd, $asset->po_number);
				} else {
					array_push($dd, "-");
				}

				if ($asset->supplier_name != '') {
					array_push($dd, $asset->supplier_name);
				} else {
					array_push($dd, "-");
				}

				array_push($dd, '<button type="button" data-id="' . $asset->id . '" onclick="check_it(' . $asset->id . ')" class="btn btn-sm btn-warning btn-checkout">Check it</button>');
				if ($asset->deleted_at == NULL) {
					array_push($jsonList, $dd);
				}
			}

			return Response::json(["data" => $jsonList]);
		} else {
			return Response::json([]);
		}
	}

}
