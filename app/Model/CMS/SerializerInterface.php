<?php

namespace App\Model\CMS;

interface SerializerInterface {
    public function toJson();
    public static function fromJson($data);
}