<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;

class Team implements SerializerInterface{
    public $title = null;
    public $sub_title = null;
    public $sub_text = null;
    public $text = null;
    public $employees = null;
    public $team_photo = null;

    public function toJson() {
        return [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'sub_text' => $this->sub_text,
            'text' => $this->text,
            'employees' => $this->employees ? $this->employees->toJson() : null,
            'team_photo' => $this->team_photo ? $this->team_photo->toJson() : null,
        ];
    }

    public function __construct($data) {
        $settings = Setting::first();

        $this->title = $data['title'] ?? null;
        $this->sub_text = $data['sub_text'] ?? null;
        $this->sub_title = $data['sub_title'] ?? null;
        $this->text = $data['text'] ?? null;
        $this->team_photo = TeamPhoto::fromJson($data['team_photo'] ?? null);
        $this->employees = Employees::fromJson($data['employees'] ?? null);
    }

    public static function fromJson($data) {
        return new Team($data);
    }
}