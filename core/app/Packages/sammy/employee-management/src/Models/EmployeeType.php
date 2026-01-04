<?php
namespace Sammy\EmployeeManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
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
    protected $table = 'employee_type';

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
    public $fillable = ['name', 'parent', 'updated_at', 'created_at'];

    /**
     * Parent Employee Type
     * @return object parent
     */
    public function parentType()
    {
        return $this->belongsTo($this,'parent','id');
    }

    /**
     * Parent
     * @return object parent
     */
    public function parent()
    {
        return $this->belongsTo($this,'parent','id');
    }

    /**
     * Parent Employee Type
     * @return object parent
     */
    public function getParent($id)
    {
        return $this::find($id);
    }

}