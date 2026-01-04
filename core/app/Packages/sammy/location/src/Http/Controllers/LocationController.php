<?php
namespace Sammy\Location\Http\Controllers;

use App\Classes\AuditLogger;
use App\Exceptions\TransactionException;
use App\Http\Controllers\Controller;
use App\Models\LocationType;
use App\Classes\UserLocationFilter;

use Sammy\Location\Http\Requests\LocationRequest;
use Sammy\Location\Models\Location;
use Sammy\Permissions\Models\Permission;

use Sentinel;
use DB;
use Log;
use Response;

use Illuminate\Http\Request;

class LocationController extends Controller {

	/*
		|--------------------------------------------------------------------------
		| Location Controller
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
		// $location = Location::all()->lists('name', 'id')->prepend('Root', '0');
		$locationType = LocationType::whereNotIn('status',[0])->lists('name', 'id');

		$location = UserLocationFilter::locationHierarchyList();

		return view('location::location.add')->with(['location' => $location, 'locationType' => $locationType]);
	}

	/**
	 * Add new Location data to database
	 *
	 * @return Redirect to Location add
	 */
	public function add(LocationRequest $request) {

		// return $request->all();

		try {
			DB::transaction(function () use ($request) {

				$parent = Location::find($request->get('parent'));

				$location = Location::create([
					'name' => $request->get('location'),
					'type' => $request->get('locationType'),
					'code' => $request->get('code'),
					'address' => $request->get('address'),
					'email' => $request->get('email'),
					'contact' => $request->get('contact'),
				]);


				if($location){
					if ($parent != null) {
						$location->makeChildOf($parent);
					} else {
						$location->makeRoot();
					}

					$locationTop = $location->siblings()->where('code','<',$location->code)->orderBy('code','desc')->first();

					if($locationTop){
						$location->moveToRightOf($locationTop);
					}else{
						if($location->siblings()->count() > 0){
							$location->makeFirstChildOf($parent);
						}
					}

					Location::rebuild();

                    $this->auditLogger->addLog('Location', 'Add Entry', $location->id, null, $location->toJson());
				}else{
					throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
				}

			});
			return redirect('location/add')->with(['success' => true,
				'success.message' => 'Location Added successfully!',
				'success.title' => 'Good Job!']);
		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {
				Log::info($e);
				return redirect('location/add')->with(['error' => true,
					'error.message' => "Could not added image",
					'error.title' => 'Ops!']);
			}
		} catch (Exception $e) {
			Log::info($e);
			return redirect('location/add')->with(['error' => true,
				'error.message' => 'Transaction Error',
				'error.title' => 'Ops!']);
		}

	}

	/**
	 * Get the last location List.
	 *
	 * @return Response
	 */
	public function getGroundLocation(LocationRequest $request) {

		if ($request->ajax()) {
			$dataArray = [];
			$location = Location::where('type', '=', $request->get('locationType'))->get();
			foreach ($location as $value) {
				$data = Location::where('id', '=', $value->id)->get()->first()->getLeaves();
				if (count($data) > 0) {
					foreach ($data as $node) {
						$dataArray[$node->id] = $node->name;
					}
				}
			}
			return Response::json($dataArray);
		} else {
			return Response::json([]);
		}
	}

	/**
	 * Get the location List.
	 *
	 * @return Response
	 */
	public function getLocation(LocationRequest $request) {

		if($request->get('selected')!=null){
			$selected=$request->get('selected');
		}else{
			$selected=0;
		}

		$mainData = Location::where('parent', '=', null)
            ->with(['parentLocation'])->first();

        $mainData1 = $mainData->getSiblingsAndSelf()->toHierarchy();

        $ss = '';

        foreach ($mainData1 as $mainCategory) {

            $name = '';
            for ($j = 1; $j < $mainCategory->depth; $j++) {
                $name .= '--';
            }

            $name .= '' . $mainCategory->name;

            if($mainCategory->id==$selected){
            	$select="selected";
            }else{
            	$select="";
            }

            $ss .= '<option value="' . $mainCategory->id . '" "' . $select . '">' . $name . '</option>';

            $sub = Location::where('parent',$mainCategory->id)->get();

            foreach ($sub as $nested) {
                
                $name = '--';
                for ($j = 1; $j < $nested->depth; $j++) {
                    $name .= '--';
                }

                $name .= '' . $nested->name;

                $ss .= '<option value="' . $nested->id . '" "' . $select . '">' . $name . '</option>';

                $child = Location::where('parent',$nested->id)->get();

                foreach ($child as $baby) {

                    $name = '--';
                    for ($j = 1; $j < $baby->depth; $j++) {
                        $name .= '--';
                    }

                    $name .= '' . $baby->name;

                    $ss .= '<option value="' . $baby->id . '" "' . $select . '">' . $name . '</option>';

                    $leaves = $baby->getDescendants();

                    foreach ($leaves as $children) {

                        $name = '--';
                        for ($j = 1; $j < $children->depth; $j++) {
                            $name .= '--';
                        }

                        $name .= '' . $children->name;

                        $ss .= '<option value="' . $children->id . '" "' . $select . '">' . $name . '</option>';
                    }
                }
            }
        }

        return Response::json(array('data' => $ss));
	}

	/**
	 * Show the Location List view to the user.
	 *
	 * @return Response
	 */
	public function listView() {
		$locations = $this->jsonLocList();
		return view('location::location.list')->with(['locations'=>$locations]);
	}

	/**
	 * Get the Mian Location.
	 *
	 * @return Response
	 */
	public function locationMain(LocationRequest $request) {

		if ($request->ajax()) {
			$locationMain = where('parent', '=', NULL)
				->lists('name', 'id');
			return Response::json($locationMain);
		} else {
			return Response::json([]);
		}
	}

	/**
	 * Get the Location Hierachy.
	 *
	 * @return Response
	 */
	public function locationHierachy(LocationRequest $request) {
		if ($request->ajax()) {
			$location = Location::where('id', '=', $request->get('location'))->first()->getDescendants(array('id', 'parent', 'name as text'))->toHierarchy();
			return Response::json(array_flatten($location));
		} else {
			return Response::json([]);
		}
	}

	/**
	 * Show the location edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id) {
		$location = Location::with(['leftNode'])->where('id',$id)->first();
		$locationType = LocationType::all()->lists('name', 'id');
		$curLocation = Location::find($id);
		$locations = UserLocationFilter::locationHierarchyList();
		if ($curLocation) {
			return view('location::location.edit')->with(['location' => $location,'locations' => $locations, 'curLocation' => $curLocation, 'locationType' => $locationType]);
		} else {
			return view('errors.404')->with(['location' => $location]);
		}
	}

	/**
	 * Add new location data to database
	 *
	 * @return Redirect to location add
	 */
	public function edit(LocationRequest $request, $id) {

		try {
			DB::transaction(function () use ($request, $id) {

				$location = Location::find($id);
				$old = $location->replicate();
				
				if($location){
					$parent = Location::find($request->get('parent'));

					$location->name = $request->get('location');
					$location->type = $request->get('locationType');
					$location->code = $request->get('code');
					$location->address = $request->get('address');
					$location->email = $request->get('email');
					$location->contact = $request->get('contact');
					$location->save();
					
					if ($parent) {
						$location->makeChildOf($parent);
					} else {
						$location->makeRoot();
					}

					$locationTop = $location->siblings()->where('code','<',$location->code)->orderBy('code','desc')->first();

					if($locationTop){
						$location->moveToRightOf($locationTop);
					}else{
						if($location->siblings()->count() > 0){
							$location->makeFirstChildOf($parent);
						}
					}

					Location::rebuild(true);

                    $this->auditLogger->addLog('Location', 'Edit Entry', $location->id, $old->toJson(), $location->toJson());
				}else{
					throw new TransactionException('Something wrong.Location wasn\'t found', 100);
				}
			});
			return redirect('location/list')->with(['success' => true,
				'success.message' => 'Location updated successfully!',
				'success.title' => 'Good Job!']);
		} catch (TransactionException $e) {
			Log::info($e);
			return redirect('location/list')->with(['error' => true,
				'error.message' => 'Transaction Error',
				'error.title' => 'Ops!']);

		} catch (Exception $e) {
			Log::info($e);
			return redirect('location/list')->with(['error' => true,
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
            $location = location::find($id);
            $old = $location->replicate();

            if ($location) {

                $location->status=$status;                   
                $location->save();

                $this->auditLogger->addLog('Location', 'Status Change', $location->id, $old->toJson(), $location->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
	}

	public function jsonLocList(){
		$data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
		$jsonList = array();
		$i=1;
		foreach ($data as $key => $location) {
			$dd = array();
			$dd['num'] = $i;
			$label = '';
			for($j=0; $j < $location->depth; $j++) {
				$label .= '--';
			}

			$label .= ' '.$location->name;
			$dd['id'] = $location->id;
			$dd['name'] = $label;
			$dd['code'] = $location->code;
			$dd['loc_type'] = $location->locationType->name;

			if($location->parent != 0){
				$dd['loc_parent'] = $location->parentLocation->name;
			}else{
				$dd['loc_parent'] = "Root Menu";
			}		

			$dd['email'] = $location->email;
			$dd['contact'] = $location->contact;
			$dd['address'] = $location->address;
			$dd['status'] = $location->status;

			array_push($jsonList, $dd);
			$i++;
		}
		return $jsonList;
		// return Response::json(array('data' => $jsonList));
	}

	public function getHierarchy(){
		$data = Location::with(['parentLocation'])->first()->getDescendantsAndSelf();
		$jsonList = array();
		$i=1;
		$jsonList[0]="Root";
		foreach ($data as $key => $location) {
			$label = '--';
			for($j=0; $j < $location->depth; $j++) {
				$label .= '--';
			}

			$label .= ' '.$location->name;
			$jsonList[$location->id]=$label;
		}

		return $jsonList;
	}

}
