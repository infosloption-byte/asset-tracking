<?php
namespace Sammy\AssetUpgradeManage\Http\Requests;

use App\Http\Requests\Request;

class AssetUpgradeRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$rules = ['asset'=>'required'];
		return $rules;
	}

}
