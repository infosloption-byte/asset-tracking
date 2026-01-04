<?php
namespace Sammy\Location\Http\Controllers;

use App\Classes\AuditLogger;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Models\LocationType;

use Sammy\Location\Http\Requests\LocationTypeRequest;
use Sammy\Permissions\Models\Permission;

use Sentinel;
use DB;
use Log;
use Response;
use Illuminate\Http\Request;

class LocationTypeController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| Location Type Controller
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
		return view('location::type.add');
	}

	/**
	 * Add new Location Type data to database
	 *
	 * @return Redirect to Location Type add
	 */
	public function add(LocationTypeRequest $request) {

		try {
			DB::transaction(function () use ($request) {

				$location = LocationType::create([
					'name' => $request->get('name'),
				]);

				if(!$location){
					throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
				}

                $this->auditLogger->addLog('Location Type', 'Add Entry', $location->id, null, $location->toJson());

			});
			return redirect('location/type/add')->with(['success' => true,
				'success.message' => 'Location Type Added successfully!',
				'success.title' => 'Good Job!']);
		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {
				Log::info($e);
				return redirect()->back()->with([ 
						'error' => true,
             	   		'error.message' => 'Location type not created!',
                		'error.title'   => 'Opps..!' 
                ]);
			}
		} catch (Exception $e) {
			Log::info($e);
			return redirect()->back()->with([ 
					'error' => true,
         	   		'error.message' => 'Location type not created!',
            		'error.title'   => 'Opps..!' 
            ]);
		}

	}

	/**
	 * Show the Location List view to the user.
	 *
	 * @return Response
	 */
	public function listView() {
		$types = LocationType::whereNull('deleted_at');
		$data=$types->paginate(20);
		$count=$data->total();
		return view('location::type.list')->with(['data'=>$data,'row_count'=>$count]);
	}

	/**
	 * Show the location edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id) {

		$type = LocationType::find($id);
		$typeList = LocationType::all()->lists('name','id');
		if ($type) {
			return view('location::type.edit')->with(['type' => $type,'parentList' => $typeList]);
		} else {
			return view('errors.404');
		}
	}

	/**
	 * Add new location data to database
	 *
	 * @return Redirect to location add
	 */
	public function edit(LocationTypeRequest $request, $id) {

		try {
			DB::transaction(function () use ($request, $id) {

				$locationType = LocationType::find($id);
				$old = $locationType->replicate();

				if($locationType){	
					$locationType->name = $request->get('name');
					$locationType->save();

                    $this->auditLogger->addLog('Location Type', 'Edit Entry', $locationType->id, $old->toJson(), $locationType->toJson());
				}else{
					throw new TransactionException('Something wrong.Location Type wasn\'t found', 100);
				}
			});

			return redirect('location/type/list')->with(['success' => true,
				'success.message' => 'Location Type updated successfully!',
				'success.title' => 'Good Job!']);
		} catch (TransactionException $e) {
			Log::info($e);
			return redirect('location/type/edit/'.$id)->with(['error' => true,
				'error.message' => 'Transaction Error',
				'error.title' => 'Ops!']);

		} catch (Exception $e) {
			Log::info($e);
			return redirect('location/type/edit/'.$id)->with(['error' => true,
				'error.message' => 'Transaction Error',
				'error.title' => 'Ops!']);
		}
	}

	/**
	 * Activate or Deactivate
	 * @param  Request $request id
	 * @return json
	 */
	public function status(Request $request)
	{
        if ($request->ajax()) {
            $id = $request->input('id');
            $status = $request->input('status');
            $locationType = locationType::find($id);
            $old = $locationType->replicate();

            if ($locationType) {

                $locationType->status=$status;                   
                $locationType->save();

                $this->auditLogger->addLog('Location Type', 'Status Change', $locationType->id, $old->toJson(), $locationType->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
	}

}
