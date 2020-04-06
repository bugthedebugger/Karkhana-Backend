<?php

/**
 * 
 */

namespace App\Model;

use App\Model\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;
    
	protected $table = 'partners';

	protected $fillable = ['name', 'logo', 'description'];
}