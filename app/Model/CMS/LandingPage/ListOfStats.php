<?php

namespace App\Model\CMS\LandingPage;

use App\Common\AppUtils;
use App\Model\CMS\SerializerInterface;
use App\Model\CMS\LandingPage\Stats;

class ListOfStats implements SerializerInterface {

    public $stats = null;

    public function __construct($stats) {
        $students_reached = $stats['students_reached'] ?? null;
        $students_reached['code'] = 'students_reached';

        $employees = $stats['employees'] ?? null;
        $employees['code'] = 'employees';

        $countried_we_work_in  = $stats['countried_we_work_in'] ?? null;
        $countried_we_work_in['code'] = 'countried_we_work_in';

        $cities_we_work_in = $stats['cities_we_work_in'] ?? null;
        $cities_we_work_in['code'] = 'cities_we_work_in';

        $this->stats = [
            'students_reached' => Stats::fromJson($students_reached),
            'employees' => Stats::fromJson($employees),
            'countried_we_work_in' => Stats::fromJson($countried_we_work_in),
            'cities_we_work_in' => Stats::fromJson($cities_we_work_in),
        ];
    }

    public function toJson() {
        $statList = null;
        if($this->stats) {
            foreach ($this->stats as $key => $value) {
                $statList[$key] = $value ? $value->toJson() : null; 
            }
        }
        return $statList;
    }
    

    public static function fromJson($stats) {
        return new ListOfStats($stats);
    }
}