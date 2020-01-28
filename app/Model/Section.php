<?php

/**
 * 
 */

namespace App\Model;

use App\Model\Page;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $table = 'sections';

	protected $fillable = ['code'];

	public function page(){
		return $this->belongsTo(Page::class, 'page_id');
	}

	public function translations(){
		return $this->hasMany(SectionTranslation::class, 'section_id');
	}
}