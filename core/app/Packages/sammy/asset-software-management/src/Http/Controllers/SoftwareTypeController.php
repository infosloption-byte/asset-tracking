<?php
namespace Sammy\AssetSoftwareManage\Http\Controllers;


use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Exceptions\TransactionException;

use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;

use Sammy\AssetSoftwareManage\Http\Requests\SoftwareTypeRequest;
use Sammy\AssetSoftwareManage\Models\SoftwareType;
use Sammy\Permissions\Models\Permission;

use Response;
use Sentinel;
use DB;

class SoftwareTypeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	|  Software Type Controller
	|--------------------------------------------------------------------------
	|
	*/

    private $auditLogger;

    /**
     * Create a new controller instance.
     *
     * @return App\Classes\AuditLogger
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
	public function addView()
	{
        return view( 'licViews::type.add' );
	}

    /**
     * Add new entity to database
     *
     * @param SoftwareTypeRequest $request
     * @return Redirect to menu add
     */
	public function add(Request $request)
	{
        try {
            DB::transaction(function () use ($request) {

        		$softwareType = SoftwareType::create([
                    'name' => $request->get('type_name'),
                    'created_by' => Sentinel::getUser()->employee_id
                ]);

                $this->auditLogger->addLog('Software Type', 'Add Entry', $softwareType->id, null, $softwareType->toJson());

                if(!$softwareType){
                    throw new TransactionException('Something wrong.Software Type wasn\'t created', 100);
                }

            });

            return redirect( 'software/type/add' )->with([ 'success' => true,
                'success.message'=> 'Software type added successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('software/type/add')->with([ 'error' => true,
                'error.message'=> 'Software type not created!',
                'error.title' => 'Well Done!' ]);
        } catch (Exception $e) {
            return redirect('software/type/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error!',
                'error.title' => 'Well Done!' ]);
        }
	}

	/**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function listView(Request $request)
	{        
        $data = SoftwareType::whereNull('deleted_at')->with(['createdBy']);

        if($request->name != ''){
            $data->where('name','like','%'.$request->name.'%');
        }

        $data = $data->paginate(10);
        $count=$data->total();
		return view( 'licViews::type.list' )->with(['data' => $data,'row_count'=>$count, 'old' => $request]);
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
            $softwareType = SoftwareType::find($id);
            $old = $softwareType->replicate();

            if ($softwareType) {

                $softwareType->status=$status;                   
                $softwareType->save();

                $this->auditLogger->addLog('Software Type', 'Status Change', $softwareType->id, $old->toJson(), $softwareType->toJson());

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
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
            $type = SoftwareType::find($id);
            if($type){
                $type->delete();
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

        return view( 'licViews::type.trash' );
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
                $type = SoftwareType::withTrashed()->find($id)->restore();
                return response()->json(['status' => 'success']);
            }catch (Exception $ex){
                return response()->json(['status' => 'error']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
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
            $data = SoftwareType::onlyTrashed()->get();

            $jsonList = array();
            $i = 1;
            foreach ($data as $key => $softtype) {
                $dd = array();
                array_push($dd, $i);

                if ($softtype->name != '') {
                    array_push($dd, $softtype->name);
                } else {
                    array_push($dd, "-");
                }

                array_push($dd, '<a href="#" class="red item-trash" data-id="' . $softtype->id . '" data-toggle="tooltip" data-placement="top" title="Restore Software Type"><i class="fa fa-reply"></i></a>');


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
        $softwareType = SoftwareType::find($id);
        return view( 'licViews::type.edit')->with(['softwareType'=>$softwareType]);
	}

	/**
	 * save edit
	 *
	 * @return Redirect to menu add
	 */
	public function edit(Request $request, $id)
	{  
        try {
            DB::transaction(function () use ($request,$id) {
                $softwareType=SoftwareType::find($id);
                $old = $softwareType->replicate();

                if($softwareType){
                    $softwareType->name = $request->get('type_name');

                    $softwareType->save();

                    $this->auditLogger->addLog('Software', 'Edit Entry', $softwareType->id, $old->toJson(), $softwareType->toJson());
                }else{
                    throw new TransactionException('Something wrong.Software Type wasn\'t found', 100);
                }
            });
            return redirect('software/type/list')->with(['success' => true,
                'success.message' => 'Software Type Updated successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('software/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Software Type not updated!',
                'error.title' => 'Error!']);
        } catch (Exception $e) {
            return redirect('software/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Software Type not updated!',
                'error.title' => 'Error!']);
        }
	}
}
