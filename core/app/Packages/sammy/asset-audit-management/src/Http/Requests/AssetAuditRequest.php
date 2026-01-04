<?php
namespace Sammy\AuditManage\Http\Requests;

use App\Http\Requests\Request;

class AssetAuditRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$rules = [];
		return $rules;
	}

}
