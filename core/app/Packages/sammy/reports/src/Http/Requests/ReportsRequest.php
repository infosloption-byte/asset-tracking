<?php
namespace Sammy\Reports\Http\Requests;

use App\Http\Requests\Request;

class ReportRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
		];
		return $rules;
	}
}
