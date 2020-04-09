<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use Illuminate\Http\Request;
use App\Model\Language;
use App\Model\Product;

class ProductsController extends Controller
{
    /**
     * Create a new Prodcuts controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request) {
        $this->validate($request, [
            'logo' => 'required',
            'color' => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'secondary_color' => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'code' => 'required|string|unique:products',
            'language' => 'required',
            'name' => 'required',
            'tag' => 'required',
            'grade' => 'required',
            'type' => 'required',
            'school_services' => 'required',
            'student_services' => 'required',
            'description' => 'required',
            'facts' => 'nullable|array',
            'features' => 'nullable|array',
            'features.*.logo' => 'required',
            'features.*.feature' => 'required',
            'brochure' => 'nullable',
        ]);
        
        $language = Language::where('language', $request->language)->first();
        
        if($language) {
            \DB::beginTransaction();
            try {
                $product = Product::create($request->all());
                $data = $request->all();
                $data['language_id'] = $language->id;
                $product->translations()->create($data);
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                return CommonResponses::exception($e);
            }
            return CommonResponses::success('Product created successfully!');
        }
        return CommonResponses::error('Invalid language code!', 422);
    }
}
