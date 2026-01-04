<?php
namespace Sammy\ManufacturerManage\Http\Controllers;


use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;

use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;

use Sammy\ManufacturerManage\Models\Manufacturer;
use Sammy\ManufacturerManage\Http\Requests\ManufacturerRequest;
use Sammy\Permissions\Models\Permission;

use Response;
use Sentinel;
use DB;

use App\Exceptions\TransactionException;

class ManufacturersController extends Controller {

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
        return view( 'manufacturerManage::manufacturer.add' );
	}

    /**
     * Add new entity to database
     *
     * @param ManufacturerRequest $request
     * @return Redirect to menu add
     */
	public function add(ManufacturerRequest $request)
	{

        try {
            DB::transaction(function () use ($request) {
                
                $user = Sentinel::getUser();
    		
                $manufacturer = Manufacturer::create([
        			'name'	=> $request->get('name'),
                    'user_id' => $user->id
                ]);

                if(!$manufacturer){
                    throw new TransactionException('Something wrong.Manufacturer wasn\'t created', 100);
                }

                $this->auditLogger->addLog('Manufacturer', 'Add Entry', $manufacturer->id, null, $manufacturer->toJson());

            });

            return redirect( 'manufacturer/list' )->with([ 'success' => true,
                'success.message'=> 'Manufacturer added successfully!',
                'success.title' => 'Well Done!' ]);

        } catch (TransactionException $e) {
            return redirect('manufacturer/add')->with([ 'error' => true,
                'error.message'=> 'Manufacturer not created!',
                'error.title' => 'Well Done!' ]);
        } catch (Exception $e) {
            return redirect('manufacturer/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error!',
                'error.title' => 'Well Done!' ]);
        }
	}

	/**
	 * Show the list.
	 *
	 * @return Response
	 */
	public function listView()
	{
        $data = Manufacturer::whereNull('deleted_at');        
        $data=$data->paginate(20);
        $count=$data->total();
		return view( 'manufacturerManage::manufacturer.list' )->with(['data'=>$data,'row_count'=>$count]);
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
            $manufacturer = Manufacturer::find($id);
            $old = $manufacturer->replicate();

            if ($manufacturer) {

                $manufacturer->status=$status;                   
                $manufacturer->save();

                $this->auditLogger->addLog('Manufacturer', 'Status Change', $manufacturer->id, $old->toJson(), $manufacturer->toJson());

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
            $manufact = Manufacturer::find($id);
            if($manufact){
                $manufact->delete();
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
                $manufact = Manufacturer::withTrashed()->find($id)->restore();
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
            $data = Manufacturer::onlyTrashed()->get();

            $jsonList = array();
            $i = 1;
            foreach ($data as $key => $manufac) {
                $dd = array();
                array_push($dd, $i);

                if ($manufac->name != '') {
                    array_push($dd, $manufac->name);
                } else {
                    array_push($dd, "-");
                }

                array_push($dd, '<a href="#" class="red item-trash" data-id="' . $manufac->id . '" data-toggle="tooltip" data-placement="top" title="Restore Manufacturer"><i class="fa fa-reply"></i></a>');


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
        $manufacturer=Manufacturer::find($id);
        return view('manufacturerManage::manufacturer.edit')->with(['manufacturer'=>$manufacturer]);
	}

	/**
	 * save edit
	 *
	 * @return Redirect to menu add
	 */
	public function edit(ManufacturerRequest $request, $id)
	{
        try {
            DB::transaction(function () use ($request,$id) {
                $manufacturer=Manufacturer::find($id);
                $old = $manufacturer->replicate();

                if($manufacturer){
                    $manufacturer->name=$request->get('name');
                    $manufacturer->save();

                    $this->auditLogger->addLog('Manufacturer', 'Edit Entry', $manufacturer->id, $old->toJson(), $manufacturer->toJson());
                }else{
                    throw new TransactionException('Something wrong.Manufacturer wasn\'t found', 100);
                }
            });
            return redirect('manufacturer/list')->with(['success' => true,
                'success.message' => 'Manufacturer` Updated successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('manufacturer/edit/'.$id)->with(['error' => true,
                'error.message' => 'Somthing went wrong!',
                'error.title' => 'Error!']);
        } catch (Exception $e) {
            return redirect('manufacturer/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error!',
                'error.title' => 'Error!']);
        }
	}
}
