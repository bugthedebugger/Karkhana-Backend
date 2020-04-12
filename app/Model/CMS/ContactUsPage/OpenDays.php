<?php

namespace App\Model\CMS\ContactUsPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class OpenDays implements SerializerInterface{
    public $label = null;
    public $open_days = null;

    public function toJson() {
        return ($this->label) ? [
            'label' => $this->label,
            'open_days' => $this->open_days,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->label = $data['label'] ?? null;
        $this->open_days = $settings->open_days ?? null;
    }

    public static function fromJson($data) {
        return new OpenDays($data);
    }
}