<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Address implements SerializerInterface{
    public $label = null;
    public $address = null;

    public function toJson() {
        return ($this->label) ? [
            'label' => $this->label,
            'address' => $this->address,
        ]: null;
    }

    public function __construct($data) {
        $settings = Setting::first();
        $this->label = $data['label'] ?? null;
        $this->address = $settings->location ?? null;
    }

    public static function fromJson($data) {
        return new Address($data);
    }
}