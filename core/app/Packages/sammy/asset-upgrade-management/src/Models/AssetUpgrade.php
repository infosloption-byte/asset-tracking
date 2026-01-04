<?php
namespace Sammy\AssetUpgradeManage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * AssetUpgradeModal Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Sriya <csriyarathne@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class AssetUpgrade extends Model {

	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'asset_upgrade';

	// guard attributes from mass-assignment
	protected $dates = ['deleted_at'];

	protected $guarded = array('id');


	 public function asset()
    {
        return $this->belongsTo('Sammy\AssetManage\Models\Asset', 'upgrade_asset_id', 'id');
    }

    public function mainAsset()
    {
        return $this->belongsTo('Sammy\AssetManage\Models\Asset', 'asset_id', 'id');
    }

}
