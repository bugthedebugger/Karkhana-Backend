<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Common\AppUtils;

class KarkhanaBuilding implements SerializerInterface{
    public $path = null;

    public function toJson() {
        return [
            'path' => $this->path,
            'url' => AppUtils::pathToAWSUrl($this->path),
        ];
    }

    public function __construct($data) {
        $this->path = $data['path'] ?? null;
    }

    public static function fromJson($data) {
        return new KarkhanaBuilding($data);
    }
}