<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Email implements SerializerInterface{
    public $label = null;
    public $email = null;

    public function toJson() {
        return ($this->label) ? [
            'label' => $this->label,
            'email' => $this->email,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->label = $data['label'] ?? null;
        $this->email = $settings->email ?? null;
    }

    public static function fromJson($data) {
        return new Email($data);
    }
}