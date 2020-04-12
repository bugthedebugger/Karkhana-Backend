<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Vision implements SerializerInterface{
    public $title = null;
    public $text = null;

    public function toJson() {
        return [
            'title' => $this->title,
            'text' => $this->text,
        ];
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->title = $data['title'] ?? null;
        $this->text = $data['text'] ?? null;
    }

    public static function fromJson($data) {
        return new Vision($data);
    }
}