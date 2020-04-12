<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Employees implements SerializerInterface{
    public $label = null;
    public $count = null;

    public function toJson() {
        return [
            'label' => $this->label,
            'count' => $this->count,
        ];
    }

    public function __construct($data) {
        $settings = Setting::first();

        $this->label = $data['label'] ?? null;
        $this->count = $settings->employees ?? null;
    }

    public static function fromJson($data) {
        return new Employees($data);
    }
}