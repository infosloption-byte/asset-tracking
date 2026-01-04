<?php
namespace Sammy\EmployeeManage\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Employee extends Node
{
    /**
     * table row delete
     */
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'parent', 'lft', 'rgt', 'depth'];

    // 'parent_id' column name
    protected $parentColumn = 'parent';

    // 'lft' column name
    protected $leftColumn = 'lft';

    // 'rgt' column name
    protected $rightColumn = 'rgt';

    // 'depth' column name
    protected $depthColumn = 'depth';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * get employee type each employee
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function type()
    {
        return $this->belongsTo('Sammy\EmployeeManage\Models\EmployeeType','employee_type_id','id');
    }

    /**
     * Parent Employee
     * @return object parent employee
     */
    public function parentEmployee()
    {
        return $this->belongsTo($this,'parent','id');
    }

    public function user()
    {
        return $this->hasOne('Sammy\UserManage\Models\User', 'employee_id','id');
    }

    /**
     * Employee Location
     * @return object Location
     */
    public function Location()
    {
        return $this->belongsTo('Sammy\Location\Models\EmployeeLocation','id','employee_id');
    }


    public function employee_location(){
        return $this->belongsTo('Sammy\Location\Models\EmployeeLocation','id','employee_id')->whereNull('deleted_at');
    }

    /**
     * get full name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * @param $query
     * @return mixed query
     */
    public function scopeOfType($query, $type)
    {
        return $query->where4ever_employee_type_id($type);
    }

    /**
     * @param $query
     * @return mixed query
     */
    public function userRole()
    {
        return $this->belongsTo('Sammy\UserManage\Models\User','id','employee_id');
    }

    /**
     * get employee verified user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verifiedby()
    {

        return $this->belongsTo('Sammy\EmployeeManage\Models\Employee','varified_by','id');
    }

    /**
     * get employee verified user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdBy()
    {

        return $this->belongsTo('Sammy\UserManage\Models\User','created_by','id');
    }

}