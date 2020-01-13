<?php

namespace App\Traits;

use App\Model\Language;

trait LanguageTrait{

	public function language($query, $language)
    {
        return $query->where('language_id', $language);
    }

    public function getLanguage(Request $request){

    	$request_language = $request->server('HTTP_ACCEPT_LANGUAGE');
    	if (strpos($request_language, 'np') !== false) {
    		$lang = 'nep';
    	}else if (strpos($request_language, 'en') !== false) {
    		$lang = 'en';
    	}

    	return Language::where('language', $lang)->first();
    }
}