<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;

class Mission implements SerializerInterface{
    public $title = null;
    public $sub_text = null;
    public $text = null;

    public function toJson() {
        return [
            'title' => $this->title,
            'sub_text' => $this->sub_text,
            'text' => $this->text,
        ];
    }

    public function __construct($data) {
        $this->title = $data['title'] ?? null;
        $this->sub_text = $data['sub_text'] ?? null;
        $this->text = $data['text'] ?? null;
    }

    public static function fromJson($data) {
        return new Mission($data);
    }
}