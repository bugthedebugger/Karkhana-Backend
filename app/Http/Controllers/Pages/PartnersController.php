<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Partner;

class PartnersController extends Controller {
    public function findByID($id) {
        $partner = Partner::find($id);

        if($partner) {
            return CommonResponses::success('success', true, [
                'id' => $partner->id,
                'name' => $partner->name,
                'logo' => [
                    'path' => $partner->logo,
                    'url' => AppUtils::pathToAWSUrl($partner->logo),
                ],
                'description' => $partner->description,
            ]);
        }
        return CommonResponses::error('Invalid partner id!', 422);
    }

    public function index() {
        $partners = Partner::all();

        if($partners) {
            $data = null;

            foreach($partners as $partner) {
                $data[] = [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'logo' => [
                        'path' => $partner->logo,
                        'url' => AppUtils::pathToAWSUrl($partner->logo),
                    ],
                    'description' => $partner->description,
                ];
            }

            return CommonResponses::success('success', true, $data);
        }
        return CommonResponses::error('Invalid partner id!', 422);
    }
}