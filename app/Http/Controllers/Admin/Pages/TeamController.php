<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Profile\TeamController as Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Team;

class TeamController extends Controller {
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3',
            'bio' => 'required|min:3',
            'post' => 'required|min:3',
            'photo' => 'required|min:3',
        ]);

        \DB::beginTransaction();
        try {
            Team::create($request->all());
            \DB::commit();
        } catch(\Exception $e) {
            \DB::rollback();
            return CommonResponses::exception($e);
        }
        return CommonResponses::success('success');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|min:3',
            'bio' => 'required|min:3',
            'post' => 'required|min:3',
            'photo' => 'required|min:3',
        ]);

        $team = Team::find($id);
        if ($team) {
            \DB::beginTransaction();
            try {
                $team->update($request->all());
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('success');
        }
        return CommonResponses::error('Invalid team ID', 422);
    }

    public function delete($id) {
        $team = Team::find($id);
        if ($team) {
            \DB::beginTransaction();
            try {
                $team->delete();
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('success');
        }
        return CommonResponses::error('Invalid team ID', 422);
    }

}