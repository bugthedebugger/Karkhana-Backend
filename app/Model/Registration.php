<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registrations_token';
    
    protected $fillable = [
        'user_id',
        'token',
        'registered',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function scopeUnregistered($query) {
        return $query->where('registered', false);
    }

    public function scopeRegistered($query) {
        return $query->where('registered', true);
    }
}