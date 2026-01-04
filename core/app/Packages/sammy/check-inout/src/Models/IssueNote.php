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
class IssueNote extends Model {

	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	protected $table = 'issue_notes';

	protected $guarded = array('id');

    public function fromlocation()
    {
        return $this->belongsTo('Sammy\Location\Models\Location', 'from_location_id', 'id');
    }

    public function tolocation()
    {
        return $this->belongsTo('Sammy\Location\Models\Location', 'to_location_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo('Sammy\EmployeeManage\Models\Employee', 'user_id', 'id');
    }

    public function grn()
    {
        return $this->belongsTo('Sammy\CheckInout\Models\Grn','id','issue_note_id');
    }

    public function details()
    {
        return $this->hasMany('Sammy\CheckInout\Models\IssueNoteDetails');
    }

    public function detailsWithoutUpgrade()
    {
        return $this->hasMany('Sammy\CheckInout\Models\IssueNoteDetails')
            ->whereNotIn('asset_id',function($query){
                $query->from('asset_upgrade')->select('upgrade_asset_id');
            });
    }

    public function rejectDetails()
    {
        return $this->hasMany('Sammy\CheckInout\Models\IssueNoteDetails')->where('status',2)
            ->whereNotIn('asset_id',function($query){
                $query->from('asset_upgrade')->select('upgrade_asset_id');
            });
    }
}
