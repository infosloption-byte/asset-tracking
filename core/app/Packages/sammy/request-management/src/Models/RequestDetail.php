<?php
namespace Sammy\RequestManage\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Request Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class RequestDetail extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	/**
	 * table row delete
	 */
	use SoftDeletes;

	protected $table = 'request';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['send_by', 'request_type_id', 'asset_type_id', 'quantity', 'approved_quantity', 'asset_no', 'remark', 'status', 'service_status','reason'];

	/**
	 * Location
	 * @return object location
	 */
	public function RequestType() {
		return $this->belongsTo('App\Models\RequestType', 'request_type_id', 'id');
	}

	/**
	 * Location
	 * @return object location
	 */
	public function requestStatus() {
		return $this->belongsTo('App\Models\RequestStatus', 'status', 'id');
	}

	/**
	 * User
	 * @return object employee
	 */
	public function employee() {
		return $this->belongsTo('Sammy\EmployeeManage\Models\Employee', 'send_by', 'id');
	}

	/**
	 * User
	 * @return object employee
	 */
	public function employeeApprove() {
		return $this->hasMany('Sammy\RequestManage\Models\RequestApprove', 'request_id', 'id')->orderBy('created_at','desc');
	}

    public function employeeApproveLatest() {
        return $this->hasOne('Sammy\RequestManage\Models\RequestApprove', 'request_id', 'id')->orderBy('created_at','desc');
    }

    public function detail() {
        return $this->hasOne('Sammy\RequestManage\Models\RequestApprove', 'request_id', 'id')->whereNotNull('approved_date');
    }

	/**
	 * Asset
	 * @return object asset
	 */
	public function asset() {
		return $this->belongsTo('Sammy\AssetManage\Models\Asset', 'asset_no', 'asset_no');
	}

	/**
	 * Asset
	 * @return object asset
	 */
	public function requestModal() {
		return $this->belongsTo('Sammy\AssetModal\Models\AssetModal', 'asset_type_id', 'id');
	}

}
