<?php

namespace App\Model\CMS\ContactUsPage;

use App\Model\CMS\SerializerInterface;
use App\Model\CMS\ContactUsPage\Address;
use App\Model\Setting;
use App\Model\CMS\PageModel;


class ContactUsPage extends PageModel implements SerializerInterface {

    public $address = null;
    public $open_hours = null;
    public $open_days = null;
    public $phone = null;
    public $email = null;

    public function __construct($data) {
        $this->address = Address::fromJson($data['address'] ?? null);
        $this->open_hours = OpenHours::fromJson($data['open_hours'] ?? null); 
        $this->open_days = OpenDays::fromJson($data['open_days'] ?? null);
        $this->phone = Phone::fromJson($data['phone'] ?? null);
        $this->email = Email::fromJson($data['email'] ?? null);

        parent::__construct($data);
    }

    static public function fromJson($data) {
        return new ContactUsPage($data);
    }

    public function toJson() {
        return [
            'header' => $this->header,
            'address' => $this->address ? $this->address->toJson() : null,
            'open_hours' => $this->open_hours ? $this->open_hours->toJson() : null,
            'open_days' => $this->open_days ? $this->open_days->toJson() : null,
            'phone' => $this->phone ? $this->phone->toJson() : null,
            'email' => $this->email ? $this->email->toJson() : null,
            'language' => $this->language,
        ];
    }

}