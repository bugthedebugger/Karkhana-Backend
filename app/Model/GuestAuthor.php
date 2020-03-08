<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;

class GuestAuthor extends Model
{
	protected $table = 'guest_author';
    protected $fillable = [
        'name',
        'email',
        'bio', 
        'avatar',
        'linkedin',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
    ];

    public function blogs() {
        return $this->hasMany('App\Model\Blog');
    }
}