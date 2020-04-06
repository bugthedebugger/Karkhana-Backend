<?php

namespace App\Model\CMS;

interface SerializerInterface {
    public function toJson();
    static public function fromJson($data);
}