<?php
namespace Sammy\Location\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Employee Location Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class EmployeeLocation extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	/**
	 * table row delete
	 */
	use SoftDeletes;

	protected $table = 'user_location';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['location_id', 'employee_id'];

	/**
	 * Location
	 * @return object location
	 */
	public function location() {
		return $this->belongsTo('Sammy\Location\Models\Location', 'location_id', 'id');
	}

	/**
	 * Type
	 * @return object type
	 */
	public function employee() {
		return $this->belongsTo('Sammy\EmployeeManage\Models\Employee', 'employee_id', 'id');
	}

}
