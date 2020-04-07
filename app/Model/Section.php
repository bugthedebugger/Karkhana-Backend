<?php

/**
 * 
 */

namespace App\Model;

use App\Model\Page;
use App\Model\Resource;
use Illuminate\Database\Eloquent\Model;
use App\Model\BaseModel;

class Section extends BaseModel
{
	protected $table = 'sections';

	protected $fillable = ['code', 'page_id'];

	public function page(){
		return $this->belongsTo(Page::class, 'page_id');
	}

	public function translations(){
		return $this->hasMany(SectionTranslation::class, 'section_id');
	}

	public function resources(){
		return $this->morphMany(Resource::class, 'resourceable');
	}
}