<?php

namespace App\Http\Controllers\Admin\Pages;
use App\Http\Controllers\Controller;
use App\Traits\LanguageTrait;
use Illuminate\Http\Request;
use App\Common\CommonResponses;
use App\Model\CMS\LandingPage\LandingPage;
use App\Model\Language;
use App\Model\Section;


class LandingPageController extends Controller
{
    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'sections' => 'required|array',
            'sections.about' => 'nullable',
            'sections.sliders' => 'nullable|array',
            'sections.sliders.*.quote' => 'nullable|string',
            'sections.sliders.*.order' => 'required|int',
            'sections.sliders.*.hidden' => 'required|boolean',
            'sections.sliders.*.path' => 'required|string',
        ]);
        
        $language = Language::where('language', $request->language)->first();

        if($language) {
            \DB::beginTransaction();
            try {
                $landingPageDataModel = LandingPage::fromJson($request->sections);

                $landing_section = Section::where('code','landing')->first();
                $landing_section_by_language = $landing_section->translate($language)->first();
                if($landing_section_by_language) {
                    $landing_section_by_language->update([
                        'data' => $landingPageDataModel->toJson(),
                    ]);
                } else {
                    $landing_section->translations()->create([
                        'language_id' => $language->id,
                        'data' => $landingPageDataModel->toJson(),
                    ]);
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
        } else {
            return CommonResponses::error('Invalid language code!', 400);
        }

        return CommonResponses::success('Section updated successfully!', true, $landingPageDataModel->toJson());
    }
}
