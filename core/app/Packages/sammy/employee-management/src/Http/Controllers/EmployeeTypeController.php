<?php
namespace Sammy\EmployeeManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use Sammy\Permissions\Models\Permission;
use Sammy\EmployeeManage\Http\Requests\EmployeeTypeRequest;
use Sammy\EmployeeManage\Models\EmployeeType;
use Illuminate\Http\Request;
use Response;
use Sentinel;
use DB;

use App\Exceptions\TransactionException;

class EmployeeTypeController extends Controller
{

    private $auditLogger;
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(AuditLogger $auditLogger)
    {
        //$this->middleware('guest');
        $this->auditLogger = $auditLogger;
    }

    /**
     * Show the Employee type add add screen to the user.
     *
     * @return Response
     */
    public function addView()
    {
        $typeList = EmployeeType::where('status',1)->get()->lists('name','id');
        return view( 'employeeManage::type.add' )->with(['parentList'=>$typeList]);
    }

    /**
     * add new employee type data to database
     * @param $request
     * @return Redirect to type add
     */
    public function add(EmployeeTypeRequest $request)
    {        
        try {
            DB::transaction(function () use ($request) {
                if($request->get('name')){                    
                    $type = EmployeeType::create([
                        'name' => $request->get('name'),
                        'parent'=>$request->get('parent')
                    ]);

                    $this->auditLogger->addLog('Employee Type', 'Add Entry', $type->id, null, $type->toJson());

                    if(!$type){
                        throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
                    }
                }else{
                    throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
                }
            });
            return redirect()->back()->with([ 'success' => true,
                'success.message' => 'Employee type added successfully!',
                'success.title'   => 'Success..!' ]);
        } catch (TransactionException $e) {
            if ($e->getCode() == 100) {
                return Response::json([0]);
            }else if ($e->getCode() == 101) {
                return Response::json([0]);
            }
        } catch (Exception $e) {
            return Response::json([0]);
        }

    }

    /**
     * Show the Employee type list screen to the user.
     *
     * @return Response
     */
    public function listView()
    {
        $data = EmployeeType::whereNull('deleted_at')->with(['parentType']);
        $data=$data->paginate(20);
        $count=$data->total();
        return view('employeeManage::type.list')->with(['data' => $data,'row_count'=>$count]);
    }

    /**
     * Delete a Employee Type
     * @param  Request  type id
     * @return Json     json object with status of success or failure
     */
    public function delete(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $type = EmployeeType::find($id);
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
     * Activate or Deactivate Employee Type
     * @param  Request  Employee Type id with status to change
     * @return Json     json object with status of success or failure
     */
    public function status(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $status = $request->input('status');

            $type = EmployeeType::find($id);
            if($type){
                $type->status = $status;
                $type->save();
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
    * Show the Employee Type Edit screen to the user.
    * @param Request    type id
    * @return Response  Edit view
    */
    public function editView($id)
    {
        $type = EmployeeType::find($id);
        $typeList = EmployeeType::where('status',1)->get()->lists('name','id');
        return view( 'employeeManage::type.edit' )->with(['type'=>$type, 'parentList'=>$typeList]);
    }

    /**
     * Set employee type data to database
     *
     * @return Redirect to Employee List
     */
    public function edit(EmployeeTypeRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request,$id) {
                $type = EmployeeType::find($id);
                $old = $type->replicate();
                if($type){
                    $type->name = $request->get('name');
                    $type->parent = $request->get('parent');
                    $type->save();

                    $this->auditLogger->addLog('Employee Type', 'Edit Entry', $type->id, $old->toJson(), $type->toJson());
                }else{
                    throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
                }
            });
            return redirect( 'employee/type/list' )->with([ 'success' => true,
                'success.message'=> 'Type updated successfully!',
                'success.title' => 'Success...!' ]);
        } catch (TransactionException $e) {
            Log::info($e);
            return redirect('employee/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error',
                'error.title' => 'Ops!']);

        } catch (Exception $e) {
            Log::info($e);
            return redirect('employee/type/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error',
                'error.title' => 'Ops!']);
        }

    }
}