<?php

namespace App\Http\Controllers;
use App\Model\Language;

class LanguageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
        $languages = Language::all();
        foreach($languages as $language) {
            $languageList[] = [
                'name' => $language->name,
                'code' => $language->language,
            ];
        }

        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $languageList,
        ]);
    }
}
