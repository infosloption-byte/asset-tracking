<?php
namespace Sammy\RequestManage\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Request Approve Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class RequestApprove extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	/**
	 * table row delete
	 */
	use SoftDeletes;

	protected $table = 'request_details';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['request_id', 'approved_location_id', 'approved_employee_id', 'status_id', 'approved_date', 'created_at', 'reason'];

	/**
	 * Location
	 * @return object location
	 */
	public function request() {
		return $this->belongsTo('Sammy\RequestManage\Models\RequestDetail', 'request_id', 'id');
	}

	/**
	 * Location
	 * @return object location
	 */
	public function status() {
		return $this->belongsTo('App\Models\RequestStatus', 'status_id', 'id');
	}

	/**
	 * User
	 * @return object employee
	 */
	public function employeeApprove() {
		return $this->belongsTo('Sammy\EmployeeManage\Models\Employee', 'approved_employee_id', 'id');
	}


    public function approve_location() {
        return $this->belongsTo('Sammy\Location\Models\Location', 'approved_location_id', 'id');
    }
}
