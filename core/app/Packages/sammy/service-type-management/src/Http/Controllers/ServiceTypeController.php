<?php
namespace Sammy\ServiceTypeManage\Http\Controllers;


use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;
use App\Exceptions\TransactionException;

use Sammy\Permissions\Models\Permission;
use Sammy\ServiceTypeManage\Http\Requests\ServiceTypeRequest;
use Sammy\ServiceTypeManage\Models\ServiceType;

use Response;
use Sentinel;
use DB;

class ServiceTypeController extends Controller {

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
	public function addView()
	{
        return view( 'serviceTypeManage::services_type.add' );
	}

    /**
     * Add new entity to database
     *
     * @param ManufacturerRequest $request
     * @return Redirect to menu add
     */
	public function add(ServiceTypeRequest $request)
	{
        $user = Sentinel::getUser();

		$service_type = ServiceType::create([
            'name'    => $request->get('name'),
            'user_id' => $user->id
        ]);

        $this->auditLogger->addLog('Service Type', 'New Entry', $service_type->id, null, $service_type->toJson());

		return redirect( 'service/type/add' )->with([ 'success' => true,
            'success.message' => 'Service Type added successfully!',
            'success.title'   => 'Well Done!' 
        ]);
    }

	/**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function listView()
	{
        $types=ServiceType::whereNull('deleted_at');
        $data=$types->paginate(20);
        $count=$data->total();
		return view( 'serviceTypeManage::services_type.list' )->with(['data'=>$data,'row_count'=>$count]);
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
            $type = ServiceType::find($id);
            $old = $type->replicate();

            if ($type) {

                $type->status=$status;                   
                $type->save();

                $this->auditLogger->addLog('Service Type', 'Status Change', $type->id, $old->toJson(), $type->toJson());

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
            $service_type = ServiceType::find($id);
            if($service_type){
                $service_type->delete();
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'invalid_id']);
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
        $type=ServiceType::find($id);
        return view( 'serviceTypeManage::services_type.edit' )->with(['type'=>$type]);
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
                $type=ServiceType::find($id);
                $old = $type->replicate();

                if($type){
                    $type->name=$request->get('name');

                    $type->save();

                    $this->auditLogger->addLog('Service Type', 'Edit Entry', $type->id, $old->toJson(), $type->toJson());
                }else{
                    throw new TransactionException('Something wrong.Service wasn\'t found', 100);
                }
            });
            return redirect('service/type/list')->with(['success' => true,
                'success.message' => 'Service Type Updated successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('service/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Somthing went wrong!',
                'error.title' => 'Error!']);
        } catch (Exception $e) {
            return redirect('service/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error!',
                'error.title' => 'Error!']);
        }
	}
}
