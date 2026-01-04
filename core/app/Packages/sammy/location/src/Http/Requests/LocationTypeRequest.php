<?php
namespace Sammy\Location\Http\Requests;

use App\Http\Requests\Request;

class LocationTypeRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$id = $this->id;
		$name = $this->name;

		$rules=[];

        if($this->is('location/type/add')){
            $rules = [
                'name'  => 'required|unique:location_type,name,'.$name,                
            ];
        }else if($this->is('location/type/edit/'.$id)){
            $rules = [
                'name'  => 'required|unique:location_type,name,'.$id
            ];
        }

        return $rules;
	}

}
