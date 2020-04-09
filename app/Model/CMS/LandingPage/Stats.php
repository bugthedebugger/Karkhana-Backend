<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Stats implements SerializerInterface{
    public $label = null;
    public $value = null;
    public $code = null;

    public function toJson() {
        return $this->label ? [
            'label' => $this->label,
            'value' => $this->value,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();

        $this->label = $data['label'] ?? null;
        $this->code = $data['code'];
        $this->value = $settings[$data['code']] ?? null;
    }

    public static function fromJson($data) {
        return new Stats($data);
    }
}