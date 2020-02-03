<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;

class Tag extends Model
{
	protected $table = 'tags';

	public function translations() {
		return $this->hasMany('App\Model\TagTranslation');
	}

	public function translate(Language $language) {
		return $this->translations()->where('language_id', $language->id);
	}
}