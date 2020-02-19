<?php 

/**
 * 
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	protected $fillable = ['resourceable_id', 'resourceable_type', 'resource_type', 'identifier', 'order', 'path'];

	public function resourceable(){
		return $this->morphTo();
	}
}