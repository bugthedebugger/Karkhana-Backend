<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;
use App\Model\BaseModel;

class Team extends Model
{
	protected $table = 'teams';
    protected $fillable = [
        'name',
        'bio',
        'post',
        'photo',
        'facebook',
        'twitter',
        'instagram',
        'email',
    ];
}