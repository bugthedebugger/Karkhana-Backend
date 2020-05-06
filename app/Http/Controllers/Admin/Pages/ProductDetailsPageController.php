<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Model\CMS\ProductDetailsPage\ProductDetailsPage;
use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Section;
use App\Model\Product;

class ProductDetailsPageController extends Controller {

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
            'code' => 'required',
            'facts_label' => 'required',
            'feature_label' => 'required',
        ]);

        $language = Language::where('language', $request->language)->first();

        if($language) {
            $product = Product::where('code', $request->code)->first();
            if($product) {
                \DB::beginTransaction();
                try {
                    $section = Section::where('code', 'product-details')->first();
                    $sectionTranslation = $section->translate($language)->first();
                    $sectionData = $request->all();
                    $productsPageDataModel = ProductDetailsPage::fromJson($sectionData);
                    if($sectionTranslation) {
                        $sectionTranslation->update([
                            'language_id' => $language->id,
                            'data' => $productsPageDataModel->toJson(),
                        ]);
                        $sectionTranslation->save();
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
                return CommonResponses::success('Products detail page updated successfully!', true, $productsPageDataModel->toJson());
            }
            return CommonResponses::error('Invalid product code!', 422);
        }
        return CommonResponses::error('Invalid language code!', 422);
    }

}