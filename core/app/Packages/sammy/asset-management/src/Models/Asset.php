<?php
namespace Sammy\AssetManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Manufacturers Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class Asset extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	use SoftDeletes;

	protected $table = 'asset';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'inventory_no',
		'description',
		'make',
		'model',
		'asset_no',
		'asset_model_id',
		'location',
		'supplier_id',
		'status',
		'account_code',
		'po_number',
		'scrap_value',
		'purchased_value',
		'purchased_date',
		'warranty_from',
		'warranty_to',
		'warranty_period',
		'recovery_period',
		'depreciation_id',
		'user_id',
		'manual_no'];

	public function devices() {
		return $this->hasMany('App\Models\Devices');
	}

	public function device() {
		return $this->belongsTo('App\Models\Devices','id','asset_id');
	}

	public function manufacturer() {
		return $this->belongsTo('Sammy\ManufacturerManage\Models\Manufacturer', 'make', 'id');
	}

	public function manufacturerName() {
		return $this->belongsTo('Sammy\ManufacturerManage\Models\Manufacturer', 'make', 'id')->select(['id', 'name']);
	}

	public function depreciationtype() {
		return $this->belongsTo('Sammy\AssetManage\Models\DepreciationType', 'depreciation_id', 'id');
	}

	public function assetmodel() {
		return $this->belongsTo('Sammy\AssetModal\Models\AssetModal', 'asset_model_id', 'id');
	}

	public function supplier() {
		return $this->belongsTo('Sammy\SupplierManage\Models\Supplier', 'supplier_id', 'id');
	}

	public function supplierName() {
		return $this->belongsTo('Sammy\SupplierManage\Models\Supplier', 'supplier_id', 'id')->select(['id', 'name']);
	}

    public function transactions()
    {
        return $this->hasMany('App\Models\AssetTransaction')->withTrashed();
    }

    public function transaction()
    {
        return $this->hasMany('App\Models\AssetTransaction');
    }

    public function assetTransaction()
    {
        return $this->hasOne('App\Models\AssetTransaction','asset_id','id')->whereNull('deleted_at');
    }


    public function status()
    {
        return $this->belongsTo('Sammy\AssetModal\Models\AssetStatus', 'asset_id', 'id');
    }


    public function services()
    {
        return $this->hasMany('Sammy\ServiceManage\Models\Service');
    }

    public function barcode()
    {
        return $this->belongsTo('App\Models\AssetBarcode','id','asset_id');
    }

    public function upgrade()
    {
        return $this->hasMany('Sammy\AssetUpgradeManage\Models\AssetUpgrade','asset_id')->whereNull('ended_at');
    }


    public function upgradehistory()
    {
        return $this->hasMany('Sammy\AssetUpgradeManage\Models\AssetUpgrade','asset_id')->whereNull('ended_at');
    }

    public function upgradewithtrash()
    {
        return $this->hasMany('Sammy\AssetUpgradeManage\Models\AssetUpgrade','upgrade_asset_id');
    }

}
