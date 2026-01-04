<?php
namespace Sammy\AssetSoftwareManage\Http\Requests;

use App\Http\Requests\Request;

class SoftwareAssetRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'name'         => 'required',
			'period'       => 'required | integer | min:0',
			'manufacturer' => 'required | exists:manufacturers,id',
			'supplier'     => 'required | exists:suppliers,id',
			'category'     => 'required',
			'from'         => 'required'
		];
		return $rules;
	}

}
