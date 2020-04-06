<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;

class Button implements SerializerInterface{
    public $label = null;
    public $action = null;

    public function toJson() {
        return [
            'label' => $this->label,
            'action' => $this->action,
        ];
    }

    public function __construct($data) {
        $this->label = $data['label'];
        $this->action = $data['action'];
    }

    static public function fromJson($data) {
        return new Button($data);
    }
}