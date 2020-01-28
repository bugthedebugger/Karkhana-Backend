<?php 

/**
 * 
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	
	protected $table = 'languages';

	protected $fillable = ['language', 'is_default', 'description'];
}