<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
class FieldSet extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fieldset';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['device_modal_id', 'name'];

	public function values()
	{
		return $this->hasMany('App\Models\FieldSetValues','fieldset_id');
	}

	public function deviceModal()
	{
		return $this->belongsTo('App\Models\deviceModal','device_modal_id');
	}
}

