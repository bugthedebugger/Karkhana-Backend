<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Section;
use App\Model\CMS\Header\Header;

class HeadersController extends Controller
{
    public function update(Request $request) {
        $this->validate($request, [
            'language' => 'required',
            'product_label' => 'required',
            'logo' => 'nullable',
            'blog' => 'required',
            'about' => 'required',
            'contact' => 'required',
        ]);

        $language = Language::where('language', $request->language)->first();
        if($language) {
            \DB::beginTransaction();
            try {
                $headerSection = Section::where('code', 'header')->first();
                $headerTranslation = $headerSection->translate($language)->first();
                $headerDataModel = Header::fromJson($request);
                if($headerTranslation) {
                    $headerTranslation->update([
                        'data' => $headerDataModel->toJson(),
                    ]);
                } else {
                    $headerSection->translations()->create([
                        'language_id' => $language->id,
                        'data' => $headerDataModel->toJson(),
                    ]);
                }
                \DB::commit();
            } catch(\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('Header updated successfully!', true, $headerDataModel->toJson());
        }
        return CommonResponses::error('Invalid language code!', 422);
    }
}
