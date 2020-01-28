<?php

/**
 * 
 */

namespace App\Model;

use App\Model\Section;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $table = 'pages';

	protected $fillable = ['name', 'code', 'description'];

	public function sections(){
		return $this->hasMany(Section::class, 'page_id');
	}
}