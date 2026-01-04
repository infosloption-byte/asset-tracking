<?php
namespace Sammy\ServiceTypeManage\Http\Requests;

use App\Http\Requests\Request;

class ServiceTypeRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'name' => 'required'
			];
		return $rules;
	}

}
