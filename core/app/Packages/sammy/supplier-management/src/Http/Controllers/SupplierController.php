<?php
namespace Sammy\SupplierManage\Http\Controllers;


use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Exceptions\TransactionException;

use PhpSpec\Exception\Exception;
use Illuminate\Http\Request;

use Sammy\SupplierManage\Http\Requests\SupplierRequest;
use Sammy\SupplierManage\Models\Supplier;
use Sammy\Permissions\Models\Permission;

use Response;
use Sentinel;
use DB;

class SupplierController extends Controller {

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
        return view( 'supplierManage::supplier.add' );
	}

    /**
     * Add new entity to database
     *
     * @param ManufacturerRequest $request
     * @return Redirect to menu add
     */
	public function add(SupplierRequest $request)
	{
        try {
            DB::transaction(function () use ($request) {

        		$supplier = Supplier::create([
                    'name'    => $request->get('supplier_name'),
                    'address' => $request->get('supplier_address'),
                    'city'    => $request->get('city'),
                    'country' => $request->get('country'),
                    'phone'   => $request->get('supplier_phone'),
                    'fax'     => $request->get('supplier_fax'),
                    'email'   => $request->get('supplier_email'),
                    'remark'  => $request->get('remark')
                ]);

                $this->auditLogger->addLog('Supplier', 'Add Entry', $supplier->id, null, $supplier->toJson());

                if(!$supplier){
                    throw new TransactionException('Something wrong.Supplier wasn\'t created', 100);
                }

            });

            return redirect( 'supplier/add' )->with([ 'success' => true,
                'success.message'=> 'Supplier added successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('supplier/add')->with([ 'error' => true,
                'error.message'=> 'Supplier not created!',
                'error.title' => 'Well Done!' ]);
        } catch (Exception $e) {
            return redirect('supplier/add')->with([ 'error' => true,
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
        $data = Supplier::whereNull('deleted_at');

        if($request->name != ''){
            $data->where('name','like','%'.$request->name.'%');
        }

        $data = $data->paginate(10);
        $count=$data->total();
		return view( 'supplierManage::supplier.list' )->with(['data' => $data,'row_count'=>$count, 'old' => $request]);
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
            $supplier = Supplier::find($id);
            $old = $supplier->replicate();

            if ($supplier) {

                $supplier->status=$status;                   
                $supplier->save();

                $this->auditLogger->addLog('Supplier', 'Status Change', $supplier->id, $old->toJson(), $supplier->toJson());

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
        $supplier=Supplier::find($id);
        return view( 'supplierManage::supplier.edit')->with(['supplier'=>$supplier]);
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
                $supplier=Supplier::find($id);
                $old = $supplier->replicate();

                if($supplier){
                    $supplier->name=$request->get('supplier_name');
                    $supplier->country=$request->get('country');
                    $supplier->city=$request->get('city');
                    $supplier->address=$request->get('supplier_address');
                    $supplier->fax=$request->get('supplier_fax');
                    $supplier->phone=$request->get('supplier_phone');
                    $supplier->email=$request->get('supplier_email');
                    $supplier->remark=$request->get('remark');

                    $supplier->save();

                    $this->auditLogger->addLog('Supplier', 'Edit Entry', $supplier->id, $old->toJson(), $supplier->toJson());
                }else{
                    throw new TransactionException('Something wrong.Suplier wasn\'t found', 100);
                }
            });
            return redirect('supplier/list')->with(['success' => true,
                'success.message' => 'Supplier Updated successfully!',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            return redirect('supplier/edit/'.$id)->with(['error' => true,
                'error.message' => 'Supplier not updated!',
                'error.title' => 'Error!']);
        } catch (Exception $e) {
            return redirect('supplier/edit/'.$id)->with(['error' => true,
                'error.message' => 'Supplier not updated!',
                'error.title' => 'Error!']);
        }
	}
}
