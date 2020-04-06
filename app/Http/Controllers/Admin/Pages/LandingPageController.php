<?php

namespace App\Http\Controllers\Admin\Pages;
use App\Http\Controllers\Controller;
use App\Traits\LanguageTrait;
use Illuminate\Http\Request;
use App\Common\CommonResponses;
use App\Model\CMS\LandingPage\LandingPage;
use Validator;

class LandingPageController extends Controller
{
    use LanguageTrait;

    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'page_code' => 'required',
            'sections' => 'required|array',
        ]);

        $sectionData = $request->sections;
        $sectionValidatorRules = [
            'about' => 'required',
            'sliders' => 'required',
        ]; 

        if ($request->page_code != 'landing') 
            return CommonResponses::error('Invalid page code!', 400);
        
        $landingPageDataModel = LandingPage::fromJson($request->sections);

        return CommonResponses::success('success', true, $landingPageDataModel->toJson());
    }
}
