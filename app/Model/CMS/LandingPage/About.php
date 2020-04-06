<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;

class About implements SerializerInterface{
    public $text = null;

    public function toJson() {
        return [
            'text' => $this->text,
        ];
    }

    public function __construct($data) {
        $this->text = $data['text'];
    }

    static public function fromJson($data) {
        return new About($data);
    }
}