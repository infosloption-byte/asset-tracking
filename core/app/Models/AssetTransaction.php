<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Classes\SoftDeletes;

/**
 * AssetStatus Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class AssetTransaction extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'asset_transaction';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['asset_id', 'status_id', 'location_type', 'location_id', 'employee_id', 'user_id', 'type', 'checkin_text'];

	public function status()
	{
		return $this->belongsTo('App\Models\Status',"status_id","id");
	}

    public function asset()
	{
		return $this->belongsTo('Sammy\AssetManage\Models\Asset',"asset_id","id");
	}

	public function location()
	{
		return $this->belongsTo('Sammy\Location\Models\Location',"location_id","id");
	}

	public function employee()
	{
		return $this->belongsTo('Sammy\EmployeeManage\Models\Employee',"employee_id","id");
	}

	public function user()
	{
		return $this->belongsTo('Sammy\EmployeeManage\Models\Employee',"user_id","id");
	}
}
