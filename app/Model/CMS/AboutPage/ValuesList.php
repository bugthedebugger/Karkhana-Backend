<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class ValuesList implements SerializerInterface{
    public $values = null;
    public $title = null;

    public function toJson() {
        $values = null;

        if($this->values) {
            foreach($this->values as $value) {
                $values[] = $value->toJson();
            }
        }

        return [
            'title' => $this->title,
            'values' => $values,
        ];
    }

    public function __construct($data) {
        $this->title = $data['title'] ?? null;
        $values = null;
        $dataFromSource = $data['values'] ?? null;
        if($dataFromSource) {
            foreach($data['values'] as $value) {
                $values[] = Value::fromJson($value);
            }
        }
        $this->values = $values;
    }

    public static function fromJson($data) {
        return new ValuesList($data);
    }
}