<?php
namespace Sammy\CheckInout\Http\Requests;

use App\Http\Requests\Request;

class CheckInoutRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$rules = [];
		return $rules;
	}

}
