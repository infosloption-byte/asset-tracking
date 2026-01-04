<?php
namespace Sammy\RequestManage\Http\Requests;

use App\Http\Requests\Request;

class RequestManage extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$rules = [];
		return $rules;
	}

}
