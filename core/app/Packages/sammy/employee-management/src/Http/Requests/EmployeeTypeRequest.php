<?php
namespace Sammy\EmployeeManage\Http\Requests;

use App\Http\Requests\Request;

class EmployeeTypeRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->id;
        $rules = [
            'name' => 'required|unique:employee_type,name,'.$id,
            'parent' => 'required'
        ];
        return $rules;
    }

}