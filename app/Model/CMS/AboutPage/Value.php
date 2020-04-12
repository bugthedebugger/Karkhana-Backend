<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Value implements SerializerInterface{
    public $title = null;
    public $sub_text = null;

    public function toJson() {
        return [
            'title' => $this->title,
            'text' => $this->text,
        ];
    }

    public function __construct($data) {
        $this->title = $data['title'] ?? null;
        $this->text = $data['text'] ?? null;
    }

    public static function fromJson($data) {
        return new Value($data);
    }
}