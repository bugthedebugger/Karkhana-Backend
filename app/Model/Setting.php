<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $table = 'settings';

    protected $fillable = [
        'logo',
        'phone',
        'mobile',
        'email',
        'open_hours',
        'open_days',
        'instagram',
        'facebook',
        'youtube',
        'location',
        'geo_location',
        'students_reached',
        'employees',
        'countried_we_work_in',
        'cities_we_work_in',
        'brand_video',
    ];
}