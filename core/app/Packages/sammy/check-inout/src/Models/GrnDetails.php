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
class GrnDetails extends Model {

	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'grn_details';

	protected $guarded = array('id');


    public function asset()
    {
        return $this->belongsTo('Sammy\AssetManage\Models\Asset', 'asset_id', 'id');
    }
}
