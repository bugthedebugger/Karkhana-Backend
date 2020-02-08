<?php 

/**
 * 
 */
namespace App\Model;

use App\Model\Section;
use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
	protected $table = 'sections_translations';

	protected $fillable = ['title', 'data', 'section_id', 'language_id'];

	protected $casts = [
		'data' => 'array'
	];

	public function section(){
		return $this->belongsTo(Section::class, 'section_id');
	}
}