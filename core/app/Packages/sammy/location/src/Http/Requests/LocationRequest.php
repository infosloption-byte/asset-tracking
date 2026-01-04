<?php
namespace Sammy\Location\Http\Requests;

use App\Http\Requests\Request;

class LocationRequest extends Request {

	public function authorize() {
		return true;
	}

	public function rules() {
		$id = $this->id;
		$code = $this->code;
		$location = $this->location;
		$email = $this->email;

		$rules=[];

        if($this->is('location/add')){
            $rules = [
                'location' 	=> 'required|unique:location,name,'.$location,
                'code' 		=> 'required|unique:location,code,'.$code,
                'email' 	=> 'email|unique:location,email,'.$email,
                'contact'	=> 'required|min:10|max:10',
            ];
        }else if($this->is('location/edit/'.$id)){
            $rules = [
                'location' 	=> 'required|unique:location,name,'.$id,
                'code' 		=> 'required|unique:location,code,'.$id,
                'email' 	=> 'email|unique:location,email,'.$id,
                'contact'	=> 'required|min:10|max:10'
            ];
        }

        return $rules;
	}

}
