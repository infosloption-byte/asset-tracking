<?php
namespace Sammy\AssetModal\Http\Controllers;

use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeviceModal;
use App\Models\FieldSet;
use App\Models\Image;
use App\Exceptions\TransactionException;

use DB;
use Excel;
use File;
use Log;
use Response;
use Sentinel;
use Illuminate\Http\Request;

use Sammy\AssetModal\Http\Requests\AssetModalRequest;
use Sammy\AssetModal\Models\AssetModal;
use Sammy\Permissions\Models\Permission;


class AssetModalController extends Controller {

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
	 * Show the AssetModal add screen to the user.
	 *
	 * @return Response
	 */
	public function addView() {
		$category = Category::where('status',1)->lists('name', 'id')->prepend('Root', '0');
		return view('assetModal::modal.add')->with(['category' => $category]);
	}

	/**
	 * Add new AssetModal data to database
	 *
	 * @return Redirect to AssetModal add
	 */
	public function add(AssetModalRequest $request) {

		try {
			DB::transaction(function () use ($request) {

				$asset_modal = AssetModal::create([
					'category_id' => $request->get('category'),
					'name' => $request->get('asset_modal'),
					'code' => $request->get('code'),
				]);

				$assModal = $asset_modal->replicate();
				$arrF = [];

				if ($asset_modal) {
					for ($i = 0; $i < $request->get('row_count'); $i++) {
						if ($request->get('device-modal-' . $i)) {
							$device_modal = DeviceModal::create([
								'asset_modal_id' => $asset_modal->id,
								'name' => $request->get('device-modal-' . $i),
							]);

							if ($device_modal) {
								if ($request->get('device-field-' . $i)) {
									$fieldset = explode(',', $request->get('device-field-' . $i));

									if (count($fieldset) >= 1) {
										foreach ($fieldset as $val) {
											$field_set = FieldSet::create([
												'device_modal_id' => $device_modal->id,
												'name' => $val,
											]);

											if (!$field_set) {
												throw new TransactionException('Record wasn\'t updated', 100);
											}
										}
									}
								}
                                $arrF[$request->get('device-modal-' . $i)] = $request->get('device-field-' . $i);
							} else {
								throw new TransactionException('Record wasn\'t updated', 101);
							}
						}
					}

                    $assModal->specs = $arrF;
                    $this->auditLogger->addLog('Asset Modal', 'Add Entry', $asset_modal->id, null, $assModal->toJson());
				} else {
					throw new TransactionException('Record wasn\'t updated', 102);
				}
			});

			return redirect('asset-modal/add')->with(['success' => true,
				'success.message' => 'AssetModal added successfully!',
				'success.title' => 'Good Job!'
			]);

		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {
				Log::info("Transaction Error");
				return redirect('asset-modal/add')->with(['error' => true,
					'error.message' => "Transaction Error when add Device Field",
					'error.title' => 'Ops!']);
			} elseif ($e->getCode() == 101) {
				Log::info('Transaction Error');
				return redirect('asset-modal/add')->with(['error' => true,
					'error.message' => 'Transaction Error when add Device Modal',
					'error.title' => 'Ops!']);
			} elseif ($e->getCode() == 102) {
				Log::info('Transaction Error');
				return redirect('asset-modal/add')->with(['error' => true,
					'error.message' => 'Transaction Error when add Asset Modal',
					'error.title' => 'Ops!']);
			}
		} catch (Exception $e) {

		}

	}

	/**
	 * Show the AssetModal List view to the user.
	 *
	 * @return Response
	 */
	public function listView() {

		$data = AssetModal::with(['assetModalByCategory'])->orderBy('category_id', 'asc');
		$data=$data->paginate(20);
		$count=$data->total();
		return view('assetModal::modal.list')->with(['data'=>$data,'row_count'=>$count]);
	}

	/**
	 * Show the family edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id) {

		$category = Category::all()->lists('name', 'id');
		$asset_modal = AssetModal::with(['deviceModalByAssetModal'])->find($id);
		$category_selected = DB::select(DB::raw("select c.id from category as c left join asset_modal as am on c.id=am.category_id where c.id=" . $asset_modal->category_id));
		$deviceModal = [];

		foreach ($asset_modal->deviceModalByAssetModal as $value) {
			$dd = [];
			$dd['id'] = $value->id;
			$dd['asset_modal_id'] = $value->asset_modal_id;
			$dd['name'] = $value->name;
			$fieldset = FieldSet::where('device_modal_id', '=', $value->id)->get();
			$field = "";
			foreach ($fieldset as $value) {
				$field .= $value->name . ',';
			}
			$field = rtrim($field, ',');
			$dd['field'] = $field;
			array_push($deviceModal, $dd);
		}

		if ($asset_modal) {
			return view('assetModal::modal.edit')->with([
				'assetModal' => $asset_modal,
				'deviceModal' => $deviceModal,
				'select_category' => $category_selected[0]->id,
				'category' => $category,
			]);
		} else {
			return view('errors.404');
		}
	}

	/**
	 * Return field list of device modal.
	 *
	 * @return Response
	 */
	public function getDeviceField(AssetModalRequest $request) {

		if ($request->ajax()) {

			$fieldset = FieldSet::where('device_modal_id', '=', $request->get('dev_modal'))->get();
			$field = "";
			foreach ($fieldset as $value) {
				$field .= $value->name . ',';
			}
			$field = rtrim($field, ',');
			return Response::json($field);
		} else {
			return Response::json([]);
		}

	}

	/**
	 * Add new family data to database
	 *
	 * @return Redirect to family add
	 */
	public function edit(Request $request, $id) {

		// return $request->all();

		try {
			DB::transaction(function () use ($request,$id) {

				$assetModal=AssetModal::find($id);
				$old = $assetModal->replicate();

                $arrFOld = [];
                $arrF = [];

				if($assetModal){

					if($request->get('asset_modal')!=""){
						$assetModal->name=$request->get('asset_modal');
						// $assetModal->code=$request->get('code');
						// $assetModal->category_id=$request->get('category');
						$assetModal->save();

						$rc=$request->row_count;

						for ($i=0; $i <$rc ; $i++) { 
							if($request->get('device-modal-'.$i)){
								
								$deviceModalExist=DeviceModal::where('asset_modal_id',$id)->where('name',$request->get('device-modal-'.$i))->first();

								if(!$deviceModalExist){
									
									if($request->get('device-modal-' . $i)!=""){
										$device_modal = DeviceModal::create([
											'asset_modal_id' => $id,
											'name' => $request->get('device-modal-' . $i),
										]);
										if($device_modal){
											$device_modal_id=$device_modal->id;
										}else{
											throw new TransactionException('Record wasn\'t updated', 100);
										}
									}else{
										throw new TransactionException('Record wasn\'t updated', 101);
									}

								}else{
								    $oldF = DB::select(DB::raw('SELECT device_modal_id, GROUP_CONCAT(name) as name FROM fieldset WHERE device_modal_id = '.$deviceModalExist->id.' GROUP BY device_modal_id'));
                                    $arrFOld[$request->get('device-modal-'.$i)] = $oldF[0]->name;


									$device_modal_id=$deviceModalExist->id;
								}


								if($request->get('device-field-' . $i)){
									$fieldset = explode(',', $request->get('device-field-' . $i));
									
									if (count($fieldset) > 0) {
										foreach ($fieldset as $val) {
											$field_set = FieldSet::create([
												'device_modal_id' => $device_modal_id,
												'name' => $val,
											]);

											if (!$field_set) {
												throw new TransactionException('Record wasn\'t updated', 102);
											}
										}
									}else if(!$deviceModalExist && count($fieldset) == 1){
										throw new TransactionException('Record wasn\'t updated', 105);
									}
								}

                                $oldF = DB::select(DB::raw('SELECT device_modal_id, GROUP_CONCAT(name) as name FROM fieldset WHERE device_modal_id = '.$device_modal_id.' GROUP BY device_modal_id'));
                                $arrF[$request->get('device-modal-'.$i)] = $oldF[0]->name;
							}
						}

						$assetModal->specs = $arrF;
						$old->specs = $arrFOld;
                        $this->auditLogger->addLog('Asset Modal', 'Edit Entry', $assetModal->id, $old->toJson(), $assetModal->toJson());
					}else{
						throw new TransactionException('Record wasn\'t updated', 103);
					}

				}else{
					throw new TransactionException('Record wasn\'t updated', 104);
				}
						
			});

			return redirect('asset-modal/edit/'.$id)->with(['success' => true,
				'success.message' => 'Asset Modal modified successfully!',
				'success.title' => 'Good Job!'
			]);

		} catch (TransactionException $e) {
			if ($e->getCode() == 100) {				
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => "Cannot create new device field",
					'error.title' => 'Ops!'
				]);

			} elseif ($e->getCode() == 101) {				
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => 'Cannot find Device Modal. Please try again',
					'error.title' => 'Ops!'
				]);

			} elseif ($e->getCode() == 102) {				
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => 'Cannot create device field values. Please try again',
					'error.title' => 'Ops!'
				]);

			} elseif ($e->getCode() == 103) {				
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => 'Asset Modal name cannot be empty',
					'error.title' => 'Ops!'
				]);

			} elseif ($e->getCode() == 104) {
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => 'Asset Modal not exist to modify',
					'error.title' => 'Ops!'
				]);

			} elseif ($e->getCode() == 105) {
				Log::info($e);
				return redirect('asset-modal/edit/'.$id)->with(['error' => true,
					'error.message' => 'New device field values cannot be empty',
					'error.title' => 'Ops!'
				]);

			}
		} catch (Exception $e) {
			Log::info($e);
			return redirect('asset-modal/edit/'.$id)->with(['error' => true,
				'error.message' => 'New device field values cannot be empty',
				'error.title' => 'Ops!'
			]);
		}

	}

	/**
	 * Delete Image of family screen to the user.
	 *
	 * @return Response
	 */
	public function deleteImage(AssetModalRequest $request) {
		if ($request->ajax() && $request->get('id') > 0) {
			$image = Image::find($request->get('id'));

			if (!empty($image)) {
				Image::where('id', $image->id)->where('type', 3)->delete();

				File::delete(storage_path($image->path . '/' . $image->filename));
			} else {echo 1;}
		} else {
			return Response::json([]);
		}
	}

	/**
	 * Delete family
	 *
	 * @return Response
	 */
	public function deleteAssetModal(AssetModalRequest $request) {
		if ($request->ajax() && $request->get('family') > 0) {
			AssetModal::where('id', '=', $request->get('family'))->delete();
			return Response::json(['deleted']);
		} else {
			return Response::json(['no']);
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
            $modal = AssetModal::find($id);
            $old = $modal->replicate();

            if ($modal) {

                $modal->status=$status;                   
                $modal->save();

                $this->auditLogger->addLog('Asset Modal', 'Status Change', $modal->id, $old->toJson(), $modal->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
	}
}
