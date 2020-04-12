<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Section;
use App\Model\CMS\ContactUsPage\ContactUsPage;

class ContactUsController extends Controller
{
    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'address' => 'required',
            'address.label' => 'required|string',
            'open_hours' => 'required',
            'open_hours.label' => 'required|string',
            'open_days' => 'required',
            'open_days.label' => 'required|string',
            'phone' => 'required',
            'phone.label' => 'required',
            'email' => 'required',
            'email.label' => 'required', 
        ]);

        $language = Language::where('language', $request->language)->first();
        if($language) {
            \DB::beginTransaction();
            try {
                $contactUsPageDatamodel = ContactUsPage::fromJson($request->all());
                $section = Section::where('code', 'contact')->first();
                $sectionTranslation = $section->translate($language)->first();
                
                if($sectionTranslation) {
                    $sectionTranslation->update([
                        'data' => $contactUsPageDatamodel->toJson(),
                    ]);
                } else {
                    $section->translations()->create([
                        'language_id' => $language->id,
                        'data' => $contactUsPageDatamodel->toJson(),
                    ]);
                }
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('Sections updated successfully!', true, $contactUsPageDatamodel->toJson());
        }
        return CommonResponses::error('Invalid language code!', 422);
    }
}
