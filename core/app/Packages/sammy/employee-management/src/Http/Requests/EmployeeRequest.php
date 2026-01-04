<?php
namespace Sammy\EmployeeManage\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends Request
{
    public function authorize(){
        return true;
    }

    public function rules(){
        $id = $this->id;
        // $repID = $this->uID;
        if($this->is('employee/add')){
            $rules = [
                'email'             => 'email|unique:employee,email,'.$this->email,
                'code'              => 'required|unique:employee,code,NULL,id,varified_status,1',
                'mobile'            => 'required|min:10|max:10',
                'nic'               => 'required|unique:employee,nic,NULL,id,varified_status,1',
            ];
        }else if($this->is('employee/edit/'.$id)){
            $rules = [
                'email'             => 'email|unique:employee,email,'.$id,
                'mobile'            => 'required|min:10|max:10',
            ];
        }else if($this->is('employee/reset/reset-password')){
            $rules = [
                'user_name'         => 'unique:user,username,'.$id,
                'uName'             => 'unique:dealer,username,'.$id,
                'mobile'            => 'required|min:10|max:10',
                'password'          => 'required|min:6|regex:/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*[\W]).{6,})\S$/',
                'confirm_password'  => 'required|same:password'
            ];
        }
        return $rules;
    }

}