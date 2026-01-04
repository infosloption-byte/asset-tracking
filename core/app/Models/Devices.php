<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * DeviceModal Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class Devices extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'devices';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['asset_id','device_model_id'];

	
	public function models()
	{
	 	return $this->hasMany('App\Models\DeviceModal','device_model_id','id');
	}

	public function FieldValues()
	{
	 	return $this->hasMany('App\Models\FieldSetValues','device_id','id')->whereNull('deleted_at');
	}


}
