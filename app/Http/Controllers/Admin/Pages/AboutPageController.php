<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Section;
use App\Model\CMS\AboutPage\AboutPage;

class AboutPageController extends Controller {
    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'sections' => 'required',
            'sections.karkhana_building' => 'nullable',
            'sections.karkhana_building.path' => 'required_with:sections.karkhana_building|string',
            'sections.head_section' => 'nullable',
            'sections.head_section.title' => 'required_with:sections.head_section|string',
            'sections.head_section.sub_text' => 'required_with:sections.head_section|string',
            'sections.head_section.brand_video' => 'nullable|url',
            'sections.mission_vision' => 'nullable',
            'sections.mission_vision.mission' => 'required_with:sections.mission_vision',
            'sections.mission_vision.vision' => 'required_with:sections.mission_vision',
            'sections.mission_vision.mission.title' => 'required_with:sections.mission_vision.mission|string',
            'sections.mission_vision.mission.sub_text' => 'required_with:sections.mission_vision.mission|string',
            'sections.mission_vision.mission.text' => 'required_with:sections.mission_vision.mission|string',
            'sections.mission_vision.vision.title' => 'required_with:sections.mission_vision|string',
            'sections.mission_vision.vision.text' => 'required_with:sections.mission_vision|string',
            'sections.values' => 'nullable',
            'sections.values.title' => 'required_with:sections.values',
            'sections.values.values' => 'required_with:sections.values|array',
            'sections.values.values.*.title' => 'required|string',
            'sections.values.values.*.text' => 'required|string',
            'sections.team' => 'nullable',
            'sections.team.title' => 'required_with:sections.team|string',
            'sections.team.sub_title' => 'required_with:sections.team|string',
            'sections.team.sub_text' => 'required_with:sections.team|string',
            'sections.team.text' => 'required_with:sections.team|string',
            'sections.team.team_photo' => 'required_with:sections.team',
            'sections.team.team_photo.path' => 'required_with:sections.team.team_photo',
            'sections.team.employees' => 'required_with:sections.team',
            'sections.team.employees.label' => 'required_with:sections.team.employees|string',
        ]);

        $language = Language::where('language', $request->language)->first();
        if($language) {
            \DB::beginTransaction();
            try {
                $section = Section::where('code', 'about')->first();
                $sectionTranslation = $section->translate($language)->first();
                $aboutPageDataModel = AboutPage::fromJson($request->all()['sections']);
                if($sectionTranslation) {
                    $sectionTranslation->update([
                        'data' => $aboutPageDataModel->toJson(),
                    ]);
                } else {
                    $section->translations()->create([
                        'language_id' => $language->id,
                        'data' => $aboutPageDataModel->toJson(),
                    ]);
                }
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('About page updated successfully!', true, $aboutPageDataModel->toJson());
        }
        return CommonResponses::error('Invalid language code!', 422);
    }
}