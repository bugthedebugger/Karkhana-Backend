<?php

namespace App\Model\CMS\AboutPage;

use App\Model\CMS\SerializerInterface;
use App\Model\CMS\PageModel;


class AboutPage extends PageModel implements SerializerInterface {

    public function __construct($data) {
        parent::__construct($data);
    }

    static public function fromJson($data) {
        return new AboutPage($data);
    }

    public function toJson() {
        return [

        ];
    }

}