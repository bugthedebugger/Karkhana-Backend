<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
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
    ];
    

    public function translations() {
        return $this->hasMany('App\Model\BlogTranslation', 'uuid', 'uuid');
    }

    public function translate(Language $language) {
        return $this->translations()->where('language_id', $language->id);
    }

    public function owner() {
        return $this->belongsTo('App\User', 'author', 'id');
    }

    public function tags() {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function hasGuest() {
        return $this->has_guest_author;
    }

    public function guest() {
        return $this->belongsTo('App\Model\GuestAuthor');
    }
}