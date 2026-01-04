<?php
namespace Sammy\AssetModal\Http\Requests;

use App\Http\Requests\Request;

class AssetModalRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$rules = [];
		$modal=$this->asset_modal;
		if($this->is('asset-modal/add')){
            $rules = [
                'asset_modal'       => 'required|unique:asset_modal,name,'.$this->modal,
                'code'              => 'required|unique:asset_modal,code,'.$this->code,
            ];
        }else if($this->is('asset-modal/edit/'.$id)){
            $rules = [
                'asset_modal'       => 'required|unique:asset_modal,name,'.$id,
                'code'              => 'required|unique:asset_modal,code,'.$id,
            ];
        }
		return $rules;
	}

}
