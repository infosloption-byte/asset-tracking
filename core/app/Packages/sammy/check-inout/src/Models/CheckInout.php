<?php
namespace Sammy\CheckInout\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CheckInout Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class CheckInout extends Model {

	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'asset_transaction';

	// guard attributes from mass-assignment
	protected $dates = ['deleted_at'];

	protected $guarded = array('id');

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['asset_id', 'status_id', 'location_id', 'user_id'];

}
