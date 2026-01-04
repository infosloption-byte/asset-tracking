<?php
namespace Sammy\UserManage\Http\Controllers;

use App\Classes\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\AssetTransaction;
use App\Classes\UserLocationFilter;

use Sammy\UserManage\Models\User;
use Sammy\UserManage\Models\RoleUsers;
use Sammy\UserRoles\Models\UserRole;
use Sammy\permissions\Models\Permission;
use Sammy\UserManage\Http\Requests\UserRequest;
use Sammy\EmployeeManage\Models\Employee;
use Sammy\EmployeeManage\Models\EmployeeType;
use Sammy\Location\Models\Location;
use Sammy\Location\Models\EmployeeLocation;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use DB;
use Response;
use Sentinel;
use Hash;
use Reminder;

use App\Exceptions\TransactionException;


class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Controller
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
	public function __construct(AuditLogger $auditLogger)
	{
	    $this->auditLogger = $auditLogger;
		//$this->middleware('guest');
	}

	/**
	 * Show the User add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{
		$user = User::all()->lists('full_name' , 'id' );
		$roles = UserRole::all()->lists('name' , 'id' )->prepend('Select Role',0);	
		$user->prepend('No Supervisor', '0');

		$employees = Employee::whereNotIn('id',array_pluck(User::select('employee_id')->get(),'employee_id'))->where('status',1)->where('branch_user',1)->get();
		return view( 'userManage::user.add' )->with([ 'users' => $user,
			'roles' => $roles,
			'employees'=>$employees
		 ]);;
	}

	/**
	 * Add new user data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(UserRequest $request)
	{	

		try {
            DB::transaction(function () use ($request) {

        		$user = Sentinel::registerAndActivate([
					'username'   => $request->get('user_name' ),
					'password'   =>  $request->get('password' ),			
				]);	

				if($user){
					$user->employee_id 	= $request->emp;
					$user->created_by 	= Sentinel::getUser()->id;
					$user->save();

					$role = Sentinel::findRoleById($request->get( 'roles' ));
			   		$role->users()->attach($user);

                    $this->auditLogger->addLog('User', 'Add Entry', $user->id, null, $user->toJson());
				}else{
					throw new TransactionException('Something wrong.Transaction error', 100);
				}


				// if($request->get('supervisor') != 0){
				// 	$supervisor = User::find( $request->get('supervisor') );
				// }else{
				// 	$user->makeRoot();
				// }

				// if(isset($supervisor) && $supervisor != null){
				// 	$user->makeChildOf($supervisor);
				// }

			});
				
			return redirect('user/add')->with([ 'success' => true,
				'success.message'=> 'User added successfully!',
				'success.title' => 'Well Done!']);
		} catch (TransactionException $e) {
            return redirect('user/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error! Please try again',
                'error.title' => 'Error!' ]);
        } catch (Exception $e) {
            return redirect('user/add')->with([ 'error' => true,
                'error.message'=> 'Transaction action error!',
                'error.title' => 'Error!' ]);
        }
	}

	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function listView(Request $request)
	{

		$data = User::with(['employee.parent','UserRole','employee.Location.location','createdBy.employee']);

		$types = UserRole::orderBy('name','ASC')->get();
		$loc = UserLocationFilter::locationHierarchy();

		$txt = $request->search_keyword;
        if($txt!=null || $txt!=''){
            
            $data  = $data->whereIn('employee_id',function($query)use($txt){
		            	$query->select('id')->from('employee')
		            		->where('first_name','like','%'.$txt.'%')
		            		->orWhere('last_name','like','%'.$txt.'%')
		            		->orWhere('code','like','%'.$txt.'%');
            		});
        }

        $old_status = $request->status;
        if($old_status!=null && $old_status!=3 && $old_status!=0){
        	$data  = $data->where('varified_status',$old_status);
        }

        $type = $request->type;
        if($type!=null && $type>0){
            $data  = $data->whereIn('id',function($query)use($type){
            	$query->select('user_id')->from('role_users')
            		->where('role_id',$type);
            });
        }


        $location = $request->location;
        if($location!=null && $location>0){
            $data  = $data->whereIn('employee_id',function($query)use($location){
            	$query->select('employee_id')->from('user_location')
            		->where('location_id',$location);
            });
        }

        $status=array(3=>'All',1=>'Varified',2=>'Rejected',0=>'Not Varified');

        $data = $data->paginate(20);
        $count = $data->total();
		return view( 'userManage::user.list' )->with([
            'data'    => $data,
            'types' => $types,
            'locations' => $loc,
            'status' => $status,
            'row_count' =>$count,
            'old'     => ['search_keyword'=>$txt,'type'=>$type,'location'=>$location,'status'=>$old_status]
        ]);
	}

	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		if($request->ajax()){
			$data= User::with(['employee.parent','roles'])->get();			
			$jsonList = array();
			$i=1;
			foreach ($data as $key => $user) {
				$dd = array();
				array_push($dd, $i);
				if($user->username != ""){
					array_push($dd, $user->username);
				}else{
					array_push($dd, "-");
				}

				if($user->employee[0]->first_name != ""){
					array_push($dd, $user->employee[0]->first_name);
				}else{
					array_push($dd, "-");
				}

				if($user->employee[0]->last_name != ""){
					array_push($dd, $user->employee[0]->last_name);
				}else{
					array_push($dd, "-");
				}

				if($user->employee_id){
					$roleU=RoleUsers::where('user_id',$user->id)->orderBy('created_at','DESC')->limit(1)->first();
					$rle=UserRole::find($roleU['role_id']);
					array_push($dd, $rle['name']);
				}else{
					array_push($dd, "-");
				}

				if($user->employee[0]->email != ""){
					array_push($dd, $user->employee[0]->email);
				}else{
					array_push($dd, "-");
				}

				if($user->last_login != ""){
					array_push($dd, $user->last_login);
				}else{
					array_push($dd, "-");
				}

				if($user->status == 1){
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate"><input class="user-activate" type="checkbox" checked value="'.$user->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}else{
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate"><input class="user-activate" type="checkbox" value="'.$user->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}

				$permissions = Permission::whereIn('name',['user.edit','admin'])->where('status','=',1)->lists('name');
				if(Sentinel::hasAnyAccess($permissions)){
					array_push($dd, '<a href="#" class="blue" onclick="window.location.href=\''.url('user/edit/'.$user->id).'\'" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-pencil"></i></a>');
				}else{
					array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

				array_push($jsonList, $dd);
				$i++;
			}
			return Response::json(array('data'=>$jsonList));
		}else{
			return Response::json(array('data'=>[]));
		}
	}


	/**
	 * Activate or Deactivate User
	 * @param  Request $request user id with status to change
	 * @return json object with status of success or failure
	 */
	public function status(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$status = $request->input('status');

			$user = User::find($id);
			if($user){
				// $user->status = $status;
				// $user->save();
				// return response()->json(['status' => 'success']);

				$employee = Employee::find($user->employee_id);
				$old = $employee->replicate();

	            if ($employee) {
	                
	                if ($status == 0) {
	                    
	                    $asset=AssetTransaction::where('location_id',$employee->id)->where('location_type','employee')->whereNull('deleted_at')->first();

	                    if($asset){
	                        return response()->json(['status' => 'assinged']);
	                    }else{
	                        $employee->status = $status;
	                        $employee->save();

                            $user->status = $status;
                            $user->save();

                            Activation::remove($user);

                            Sentinel::logout($user,true);
	                    }
                        $this->auditLogger->addLog('User', 'Status Change', $employee->id, $old->toJson(), $employee->toJson());
	                }else{
	                    $employee->status = $status;
	                    $employee->save();

                        $user->status = $status;
                        $user->save();

                        $acUser = Activation::create($user);
                        Activation::complete($user, $acUser->code);
                        $this->auditLogger->addLog('User', 'Status Change', $employee->id, $old->toJson(), $employee->toJson());
	                }                

	                return response()->json(['status' => 'success']);
	            } else {
	                return response()->json(['status' => 'invalid_id']);
	            }

			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Delete a User
	 * @param  Request $request user id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$user = User::find($id);
			if($user){
				// $user->delete();
				// return response()->json(['status' => 'success']);

				$employee = Employee::find($user->employee_id);
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
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Varify a User
	 * @param  Request $request user id
	 * @return Json: 	json object with status of success or failure
	 */
	public function varify(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$user = User::find($id);
			if($user){

				$employee = Employee::find($user->employee_id);
	            
	            if($employee){

	            	$user->varified_status=1;
	            	$user->varified_by=Sentinel::getUser()->id;
	            	$user->varified_date= date('Y-m-d H:i:s');

	            	$user->save();

					return response()->json(['status' => 'success']);

	            }else{
	                return response()->json(['status' => 'invalid_id_employee']);
	            }

			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Reject a User
	 * @param  Request $request user id
	 * @return Json: 	json object with status of success or failure
	 */
	public function reject(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$user = User::find($id);
			if($user){

				$employee = Employee::find($user->employee_id);
	            
	            if($employee){

	            	$user->varified_status=2;
	            	$user->varified_by=Sentinel::getUser()->id;

	            	$user->save();

					return response()->json(['status' => 'success']);

	            }else{
	                return response()->json(['status' => 'invalid_id_employee']);
	            }

			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the user edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{
		$user = User::all()->lists('full_name' , 'id' );
		$user->prepend('No Supervisor', '0');
	    $curUserold = User::with(['roles'])->find($id);
	    $curUser=$curUserold;  
	    $srole = array();

	    foreach ($curUser->roles as $key => $value) {
	    	array_push($srole, $value->id);
	    }

	    $roles = UserRole::all()->lists('name' , 'id' );
		if($curUser){
			return view( 'userManage::user.edit' )->with([ 
				'curUser' => $curUser,
				'users'=>$user,
				'roles'=>$roles,
				'srole'=>$srole]);
		}else{
			return view( 'errors.404' );
		}
	}

	/**
	 * Add new user data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(UserRequest $request, $id)
	{
   
		$userOld =  User::with(['roles'])->find($id);
		$user=$userOld;
		$old = $userOld->replicate();

		$user->username	=$request->get('user_name' );

		foreach ($user->roles as $key => $value) {
			$role = Sentinel::findRoleById($value->id);
			$role->users()->detach($user);				
		}		
		//Remove Role for current user		
	   	
		$user->status = 0;
		$user->save();
		//attach user for role
		foreach ($request->get( 'roles' ) as $key => $value) {
			$role = Sentinel::findRoleById($value);
	   	    $role->users()->attach($user);
		}

        $this->auditLogger->addLog('User', 'Edit Entry', $userOld->id, $old->toJson(), $user->toJson());

		return redirect( 'user/list' )->with([ 'success' => true,
			'success.message'=> 'User updated successfully!. User account pending for approval',
			'success.title' => 'Good Job!' ]);
	}
}
