<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Setting;

class SettingsController extends Controller
{

    public function createOrUpdate(Request $request) {
        $this->validate($request, [
            'logo' => 'nullable',
            'phone' => 'nullable',
            'mobile' => 'nullable',
            'email' => 'nullable',
            'open_hours' => 'nullable',
            'open_days' => 'nullable',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'youtube' => 'nullable',
            'location' => 'nullable',
            'geo_location' => 'nullable',
            'students_reached' => 'nullable',
            'employees' => 'nullable',
            'countried_we_work_in' => 'nullable',
            'cities_we_work_in' => 'nullable',
            'brand_video' => 'nullable',
        ]);

        \DB::beginTransaction();
        try {
            $settings = Setting::first();
            if($settings) {
                $settings->update($request->all());
            } else {
                Setting::create($request->all());
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }
        return CommonResponses::success('Settings updated successfully!');
    }
}
