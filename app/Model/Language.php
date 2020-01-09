<?php 

/**
 * 
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	
	protected $table = 'languages';

	private $fillable = ['language', 'is_default', 'description'];
}