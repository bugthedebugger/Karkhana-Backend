<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $table = 'tags_translation';
    protected $fillable = [
        'tag_id',
        'language_id',
        'name',
    ];

	public function tag() {
		return $this->belogsTo('App\Model\Tag', 'tag_id', 'id');
    }
}