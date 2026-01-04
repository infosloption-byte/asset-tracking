<?php
namespace Sammy\EmployeeManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDesignation extends Model
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
    protected $table = 'employee_designation';

    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are assignable.
     *
     * @var array
     */
    public $fillable = ['employee_id', 'type_id', 'created_at', 'updated_at'];

    /**
     * Parent Employee Type
     * @return object parent
     */
    public function designation()
    {
        return $this->belongsTo('Sammy\EmployeeManage\Models\EmployeeType','type_id','id');
    }

    /**
     * Parent Employee Type
     * @return object parent
     */
    public function employee()
    {
        return $this->belongsTo('Sammy\EmployeeManage\Models\Employee','employee_id','id');
    }

}