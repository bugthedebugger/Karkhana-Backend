<?php 

/**
 * 
 */
namespace App\Model;

use App\Model\Section;
use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
	use LanguageTrait;
	protected $table = 'sections_translations';

	protected $fillable = ['title', 'description', 'section_id', 'language_id'];

	public function section(){
		return $this->belongsTo(Section::class, 'section_id');
	}
}