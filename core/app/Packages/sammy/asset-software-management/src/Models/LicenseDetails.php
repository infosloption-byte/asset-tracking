<?php
namespace Sammy\AssetSoftwareManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Status Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class LicenseDetails extends Model {

	/**
     * table row delete
     */
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'software_license_assign';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public function asset()
	{
		return $this->belongsTo('Sammy\AssetManage\Models\Asset', 'asset_id', 'id');
	}

	public function software()
	{
		return $this->belongsTo('Sammy\AssetSoftwareManage\Models\License', 'software_license_id', 'id');
	}

}
