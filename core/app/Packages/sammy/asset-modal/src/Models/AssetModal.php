<?php
namespace Sammy\AssetModal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AssetModal Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class AssetModal extends Model {

	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'asset_modal';

	// guard attributes from mass-assignment
	protected $dates = ['deleted_at'];

	protected $guarded = array('id');

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['category_id', 'name', 'code', 'status'];

	public function assetModalByCategory() {
		return $this->belongsTo('App\Models\Category', 'category_id', 'id');
	}

	public function deviceModalByAssetModal() {
		return $this->hasMany('App\Models\DeviceModal', 'asset_modal_id', 'id');
	}


	public function deviceModels(){
		return $this->hasMany('App\Models\DeviceModal');
	}

}
