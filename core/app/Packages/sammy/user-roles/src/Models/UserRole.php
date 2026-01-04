<?php
namespace Sammy\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserRole Model Class
 *
 *
 * @category   Models
 * @package    Model
 * @author     Yasith Samarawickrama <yazith11@gmail.com>
 * @copyright  Copyright (c) 2015, Yasith Samarawickrama
 * @version    v1.0.0
 */
class UserRole extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'permissions', 'created_by', 'created_at', 'updated_at'];


	/**
	 * User
	 * @return object employee
	 */
	public function groups() {
		return $this->belongsToMany('Sammy\PermissionGroups\Models\PermissionGroup', 'role_groups');
	}
}
