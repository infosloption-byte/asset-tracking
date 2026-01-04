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
class License extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'software_license';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];


    public function details()
    {
        return $this->hasMany('Sammy\AssetSoftwareManage\Models\LicenseDetails','software_license_id');
    }

    public function supplier() {
		return $this->belongsTo('Sammy\SupplierManage\Models\Supplier', 'supplier_id', 'id');
	}

	public function manufacture() {
		return $this->belongsTo('Sammy\ManufacturerManage\Models\Manufacturer', 'manufacture_id', 'id');
	}

	public function category() {
		return $this->belongsTo('Sammy\AssetSoftwareManage\Models\SoftwareType', 'category_id', 'id');
	}
}
