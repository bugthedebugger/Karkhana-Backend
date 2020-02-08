<?php

/**
 *  Model for Blog's Translations
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    protected $hidden = [
        'language_id',
        'deleted_at',
    ];
	protected $table = 'blogs_translation';
    protected $fillable = [
        'uuid',
        'language_id',
        'title',
        'body',
        'read_time',
    ];

    public function blog() {
        return $this->belongsTo('App\Model\Blog', 'uuid', 'uuid');
    }
}