<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\BaseModel;

class Blog extends BaseModel
{
    use SoftDeletes;

	protected $table = 'blogs';
    protected $fillable = [
        'featured',
        'uuid',
        'author',
        'published',
        'slug',
        'has_guest_author',
        'guest_id',
        'facebook_featured',
    ];
    

    public function translations() {
        return $this->hasMany('App\Model\BlogTranslation', 'uuid', 'uuid');
    }

    public function owner() {
        return $this->belongsTo('App\User', 'author', 'id');
    }

    public function tags() {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function hasGuest() {
        return $this->has_guest_author == 1? true: false;
    }

    public function guest() {
        return $this->belongsTo('App\Model\GuestAuthor');
    }
}