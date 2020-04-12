<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\CMS\PageModel;


class AboutPage extends PageModel implements SerializerInterface {
    public $head_section = null;
    public $mission_vision = null;
    public $karkhana_building = null;
    public $values = null;
    public $team = null;

    public function __construct($data) {
        parent::__construct($data);
        $this->head_section = Head::fromJson($data['head_section'] ?? null);
        $this->mission_vision = MissionVision::fromJson($data['mission_vision'] ?? null);
        $this->karkhana_building = KarkhanaBuilding::fromJson($data['karkhana_building'] ?? null);
        $this->values = ValuesList::fromJson($data['values'] ?? null);
        $this->team = Team::fromJson($data['team'] ?? null);
    }

    static public function fromJson($data) {
        return new AboutPage($data);
    }

    public function toJson() {
        return [
            'header' => $this->header ? $this->header->toJson() : null,
            'head_section' => $this->head_section ? $this->head_section->toJson() : null,
            'mission_vision' => $this->mission_vision ? $this->mission_vision->toJson() : null,
            'karkhana_building' => $this->karkhana_building ? $this->karkhana_building->toJson() : null,
            'values' => $this->values ? $this->values->toJson() : null,
            'team' => $this->team ? $this->team->toJson() : null,
            'language' => $this->language,
        ];
    }

}