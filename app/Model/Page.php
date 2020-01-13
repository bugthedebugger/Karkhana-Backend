<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	use LanguageTrait;

	protected $table = 'pages';

	private $protected = ['name', 'code', 'description'];
}