<?php
namespace Sammy\ManufacturerManage\Http\Requests;

use App\Http\Requests\Request;

class ManufacturerRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$id = $this->id;
        // $repID = $this->uID;
        if($this->is('manufacturer/add')){
            $rules = [
                'name' => 'required|unique:manufacturers,name,'.$this->name,
            ];
        }else if($this->is('manufacturer/edit/'.$id)){
            $rules = [
                'name' => 'required|unique:manufacturers,name,'.$id,
            ];
        }
		return $rules;
	}

}
