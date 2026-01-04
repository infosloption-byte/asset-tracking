<?php

namespace Sammy\PermissionGroups\Http\Requests;

use App\Http\Requests\Request;

use Sammy\EmployeeManage\Models\Employee;

use Sentinel;

class PermissionGroupsRequest extends Request{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        $user = Sentinel::getUser();
        $userType =  Employee::find($user->id)->type;

        if(type == "1"){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'roleName'    => 'required|string',
            'permissions' => 'required|string'
        ];
    }
}
