<?php

namespace App\Model\CMS;
use App\Model\Language;
use App\Model\Section;
use App\Model\CMS\Header\Header;

class PageModel {
    public $header = null;
    public $language = null;

    public function __construct($data) {
        $this->language = $data['language'] ?? 'en';
        $language = Language::where('language', $this->language)->first();
        $section = Section::where('code', 'header')->first();
        $sectionTranslation = $section->translate($language)->first() ?? null;
        $this->header = Header::fromJson($sectionTranslation->data ?? null);
    }
}