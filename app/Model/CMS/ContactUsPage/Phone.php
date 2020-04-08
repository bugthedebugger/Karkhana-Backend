<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Phone implements SerializerInterface{
    public $label = null;
    public $phone = null;
    public $mobile = null;

    public function toJson() {
        return ($this->label) ? [
            'label' => $this->label,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->label = $data['label'] ?? null;
        $this->phone = $settings->phone ?? null;
        $this->mobile = $settings->mobile ?? null;
    }

    public static function fromJson($data) {
        return new Phone($data);
    }
}