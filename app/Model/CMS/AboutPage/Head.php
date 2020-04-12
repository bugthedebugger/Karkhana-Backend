<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Head implements SerializerInterface{
    public $title = null;
    public $sub_text = null;
    public $brand_video = null;

    public function toJson() {
        return [
            'title' => $this->title,
            'sub_text' => $this->sub_text,
            'brand_video' => $this->brand_video,
        ];
    }

    public function __construct($data) {
        $settings = Setting::first();

        $this->title = $data['title'] ?? null;
        $this->sub_text = $data['sub_text'] ?? null;
        $this->brand_video = $settings->brand_video ?? null;
    }

    public static function fromJson($data) {
        return new Head($data);
    }
}