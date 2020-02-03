<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $table = 'blogs';
    protected $fillable = [
        'featured',
        'uuid',
        'author',
        'published',
    ];

    public function translations() {
        return $this->hasMany('App\Model\BlogTranslation', 'uuid', 'uuid');
    }

    public function translate(Language $language) {
        return $this->translations()->where('language_id', $language->id);
    }
}