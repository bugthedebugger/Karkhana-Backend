<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Partner;
use App\Http\Controllers\Pages\PartnersController as BaseController;

class PartnersController extends BaseController
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

}
