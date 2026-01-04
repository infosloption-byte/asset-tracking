<?php
namespace Sammy\ServiceManage\Http\Requests;

use App\Http\Requests\Request;

class BarcodeRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'description'    => 'required',
			'type'           => 'required |exists:service_type,id',
			'asset'          => 'required |exists:asset,id',
			'cost'           => 'required',
			'completed_date' => 'required',
			'serviced_by'    => 'required'
		];
		return $rules;
	}

}
