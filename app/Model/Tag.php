<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';

	public function allTranslations() {
		return $this->hasMany('App\Model\TagTranslation');
	}

	public function translation($languages) {
		// TODO: Should return translated texts
	}
}