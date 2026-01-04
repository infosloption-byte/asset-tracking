<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * FieldSet Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class FieldSetValues extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'device_fieldset_values';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['device_id','fieldset_id', 'value','created_at','updated_at'];

	public function device()
	{
		return $this->belongsTo('App\Models\Devices','device_id','id');
	}

	public function fieldSet()
	{
		return $this->belongsTo('App\Models\FieldSet','fieldset_id','id');
	}
}
