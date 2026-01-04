<?php
namespace Sammy\UserRoles\Http\Controllers;

use Sammy\Permissions\Models\Permission;
use Sammy\UserRoles\Models\UserRole;

use App\Http\Controllers\Controller;
use Sammy\UserRoles\Http\Requests\UserRoleRequest;
use Sammy\PermissionGroups\Models\PermissionGroup;

use Illuminate\Http\Request;
use Response;
use Sentinel;
use Carbon\Carbon;
use DB;
use App\Exceptions\TransactionException;

class UserRoleController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| User Role Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the user role add screen to the user.
	 *
	 * @return Response
	 */
	public function addView(){
		return view( 'userRoles::role.add' );
	}

	/**
	 * Add new role data to database
	 *
	 * @return Redirect to role add
	 */
	public function add(Request $request)
	{
		$this->validate($request,[
			'permissions' => 'required',
			'roleName'    => 'required|string'
		]);

		$permissionGroups = $request->input('permissions');

		$per_ids = array_column($permissionGroups, 'id');

		try{
			DB::beginTransaction();
			$user = Sentinel::getUser();
			$permissions = [];

			foreach ($permissionGroups as $key => $value) {
				foreach (json_decode($value['permissions']) as $key => $aa) {
					$permissions[$key] = $aa;
				}
			}

			$role  = UserRole::where('name',$request->input('roleName'))->first();
			if(!$role){
				$role          =  new UserRole();
			}
			$role->name        =  $request->input('roleName');
			$role->slug        =  str_slug( $request->input('roleName'));			
			$role->created_by  =  $user->id;
			$role->permissions =  json_encode($permissions);
			$role->save();


			$role->groups()->attach($per_ids);

			if(!$role){
				DB::rollback();
				throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
			}
			DB::commit();

		}catch(TransactionException $e){
			if ($e->getCode() == 100) {
				return Response::json([0]);
			}
		}catch(Exception $e){
			return Response::json([0]);
		}
	}

	/**
	 * Show the roles list screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{	
		$data = UserRole::with('groups')->paginate(20);
		$count=$data->total();
		return view( 'userRoles::role.list')->with(['data'=>$data,'row_count'=>$count]);
	}

	

	/**
	 * Delete a User Role
	 * @param  Request $request role id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$role = UserRole::find($id);
			if($role){
				$role->delete();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Delete a User Role
	 * @param  Request $request role id
	 * @return Json           	json object with status of success or failure
	 */
	public function groupsJsonList(Request $request)
	{
		if($request->ajax()){
			$groups = PermissionGroup::orderBy('name','ASC')->get();
			if($groups){
				return response()->json(['data' => $groups]);
			}else{
				return response()->json(['data' => []]);
			}
		}else{
			return response()->json(['data' => []]);
		}
	}

	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{
		$role = UserRole::find($id);
		if($role){
			return view('userRoles::role.edit')->with(['role' => $role]);
		}else{
			return view('errors.404');
		}
	}

	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function editPerJson(Request $request)
	{
		$role = UserRole::with('groups')->find($request->id);
		if($role){
			$permissionList = array();
			if($role->groups!=null){
				$ids = $role->groups->lists('id');				
				$permissionList = PermissionGroup::whereIn('id',$ids)->get();
			}
			return Response::json(['data' => $permissionList]);
		}else{
			return Response::json(['data' => []]);
		}
	}

	/**
	 * Delete a User Role
	 * @param  Request $request role id
	 * @return Json           	json object with status of success or failure
	 */
	public function groupsEditJsonList(Request $request)
	{
		if($request->ajax()){
			$role = UserRole::with('groups')->find($request->id);
			if($role){
				if($role->groups!=null){
					$ids = $role->groups->lists('id');						
					$groups = PermissionGroup::whereNotIn('id',$ids)->get();
				}	
				if($groups){
					return response()->json(['data' => $groups]);
				}else{
					return response()->json(['data' => []]);
				}
			}
		}else{
			return response()->json(['data' => []]);
		}
	}

	/**
	 * edit role data to database
	 *
	 * @return Redirect to roles list
	 */
	public function edit(Request $request, $id)
	{
		$this->validate($request,[
			'permissions' => 'required',
			'roleName'    => 'required|string'
		]);

		$permissionGroups = $request->input('permissions');

		$per_ids = array_column($permissionGroups, 'id');

		try{
			DB::beginTransaction();
			$user = Sentinel::getUser();
			$permissions = [];

			foreach ($permissionGroups as $key => $value) {
				foreach (json_decode($value['permissions']) as $key => $aa) {
					$permissions[$key] = $aa;
				}
			}

			$role  = UserRole::find($id);
			if(!$role){
				throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
			}
			$role->name        =  $request->input('roleName');
			$role->slug        =  str_slug( $request->input('roleName'));			
			$role->created_by  =  $user->id;
			$role->permissions =  json_encode($permissions);
			$role->save();

			$role->groups()->detach();
			$role->groups()->attach($per_ids);

			if(!$role){
				DB::rollback();
				throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
			}
			DB::commit();

		}catch(TransactionException $e){
			if ($e->getCode() == 100) {
				return Response::json([0]);
			}
		}catch(Exception $e){
			return Response::json([0]);
		}

		
	}

	public function addRole(Request $request){
		$this->validate($request,[
			'permissions' => 'required',
			'roleName'    => 'required|string'
		]);
		$permissionGroups = $request->input('permissions');

		try{
			DB::beginTransaction();
			$user = Sentinel::getUser();
			$data = DB::select(DB::raw("select permissions from permission_groups where id in (".$permissionGroups.")"));
			$permissionString = "{";
			foreach($data as $permission){
				$permissionString .= $permission->permissions;
			}
			$newPermissionString = rtrim($permissionString ,',');
			$newPermissionString .= "}";

			$role  = UserRole::where('name',$request->input('roleName'))->first();
			if(!$role){
				$role          =  new UserRole();
			}
			$role->name        =  $request->input('roleName');
			$role->slug        =  str_slug( $request->input('roleName'));
			$role->created_by  =  $user->id;
			$role->permissions =  $newPermissionString;
			$role->save();
			if(!$role){
				throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
				DB::rollback();
			}
			DB::commit();

		}catch(TransactionException $e){
			if ($e->getCode() == 100) {
				return Response::json([0]);
			}
		}catch(Exception $e){
			return Response::json([0]);
		}
	}

	public function addRoleView(Request $request){
		return view('permissionGroups::addRole');
	}

	public function groupsApi(){
		$permissionGroups = PermissionGroup::select('name','id')->get(['name','id']);
		if(count($permissionGroups) > 0 ){
			return Response::json($permissionGroups);
		}
		return Response::json();
	}
}
