<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

	protected $fillable = ['name', 'is_admin', 'description'];

	public function scopeNotAdmin($query) {
		$query->where('is_admin', false);
	}
}