<?php
namespace Sammy\AssetSoftwareManage\Http\Requests;

use App\Http\Requests\Request;

class SoftwareTypeRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			'name' => 'required'
		];
		return $rules;
	}
}
