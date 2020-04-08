<?php

namespace App\Model\CMS\LandingPage;

use App\Common\AppUtils;
use App\Model\CMS\SerializerInterface;
use App\Model\CMS\LandingPage\Button;

class Slider implements SerializerInterface {

    public $quote = null;
    public $order = null;
    public $hidden = null;
    public $path = null;
    public $button = null;

    public function toJson() {
        return [
            'quote' => $this->quote,
            'order' => $this->order,
            'hidden' => $this->hidden,
            'path' => $this->path,
            'url' => AppUtils::pathToAWSUrl($this->path),
            'button' => $this->button->toJson(),
        ];
    }

    public function __construct($data) {
        $this->quote = $data['quote'] ?? null;
        $this->order = $data['order'];
        $this->hidden = $data['hidden'];
        $this->path = $data['path'];
        $this->button = Button::fromJson($data['button'] ?? null);
    }

    public static function fromJson($data) {
        return new Slider($data);
    }
}