<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Partner;

class PartnersController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'logo' => 'required|string',
            'description' => 'required|string',
        ]);

        \DB::beginTransaction();
        try {
            Partner::create($request->all());
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }

        return CommonResponses::success('Partners added successfully!');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string',
            'logo' => 'nullable|string',
            'description' => 'required|string',
        ]);

        \DB::beginTransaction();
        try {
            $partner = Partner::find($id);
            if($partner) {
                $partner->update($request->all());
            } else {
                return CommonResponses::error('Invalid partner id!', 422);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }
        return CommonResponses::success('Partner updated successfully!');
    }

    public function delete($id) {
        \DB::beginTransaction();
        try {
            $partner = Partner::find($id);
            if($partner) {
                $partner->delete();
            } else {
                return CommonResponses::error('Invalid partner id!', 422);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }
        return CommonResponses::success('Partner deleted successfully!');
    }

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
