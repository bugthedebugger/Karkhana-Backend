<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Model\CMS\ProductsPage\ProductsPage;
use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Section;

class ProductsPageController extends Controller {

    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'grade_label' => 'required',
            'type_label' => 'required',
            'product_label' => 'required',
            'school_services_label' => 'required',
            'student_services_label' => 'required',
            'learn_more_label' => 'required',
            'download_label' => 'required',
        ]);

        $language = Language::where('language', $request->language)->first();

        if($language) {
            \DB::beginTransaction();
            try {
                $section = Section::where('code', 'products')->first();
                $sectionTranslation = $section->translate($language)->first();
                $sectionData = $request->all();
                $productsPageDataModel = ProductsPage::fromJson($sectionData);
                if($sectionTranslation) {
                    $sectionTranslation->update($sectionData);
                } else {
                    $section->translations()->create([
                        'language_id' => $language->id,
                        'data' => $productsPageDataModel->toJson(),
                    ]);
                }
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('Products page updated successfully!', true, $productsPageDataModel->toJson());
        }
        return CommonResponses::error('Invalid language code!', 422);
    }

}