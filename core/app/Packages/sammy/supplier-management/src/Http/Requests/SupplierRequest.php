<?php
namespace Sammy\SupplierManage\Http\Requests;

use App\Http\Requests\Request;

class SupplierRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){

		$id = $this->id;
        // $repID = $this->uID;
        if($this->is('supplier/add')){
            $rules = [
                'supplier_name'    	=> 'required|unique:suppliers,name,'.$this->supplier_name,
				'supplier_address' 	=> 'required',
				'city'             	=> 'required',
				'country'          	=> 'required',
				'supplier_phone'   	=> 'required|min:10|max:10|unique:suppliers,phone,'.$this->supplier_phone,
				'supplier_fax'   	=> 'required|min:10|max:10|unique:suppliers,fax,'.$this->supplier_fax,
				'supplier_email'   	=> 'required|email|unique:suppliers,email,'.$this->supplier_email,
            ];
        }else if($this->is('supllier/edit/'.$id)){
            $rules = [
                'supplier_name'    	=> 'required|unique:suppliers,name,'.$id,
				'supplier_address' 	=> 'required',
				'city'             	=> 'required',
				'country'          	=> 'required',
				'supplier_phone'   	=> 'required|min:10|max:10|unique:suppliers,phone,'.$id,
				'supplier_fax'   	=> 'required|min:10|max:10|unique:suppliers,fax,'.$id,
				'supplier_email'   	=> 'required|email|unique:suppliers,email,'.$id,
            ];
        }
        return $rules;
	}
}
