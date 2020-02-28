<?php

/**
 * Stores if database seed has been executed or not. 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;

class SeedInformation extends Model
{
	protected $table = 'seed_information';
    protected $fillable = ['name'];
}