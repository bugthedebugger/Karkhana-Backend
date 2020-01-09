<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

	private $protected = ['name', 'is_admin', 'description'];
}