<?php
namespace Sammy\AssetManage\Http\Requests;

use App\Http\Requests\Request;

class AssetRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'asset_no'        => 'required | unique:asset,asset_no,'.$this->asset_no,
			'manual_no'        => 'unique:asset,manual_no,'.$this->manual_no,
			// 'inventory_no'        => 'required | unique:asset,inventory_no,'.$this->inventory_no,
			'purchased_date' => 'required',
			'purchased_value' => 'required',
			'warranty_from'   => 'required',
			'recovery_period' => 'required'
		];
		return $rules;
	}

}
