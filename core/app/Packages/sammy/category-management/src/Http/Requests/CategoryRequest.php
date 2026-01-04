<?php
namespace Sammy\CategoryManage\Http\Requests;

use App\Http\Requests\Request;

class CategoryRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$id = $this->id;
        // $repID = $this->uID;
        if($this->is('category/add')){
            $rules = [
                'name'    	=> 'required|unique:category,name,'.$this->name,
            ];
        }else if($this->is('category/edit/'.$id)){
            $rules = [
                'name'    	=> 'required|unique:category,name,'.$id,
            ];
        };
		return $rules;
	}

}
