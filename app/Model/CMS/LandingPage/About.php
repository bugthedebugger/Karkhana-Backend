<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;

class About implements SerializerInterface{
    public $text = null;
    public $label = null;
    public $buttonLabel = null;

    public function toJson() {
        return ($this->text) ? [
            'text' => $this->text,
            'label' => $this->label,
            'button_label' => $this->buttonLabel,
        ]: null;
    }

    public function __construct($data) {
        $this->text = $data['text'] ?? null;
        $this->label = $data['label'] ?? null;
        $this->buttonLabel = $data['button_label'] ?? null;
    }

    public static function fromJson($data) {
        return new About($data);
    }
}