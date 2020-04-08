<?php

namespace App\Model\CMS\LandingPage;

use App\Common\AppUtils;
use App\Model\CMS\SerializerInterface;
use App\Model\CMS\LandingPage\Slider;

class ListOfSlider implements SerializerInterface {

    public $sliders = null;

    public function __construct($sliders) {
        if($sliders) {
            foreach($sliders as $slider) {
                $this->sliders[] = Slider::fromJson($slider);;
            }
        }
    }

    public function toJson() {
        $sliders = null;
        if($this->sliders) {
            foreach($this->sliders as $slider) {
                $sliders[] = $slider->toJson();
            }
        }
        return $sliders;
    }
    

    public static function fromJson($sliders) {
        return new ListOfSlider($sliders);
    }
}