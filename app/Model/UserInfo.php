<?php

/**
 * Model for User Information table
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserInfo extends Model
{
	protected $table = 'user_information';

	protected $fillable = [
        'user_id', 
        'bio', 
        'avatar',
        'linkedin',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}