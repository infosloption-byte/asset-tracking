<?php
namespace Sammy\ServiceManage\Models;

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
class Service extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;

    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description','asset_id','service_type_id','cost','completed_date    ','start_date','service_in_date','serviced_by','notes','user_id','created_at', 'updated_at'];
    
    public function asset()
    {
        return $this->belongsTo('Sammy\AssetManage\Models\Asset','asset_id','id');
    }

    public function type()
    {
        return $this->belongsTo('Sammy\ServiceTypeManage\Models\ServiceType','service_type_id','id');
    }
}
