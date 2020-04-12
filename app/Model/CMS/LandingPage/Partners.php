<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Common\AppUtils;
use App\Model\Partner;

class Partners implements SerializerInterface{
    public $text = null;
    public $label = null;
    public $buttonLabel = null;
    public $partners = null;

    public function toJson() {
        return ($this->text) ? [
            'text' => $this->text,
            'label' => $this->label,
            'button_label' => $this->buttonLabel,
            'partners' => $this->partners,
        ]: null;
    }

    public function __construct($data) {
        $this->text = $data['text'] ?? null;
        $this->label = $data['label'] ?? null;
        $this->buttonLabel = $data['button_label'] ?? null;

        $partners = Partner::all();

        if($partners) {
            foreach($partners as $partner) {
                $this->partners[] = [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'logo' => [
                        'path' => $partner->logo,
                        'url' => AppUtils::pathToAWSUrl($partner->logo),
                    ],
                ];
            }
        } else {
            $this->partners = null;
        }
    }

    public static function fromJson($data) {
        return new Partners($data);
    }
}