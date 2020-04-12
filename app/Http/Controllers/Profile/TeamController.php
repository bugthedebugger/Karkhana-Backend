<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Team;

class TeamController extends Controller
{
    public function index($id) {
        $team = Team::find($id);
        if ($team) {
            $data = [
                'id' => $team->id,
                'name' => $team->name,
                'bio' => $team->bio,
                'post' => $team->post,
                'photo' => [
                    'path' => $team->photo,
                    'url' => AppUtils::pathToAWSUrl($team->photo),
                ],
                'facebook' => $team->facebook,
                'twitter' => $team->twitter,
                'instagram' => $team->instagram,
                'email' => $team->email,
            ];
            return CommonResponses::success('success', true, $data);
        }
        return CommonResponses::error('Invalid team ID', 422);
    }

    public function list() {
        $teams = Team::all();
        if ($teams) {
            $data = null;
            foreach($teams as $team) {
                $data[] = [
                    'id' => $team->id,
                    'name' => $team->name,
                    'bio' => $team->bio,
                    'post' => $team->post,
                    'photo' => [
                        'path' => $team->photo,
                        'url' => AppUtils::pathToAWSUrl($team->photo),
                    ],
                    'facebook' => $team->facebook,
                    'twitter' => $team->twitter,
                    'instagram' => $team->instagram,
                    'email' => $team->email,
                ];
            }
            return CommonResponses::success('success', true, $data);
        }
        return CommonResponses::error('Invalid team ID', 422);
    }
}
