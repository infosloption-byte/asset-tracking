<?php
namespace Sammy\UserManage\Http\Requests;

use App\Http\Requests\Request;
use Input;

class UserRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){    
		if(Input::get('password') != NULL){
			$rules = [
				'emp' => 'exists:employee,id',
				'user_name' 	=> 'required|unique:user,username,'.$this->user_name,
				'password' 		=> 'required|confirmed|min:6|regex:/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*[\W]).{6,})\S$/',
			];
		} else{
			$rules = [
				'emp' 			=> 'exists:employee.id',
				'user_name' 	=> 'required',	
			];
		}
		
		return $rules;
	}

}
