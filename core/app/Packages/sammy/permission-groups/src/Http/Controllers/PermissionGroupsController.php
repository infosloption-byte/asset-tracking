<?php

namespace Sammy\PermissionGroups\Http\Controllers;

use App\Exceptions\TransactionException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Response;
use Sentinel;
use DB;

use Sammy\Permissions\Models\Permission;
use Sammy\PermissionGroups\Models\PermissionGroup;
use Sammy\UserRoles\Models\UserRole;

class PermissionGroupsController extends Controller{
	
	public function addView(){		
		return view('permissionGroups::add');
	}

    //migrate
	public function addRoleView(Request $request){
		return view('permissionGroups::addRole');
	}

	public function addGroup(Request $request){
		$this->validate($request,[
			'groupName'   => 'required|string',
			'permissions' => 'required'
		]);

		$groupName   = $request->input('groupName');
		$permissions = $request->input('permissions');

		$json        = [];
		foreach ($permissions as $key => $value) {
			$json[$value['name']] = true;
		}


		try{	

			DB::beginTransaction();
			$permissions              = new PermissionGroup;
			$permissions->name        = $groupName;
			$permissions->permissions = json_encode($json);
			$permissions->save();
			if(!$permissions){
				DB::rollback();
				throw new TransactionException('Something wrong.Record wasn\'t updated', 100);
			}
			DB::commit();
		}catch(Exception $e ){
			if ($e->getCode() == 100) {
				return Response::json([0]);
			}
		}
	}

	public function listView(){
		$permissionGroups = PermissionGroup::paginate();
		$count=$permissionGroups->total();
		return view('permissionGroups::list')->with(['data' => $permissionGroups,'row_count'=>$count]);
	}

	public function jsonList(Request $request){
		if($request->ajax()){
			$permissions = Permission::orderBy('name','ASC')->get();
			if($permissions){
				return response()->json(['data' => $permissions]);
			}else{
				return response()->json(['data' => []]);
			}
		}else{
			return response()->json(['data' => []]);
		}
	}

	
    //migrate
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
				$role = new UserRole();
			}
			$role->name              =  $request->input('roleName');
			$role->slug              =  str_slug( $request->input('roleName'));
			$role->created_by        =  $user->id;
			$role->permissions       =  $newPermissionString;
			$role->permission_groups =  $permissionGroups;
			$role->save();
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
		//return view('permissionGroups::addRole');
	}

	public function editRoleView($id){
		$role = UserRole::find($id);
		if($role){

			$permission_groups = explode(',',$role->permission_groups);
            $permissionList = array();

			foreach($permission_groups as $group){
				$permission_group = PermissionGroup::find($group);
                $permission = array('name' => $permission_group->name, 'id' => $permission_group->id);
                array_push($permissionList,$permission);
			}

			return view('permissionGroups::editRole')->with([
				'role'        => $role,
				'permissions' => $permissionList
			]);
		}else{
			return view('errors.404');
		}
	}
}
