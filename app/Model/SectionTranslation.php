<?php 

/**
 * 
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
	
	protected $table = 'sections_translations';

	private $fillable = ['title', 'description', 'section_id', 'language_id'];
}