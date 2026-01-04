<?php
namespace Sammy\Location\Models;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Location Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class Location extends Node {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	/**
	 * table row delete
	 */
	use SoftDeletes;

	protected $table = 'location';

	// 'parent_id' column name
	protected $parentColumn = 'parent';

	// 'lft' column name
	protected $leftColumn = 'lft';

	// 'rgt' column name
	protected $rightColumn = 'rgt';

	// 'depth' column name
	protected $depthColumn = 'depth';

	// 
	//protected $orderColumn = 'code';

	// guard attributes from mass-assignment
	protected $guarded = array('id', 'parent', 'lft', 'rgt', 'depth');

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'type', 'code', 'address', 'email', 'contact'];

	/**
	 * Parent Location
	 * @return object parent location
	 */
	public function parentLocation() {
		return $this->belongsTo($this, 'parent', 'id');
	}

    public function parent_loc() {
        return $this->belongsTo($this, 'parent', 'id');
    }

	/**
	 * Type
	 * @return object type
	 */
	public function locationType() {
		return $this->belongsTo('App\Models\LocationType', 'type', 'id');
	}

	/**
	 * Type
	 * @return object type
	 */
	public function locationWithType() {
		return $this->belongsTo('App\Models\LocationType', 'type', 'id');
	}

	/**
	 * Type
	 * @return object type
	 */
	public function leftNode() {
		return $this->hasOne('Sammy\Location\Models\Location', 'parent', 'parent')->where('rgt', '=', $this->lft - 1);
	}

	public function newNestedSetQuery($excludeDeleted = true) {
	    $builder = $this->newQuery($excludeDeleted)->orderBy($this->getQualifiedOrderColumnName())->orderBy($this->getTable().'.code');

	    if ( $this->isScoped() ) {
	      foreach($this->scoped as $scopeFld)
	        $builder->where($scopeFld, '=', $this->$scopeFld);
	    }

		return $builder;
	}

}
