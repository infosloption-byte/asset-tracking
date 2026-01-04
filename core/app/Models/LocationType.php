<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * LocationType Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class LocationType extends Model {
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'location_type';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'status'];

	// /**
 //     * Parent Employee Type
 //     * @return object parent
 //     */
 //    public function parentType()
 //    {
 //        return $this->belongsTo($this,'parent','id');
 //    }

 //    /**
 //     * Parent Employee Type
 //     * @return object parent
 //     */
 //    public function getParent($id)
 //    {
 //        return $this::find($id);
 //    }
}
