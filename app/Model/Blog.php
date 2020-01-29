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

    public function allTranslations() {
        return $this->hasMany('App\Model\BlogTranslation', 'uuid', 'uuid');
    }

    public function translation($language) {
        // TODO: Should return translated texts
    }
}