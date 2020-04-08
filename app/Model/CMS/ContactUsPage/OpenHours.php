<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class OpenHours implements SerializerInterface{
    public $label = null;
    public $open_hours = null;

    public function toJson() {
        return ($this->label) ? [
            'label' => $this->label,
            'open_hours' => $this->open_hours,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->label = $data['label'] ?? null;
        $this->open_hours = $settings->open_hours ?? null;
    }

    public static function fromJson($data) {
        return new OpenHours($data);
    }
}