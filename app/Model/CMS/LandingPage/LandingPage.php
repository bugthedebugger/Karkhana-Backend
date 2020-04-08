<?php

namespace App\Model\CMS\LandingPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;
use App\Model\Partner;
use App\Model\CMS\LandingPage\ListOfSlider;
use App\Model\CMS\LandingPage\About;
use App\Common\AppUtils;

class LandingPage implements SerializerInterface {
    public $sliders = null;
    public $about = null;
    public $stats = null;
    public $partners = null;
    public $phone = null;
    public $mobile = null;

    public function __construct($data) {
        $this->sliders = ListOfSlider::fromJson($data['sliders'] ?? null);
        $this->about = About::fromJson($data['about'] ?? null);
    }

    public function toJson() {
        $settings = Setting::first();
        $partners = Partner::all();

        if($partners) {
            foreach($partners as $partner) {
                $this->partner[] = [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'logo' => [
                        'path' => $partner->logo,
                        'url' => AppUtils::pathToAWSUrl($partner->logo),
                    ],
                ];
            }
        }

        if($settings) {
            $this->phone = $settings->phone;
            $this->mobile = $settings->mobile;
        } 

        return [
            'sliders' => $this->sliders ? $this->sliders->toJson(): null,
            'about' => $this->about ? $this->about->toJson(): null,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'partners' => $this->partners,
        ];
    }

    public static function fromJson($data) {
        return new LandingPage($data);
    }
}