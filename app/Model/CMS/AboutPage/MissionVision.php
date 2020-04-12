<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;

class MissionVision implements SerializerInterface{
    public $mission = null;
    public $vision = null;

    public function toJson() {
        return [
            'mission' => $this->mission ? $this->mission->toJson() : null,
            'vision' => $this->vision ? $this->vision->toJson() : null,
        ];
    }

    public function __construct($data) {
        $this->mission = Mission::fromJson($data['mission'] ?? null);
        $this->vision = Vision::fromJson($data['vision'] ?? null);
    }

    public static function fromJson($data) {
        return new MissionVision($data);
    }
}