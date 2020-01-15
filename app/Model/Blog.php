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
}