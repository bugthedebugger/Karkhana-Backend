<?php

/**
 *  Model for Blog's Translations
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
	protected $table = 'blogs_translation';
    protected $fillable = [
        'uuid',
        'language_id',
        'title',
        'body',
        'read_time',
    ];
}