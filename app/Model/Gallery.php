<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
	protected $table = 'galleries';
    protected $fillable = [
        'uuid',
        'media_type',
        'path',
    ];

    public function blog() {
        return $this->belongsTo('App\Model\Blog', 'uuid', 'uuid');
    }
}