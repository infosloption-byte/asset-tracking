<?php
namespace Sammy\EmployeeManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\LocationType;
use App\Models\AssetTransaction;

use Sammy\UserManage\Models\User;
use Sammy\Permissions\Models\Permission;

use Sammy\EmployeeManage\Http\Requests\EmployeeRequest;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\EmployeeManage\Models\EmployeeType;
use Sammy\EmployeeManage\Models\EmployeeDesignation;

use Sammy\Location\Models\Location;
use Sammy\Location\Models\EmployeeLocation;

use Sammy\UserRoles\Models\UserRole;
use Sammy\UserManage\Models\RoleUsers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use DB;
use Response;
use Sentinel;
use Hash;
use Reminder;

use App\Exceptions\TransactionException;

class EmployeeController extends Controller
{
    private $auditLogger;
    public function __construct(AuditLogger $auditLogger)
    {
        $this->auditLogger = $auditLogger;
    }

    /**
     * Show the menu add screen to the user.
     *
     * @return Response
     */
    public function addView()
    {

        $empType = EmployeeType::where('status',1)->orderBy('parent')->get()->lists('name', 'id');
        
        $locationTypeList = LocationType::where('status',1)->lists('name','id');

        $location = Location::where('status',1)->lists('name','id');

        $roles = UserRole::all()->lists('name','id');

        $tmp = EmployeeType::first();

        $parentList = Employee::where('depth','>=',0)
                ->where('status', 1)
                ->where('employee_type_id',$tmp->parent)
                ->select(DB::raw('CONCAT(first_name," ",last_name) as name'), 'id')
                ->lists('name','id');

        return view('employeeManage::employee.add')->with(['typeList' => $empType, 'locationTypeList' => $locationTypeList, 'location' => $location,'roles'=>$roles,'parentList'=>$parentList]);
    }

    /**
     * add new employee type data to database
     * @param $request
     * @return Redirect to type add
     */
    public function add(EmployeeRequest $request)
    {
        // return $request->all();
        //check valid employee type selected by user
        if ($request->get('empType') == 0) {
            return redirect('employee/add')->withInput()->withErrors(array('empType' => 'Employee Type is required'));
        }

        //check valid parent selected by user
        if ($request->get('empType') >= 1 && $request->get('parent') == 0){
            return redirect('employee/add')->withInput()->withErrors(array('parent' => 'Parent is required'));
        }

        //check valid location selected by user
        if ($request->get('location') == 0){
            return redirect('employee/add')->withInput()->withErrors(array('location' => 'Location is required'));
        }

        if ($request->get('empType') > 1) {
            $parent = Employee::find($request->get('parent'));
        } else {
            $parent = Employee::find(1);
        }

        try {
            DB::transaction(function () use ($request,$parent) {

                Employee::where('code',$request->get('code'))->delete();
                User::where('username',$request->get('code'))->delete();

                $employee = Employee::create([
                    'first_name' => $request->get('fName'),
                    'last_name' => $request->get('lName'),
                    'code' => $request->get('code'),
                    'nic' => $request->get('nic'),
                    'email' => $request->get('email'),
                    'employee_type_id' => $request->get('empType'),
                    'mobile' => $request->get('mobile'),
                    'branch_user' => $request->get('branch_user'),
                    'address' => $request->get('address'),
                    'created_by' => Sentinel::getUser()->id
                ]);


                if($employee){

                    $employee->makeChildOf($parent);
                    
                    $empLoc=EmployeeLocation::create([
                        'location_id'=>$request->get('location'),
                        'employee_id'=>$employee->id
                    ]);

                    $this->auditLogger->addLog('Employee', 'Add Entry', $employee->id, null, $employee->toJson());
                    
                    if(!$empLoc){
                        throw new TransactionException('Something wrong.Employee wasn\'t created', 100);
                    }                    
                    
                }else{
                    throw new TransactionException('Something wrong.Employee wasn\'t created', 100);
                }
            });
            return redirect('employee/add')->with(['success' => true,
                'success.message' => 'Employee added successfully!',
                'success.title' => 'Well Done!']);
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
     * Show the menu list screen to the user.
     *
     * @return Response
     */
    public function listView(Request $request)
    {

        $data   = Employee::where('parent','>',0)->with(['parentEmployee','type','location.location']);
        $types  = EmployeeType::orderBy('parent')->get();

        $code = $request->code;
        if($code!=null){
            $data  = $data->where('code','like','%'.$code.'%');
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=0)
        {
            if($old_status == 3){
                $tmp_status = 0;
            }else if($old_status == 4){
                $tmp_status = -1;
            }else{
                $tmp_status = $old_status;
            }

            if($tmp_status != -1) {
                $data = $data->where('varified_status', $tmp_status);
            }else{
                $data = $data->where('varified_status', 1)
                            ->where('status', 0);
            }
        }

        $name = $request->name;
        if($name!=null){
            $data  = $data->where('first_name','like','%'.$name.'%')
                        ->orWhere('last_name','like','%'.$name.'%');
        } 

        $keyword = $request->keyword;
        if($keyword!=null){
            $data  = $data->where('address','like','%'.$keyword.'%')
                    ->orWhere('mobile','like','%'.$keyword.'%')
                    ->orWhere('email','like','%'.$keyword.'%');
        } 

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->where('employee_type_id',$type);
        } 

        $location = $request->location;
        if($location!=null && $location>0){
            $data  = $data->whereIn('id',function($q)use($location)
            {
                $q->select('employee_id')->from('user_location')->where('location_id',$location);
            });
        }

        $data = $data->paginate(10);
        $count=$data->total();

        $status=array(0=>'--All--',1=>'Verified',2=>'Rejected',3=>'Not Verified', 4 => 'Unauthorized');
        // $status=array(1=>'Verified',2=>'Rejected',0=>'Not Verified', -1 => 'Unauthorized');

        $locations =  Location::where('status',1)->lists('name','id');

        return view('employeeManage::employee.list')->with([
            'data'    => $data,
            'types' => $types,
            'locations' => $locations,
            'row_count'=>$count,
            'status' => $status,
            'old'     => ['code'=>$code,'name'=>$name,'keyword'=>$keyword,'type'=>$type,'status'=>$old_status,'location'=>$request->location]
        ]);
    }

    /**
     * Show the employee list data to the user.
     *
     * @return Response
     */
    public function jsonList(Request $r)
    {
        $data = Employee::where('parent','>',0)->with(['parentEmployee','type','location.location'])->get();
        $jsonList = array();
        $i=1;
        foreach ($data as $employee) {
            $dd= array();
            array_push($dd,$i);

            array_push($dd,$employee->first_name);
            array_push($dd,$employee->last_name);
            array_push($dd,$employee->code);
            array_push($dd,$employee->address);
            if($employee->location!=null){
                array_push($dd,$employee->location->location->name);
            }else{
                array_push($dd,"");
            }
            array_push($dd,$employee->email);
            array_push($dd,$employee->mobile);
            array_push($dd,$employee->type->name);
            array_push($dd,$employee->parentEmployee->getFullNameAttribute());

            if($employee->status==1){                 
                array_push($dd, '<span class="label label-success" style="padding: .6em 10px .3em;">Activated</span>');
            }else{
                array_push($dd, '<span class="label label-danger" style="padding: .6em 10px .3em;">Deactivated</span>');
            }

            if($employee->status==1){
                if(Sentinel::hasAnyAccess(['employee.edit','admin'])){
                    array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate"><input class="employee-activate" type="checkbox" checked value="'.$employee->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
                }else{
                    array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Deactivate"><input disabled class="employee-activate" type="checkbox" checked value="'.$employee->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
                }
            }else{
                array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Click to Activate"><input class="employee-activate" type="checkbox" value="'.$employee->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
            }

            if (Sentinel::hasAnyAccess(['employee.edit','admin'])) {
                array_push($dd, '<a href="#" class="blue" onclick="window.location.href=\'' . url('employee/edit/' . $employee->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Type" style="background: #3F51B5;padding: 5px;border-radius: 2px;"><i class="fa fa-pencil"></i></a>');
            } else {
                array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
            }

            if (Sentinel::hasAnyAccess(['employee.type.delete', 'admin'])) {
                array_push($dd, '<a href="#" class="red employee-delete" data-id="' . $employee->id . '" data-toggle="tooltip" data-placement="top" title="Delete Type" style="background: #CC1A6C;padding: 5px;border-radius: 2px;"><i class="fa fa-trash-o"></i></a>');
            } else {
                array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
            }


            array_push($jsonList, $dd);
            $i++;

        }
        return Response::json(array('data' => $jsonList));
    }

    /**
     * Activate or Deactivate Employee
     * @param  Request $request employee id with status to change
     * @return Json            json object with status of success or failure
     */
    public function status(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id');
            $status = $request->input('status');
            $employee = Employee::find($id);
            $old = $employee->replicate();

            if ($employee) {
                
                if ($status == 0) {
                    $asset=AssetTransaction::where('employee_id',$employee->id)->where('location_type','employee')->whereNull('deleted_at')->first();

                    if($asset){
                        return response()->json(['status' => 'assinged']);
                    }else{
                        $employee->status = $status;
                        $employee->save();
                        
                        $web_user = User::where('employee_id', $id)->first();

                        if ($web_user) {
                            $user = Sentinel::findById($web_user->id);
                            
                            $update_user = User::find($web_user->id);
                            $update_user->status = $status;
                            $update_user->save();
                            
                            Activation::remove($user);
                        }

                        $this->auditLogger->addLog('Employee', 'Status Change', $employee->id, $old->toJson(), $employee->toJson());
                    }

                }else{
                    $employee->status = $status;
                    $employee->save();
                    
                    $web_user = User::where('employee_id', $id)->first();

                    if ($web_user) {
                        $user = Sentinel::findById($web_user->id);
                        
                        $update_user = User::find($web_user->id);
                        $update_user->status = $status;
                        $update_user->save();
                                                
                        $acUser = Activation::create($user);
                        Activation::complete($user, $acUser->code);
                        
                    }

                    $this->auditLogger->addLog('Employee', 'Status Change', $employee->id, $old->toJson(), $employee->toJson());
                }                

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'invalid_id']);
            }
        } else {
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Delete a Employee
     * @param  Request  employee id
     * @return Json     json object with status of success or failure
     */
    public function delete(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $employee = Employee::find($id);
            if($employee){

                $asset=AssetTransaction::where('location_id',$employee->id)->where('location_type','employee')->whereNull('deleted_at')->first();

                if($asset){
                    return response()->json(['status' => 'assinged']);
                }else{                
                    $employee->delete();

                    $web_user = User::where('employee_id', $id)->first();
                    if ($web_user) {
                        $user = Sentinel::findById($web_user->id);
                        
                        $update_user = User::find($web_user->id);
                        $update_user->status = 0;
                        $update_user->save();
                        
                        Activation::remove($user);

                        $web_user->delete();
                        
                    }

                    return response()->json(['status' => 'success']);
                }
            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Varify a Employee
     * @param  Request  employee id
     * @return Json     json object with status of success or failure
     */
    public function varify(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $employee = Employee::find($id);
            if($employee){

                $employee->varified_status=1;
                $employee->varified_by=Sentinel::getUser()->id;
                $employee->varified_date=date('Y-m-d H:i:s');
                $employee->save();
                
                return response()->json(['status' => 'success']);

            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Reject a Employee
     * @param  Request  employee id
     * @return Json     json object with status of success or failure
     */
    public function reject(Request $request)
    {
        if($request->ajax()){
            $id = $request->input('id');
            $employee = Employee::find($id);
            if($employee){

                $employee->varified_status=2;
                $employee->varified_by=Sentinel::getUser()->id;
                $employee->save();
                
                return response()->json(['status' => 'success']);

            }else{
                return response()->json(['status' => 'invalid_id']);
            }
        }else{
            return response()->json(['status' => 'not_ajax']);
        }
    }

    /**
     * Show the menu edit screen to the user.
     * @param type id
     * @return Response
     */
    public function editView($id)
    {
        $employee = Employee::with('type','location.location.locationType')->find($id);
        
        $empType = EmployeeType::whereNotIn('status',[0])->orderBy('parent')->get()->lists('name', 'id')->prepend('---- Select Employee Type ----',0);

        $type = EmployeeType::find($employee->employee_type_id);

        $parentList = Employee::where('employee_type_id',1)
                ->where('status', 1)
                ->select(DB::raw('CONCAT(first_name," ",last_name) as name'), 'id')
                ->lists('name','id');

        $user_exist=User::where('employee_id',$employee->id)->first();
        
        $show_user_account;
        if(count($user_exist)>0){
            $show_user_account=1;
        }else{
            $show_user_account=0;
        }        

        $dealer_exist=[];
        
        $show_mobile_account;
        if(count($dealer_exist)>0){
            $show_mobile_account=1;
        }else{
            $show_mobile_account=0;
        }

        $locationTypeList = LocationType::all()->lists('name','id')->prepend('---- Select Location Type ----',0);

        if(isset($employee->location)){
            $location=Location::where('type',$employee->location->location->locationType->id)->lists('name','id');
            $selectedLocType=$employee->location->location->locationType->id;
            $selectedLoc=$employee->location->location_id;
        }else{
            $location=Location::where('type',1)->lists('name','id');
            $selectedLocType=1;
            $selectedLoc=1;
        }


        return view('employeeManage::employee.edit')->with(['employee' => $employee, 'typeList' => $empType,'parentList' => $parentList, 'user_exist' => $show_user_account, 'dealer_exist' => $show_mobile_account,"locationTypeList"=>$locationTypeList,"selectedLocType"=>$selectedLocType,"location"=>$location,"selectedLoc"=>$selectedLoc]);
    }

    /**
     * Check employee assigned asset
     *
     * @return if asset assigned true or not false
     */
    public function getAsset(Request $request)
    {
        $employee = Employee::with('location')->find($request->employee);

        if($employee->location->location_id!=$request->location){
            $assigned_asset=AssetTransaction::where('employee_id',$employee->id)->whereNull('deleted_at')->where('location_type','employee')->first();
            if($assigned_asset){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    /**
     * Add new type data to database
     *
     * @return Redirect to menu edit
     */
    public function edit(EmployeeRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request,$id) {

                $employee=Employee::find($id);
                $old = $employee->replicate();

                if($employee){
                    $employee->first_name   =$request->get('fName');
                    $employee->last_name    = $request->get('lName');
                    $employee->code         = $request->get('code');
                    $employee->nic          = $request->get('nic');
                    $employee->email        = $request->get('email');
                    $employee->mobile       = $request->get('mobile');
                    $employee->address      = $request->get('address');
                    $employee->employee_type_id = $request->get('empType');
                    $employee->branch_user      = $request->get('branch_user');
                    $employee->status=0;
                    $employee->save();

                    $usr = User::where('employee_id',$employee->id)->first();

                    if($usr){
                        $usr->status=0;
                        $usr->save();
                    }
                    
                    if(($request->get('parent') != $employee->id) && ($request->get('parent') != $employee->parent)){
                        $empParent = Employee::find($request->get('parent'));
                        $employee->makeChildOf($empParent);
                    }
                    
                    $currentDesignation=EmployeeDesignation::where('employee_id',$id)->delete();

                    $empDesignation=EmployeeDesignation::create([
                        'employee_id'=>$id,
                        'type_id'=>$request->get('empType')
                    ]);

                    if(!$empDesignation){
                        throw new TransactionException('Something wrong.User wasn\'t created', 102);
                    }                    

                    $currentLocation=EmployeeLocation::where('employee_id',$id)->delete();

                    $empLocation=EmployeeLocation::create([
                        'location_id'=>$request->get('location'),
                        'employee_id'=>$id
                    ]);

                    if(!$empLocation){
                        throw new TransactionException('Something wrong.User wasn\'t created', 101);
                    }else{
                        $assigned_asset=AssetTransaction::where('employee_id',$id)->whereNull('deleted_at')->where('location_type','employee')->first();

                        if($assigned_asset){
                            $assigned_asset->delete();

                            $asset_deployee=AssetTransaction::create([
                                'asset_id'=>$assigned_asset->asset_id,
                                'status_id'=>1,
                                'location_type'=>'location',
                                'location_id'=>$assigned_asset->location_id,
                                'user_id'=>Sentinel::getUser()->employee_id
                            ]);

                            if(!$asset_deployee){
                                throw new TransactionException('Something wrong.User wasn\'t created', 103);
                            }
                        }
                    }

                    $this->auditLogger->addLog('Employee', 'Edit Entry', $employee->id, $old->toJson(), $employee->toJson());
                    
                }else{
                    throw new TransactionException('Something wrong.Employee wasn\'t created', 100);
                }
            });
            return redirect('employee/list')->with(['success' => true,
                'success.message' => 'Employee Edited successfully!. Employee pending for approval',
                'success.title' => 'Well Done!']);
        } catch (TransactionException $e) {
            Log::info($e);
            return redirect('employee/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error',
                'error.title' => 'Ops!']);

        } catch (Exception $e) {
            Log::info($e);
            return redirect('employee/edit/'.$id)->with(['error' => true,
                'error.message' => 'Transaction Error',
                'error.title' => 'Ops!']);
        }
    }

    /**
     * Load employee for Reset Password view of Web Account
     *
     * @return Response Json List of employee
     */
    public function loadEmployee(Request $request)
    {   
        if($request->ajax()){
            $employee = Employee::where('status', 1)->where('employee_type_id', $request->get('type'))->select(DB::raw('CONCAT(code," ",first_name," ",last_name) as name'), 'id')->lists('name','id')->prepend('---- Select Employee Employee ----','0');
            return response()->json($employee);
        }else{
            return response()->json([]);
        }        
    }

    /**
     * Reset Password view of Web Account
     *
     * @return Redirect to Web Account Password Reset View
     */
    public function viewPasswordReset(Request $request)
    {
        $empType = EmployeeType::orderBy('parent')->get()->lists('name', 'id')->prepend('---- Select Employee Type ----','0');
        $employee = Employee::where('status', 1)->select(DB::raw('CONCAT(code," ",first_name," ",last_name) as name'), 'id')->lists('name','id')->prepend('---- Select Employee Employee ----','0');

        $logged_user=Sentinel::getUser();

        $reset_multiple_user="";

        if($logged_user->employee[0]->employee_type_id==1){
            $reset_multiple_user=true;
        }else{
            $reset_multiple_user=false;
        }

        $logged_user_type_id=$logged_user->employee[0]->employee_type_id;
        $logged_user_id=$logged_user->employee[0]->id;

        return view('employeeManage::reset.reset-password')->with(['empTypeList' => $empType,'employeeList' => $employee,'logged_employee_type'=>$logged_user_type_id,'logged_employee'=>$logged_user_id,'reset_multiple'=>$reset_multiple_user]);
    }

    /**
     * Load user credential Detail to view of Reset Password View
     *
     * @return Response JSON List of credential Detail
     */
    public function loadCredentialData(Request $request)
    {
        if($request->ajax()){            
            $user = User::where('employee_id',$request->get('employee'))->get();
            return response()->json(['user' => $user]);            
        }else{
            return response()->json([]);
        }
    }

    /**
     * Reset Web Account Password data to database
     *
     * @return Response
     */
    public function passwordReset(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $data=$request->get('detail');                

                if($data['web_password']){
                    if($data['web_password'] != null || $data['web_password'] != ""){

                        $user = User::where('employee_id',$request->get('employee'))->first();

                        $user = Sentinel::findById($user->id);

                        $rem_object= Reminder::create($user);

                        if($rem_object){
                            $new_password = Reminder::complete($user, $rem_object->code, $data['web_password']);

                            $this->auditLogger->addLog('Employee', 'Password Reset', $user->id, null, json_encode(['username'=>$user->username]));
                        }else{
                            throw new TransactionException('Something wrong.Dealer wasn\'t created', 100);
                        }
                    }
                }
            });
            return Response::json([1]);
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
     * Add new type data to database
     *
     * @return Redirect to menu edit
     */
    public function filter(Request $request)
    {
        $filterArr = json_decode($request->get('data'));
        $cur = $request->get('currentPage');
        $size = $request->get('pageSize');
        $skip = ($cur * $size) - ($size);
        $count = 0;
        $sql = 'SELECT emp.first_name,emp.last_name,emp.email,emp_type.type,emp.id,emp.mobile,emp.address FROM dimo_employee as emp INNER  JOIN dimo_employee_type as emp_type ON emp.employee_type_id=emp_type.id ';
        if ($filterArr[0]->value != "") {
            $sql .= 'WHERE ';
            for ($i = 0; $i < count($filterArr); $i++) {
                if ($i > 0) {
                    $sql .= ' AND ';
                }
                $sql .= $filterArr[$i]->name . ' LIKE "%' . $filterArr[$i]->value . '%" ';
            }
            $emp = DB::select($sql);
            $count = count($emp);
            $sql .= ' LIMIT ' . $skip . ',' . ($cur * $size);
            $emp = DB::select($sql);
        } else {
            $emp = Employee::join('dimo_employee_type as type', 'type.id', '=', 'employee_type_id')
                ->select('dimo_employee.first_name', 'dimo_employee.last_name', 'dimo_employee.email', 'dimo_employee_type.type', 'dimo_employee.id', 'dimo_employee.mobile', 'dimo_employee.address')
                ->take($size)
                ->skip($skip)
                ->get();
            $count = Employee::count();
        }
        return response()->json(array('data' => $emp, 'count' => $count));
    }

    /**
     * get data of for selected id
     * @param Request $request location type id
     * @return data object
     */
    public function getViewData(Request $request)
    {
        $employer = Employee::find($request->get('id'));
        if ($employer->type->type == 'Rep') {
            $employer = Employee::join('dimo_rep as r', 'r.employee_id', '=', 'dimo_employee.id')
                ->find($request->get('id'));
            $arr = array(
                'first_name' => $employer->first_name,
                'last_name' => $employer->last_name,
                'email' => $employer->email,
                'type' => $employer->type->type,
                'mobile_user_name' => $employer->mobile_user_name,
                'short_code' => $employer->short_code,
                'mobile' => $employer->mobile,
                'address' => $employer->address,
                'parent' => count($employer->parent()->get()) > 0 ? $employer->parent()->get()[0]->full_name : ''

            );
            $employee = ['first_name', 'last_name', 'address', 'email', 'mobile', 'type', 'parent', 'mobile_user_name', 'short_code'];
            return response()->json(array($arr, $employee));
        }elseif($employer->type->id == 6){
            $employer = Employee::join('dimo_msr as r', 'r.employee_id', '=', 'dimo_employee.id')
                ->find($request->get('id'));
            $arr = array(
                'first_name' => $employer->first_name,
                'last_name' => $employer->last_name,
                'email' => $employer->email,
                'type' => $employer->type->type,
                'mobile_user_name' => $employer->mobile_user_name,
                'mobile' => $employer->mobile,
                'address' => $employer->address,
                'parent' => count($employer->parent()->get()) > 0 ? $employer->parent()->get()[0]->full_name : ''

            );
            $employee = ['first_name', 'last_name', 'address', 'email', 'mobile', 'type', 'parent', 'mobile_user_name'];
            return response()->json(array($arr, $employee));
        }
        $arr = array(
            'first_name' => $employer->first_name,
            'last_name' => $employer->last_name,
            'mobile' => $employer->mobile,
            'address' => $employer->address,
            'email' => $employer->email,
            'type' => $employer->type->type,
            'parent' => count($employer->parent()->get()) > 0 ? $employer->parent()->get()[0]->full_name : ''

        );
        $employee = ['first_name', 'last_name', 'address', 'email', 'mobile', 'type', 'parent'];
        return response()->json(array($arr, $employee));
    }

    /**
     * get location list of filter the type
     * @param Request $request location type id
     * @return location list
     */
    public function getLocation(Request $request)
    {
        if ($request->get('type') > 0) {
            $location = Location::where('type', $request->get('type'))->orderBy('name','ASC')->lists('name','id');            
            return response()->json($location);
        }else{
            return response()->json([]);
        }
    }

    /**
     * get employee list of filter the type
     * @param Request $request employee type id
     * @return parent list
     */
    public function getParent(Request $request)
    {
        $empType=EmployeeType::find($request->get('type'));

        $employee = Employee::where('employee_type_id',1)->orderBy('first_name','ASC')->select(DB::raw('CONCAT(first_name," ",last_name) as name'), 'id')->lists('name','id');
        return response()->json($employee);
    }

}