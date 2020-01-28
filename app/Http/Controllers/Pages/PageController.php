<?php

/**
 *
 */
namespace App\Http\Controllers\Pages;

use App\User;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Traits\LanguageTrait;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	use LanguageTrait;
    public function index(Request $request, $page)
    {
    	$page = Page::where('code', $page)->first();

    	$language = $this->getLanguage($request);

    	$sections = $page->sections->translations()->languageOfType($language);
    }
}
