<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;
use App\Model\BaseModel;

class Tag extends BaseModel
{
	protected $table = 'tags';

	public function translations() {
		return $this->hasMany('App\Model\TagTranslation');
	}

	public function blogs() {
		return $this->belongsToMany('App\Model\Blog');
	}
}