<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Common\AppUtils;
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
            'featured_image' => 'nullable',
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

    public function update(Request $request) {
        $this->validate($request, [
            'product_id' => 'required',
            'logo' => 'required',
            'color' => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'secondary_color' => ['required', 'regex:/^(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))$/i'],
            'code' => 'required|string',
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
            'featured_image' => 'nullable',
        ]);
        
        $language = Language::where('language', $request->language)->first();
        
        if($language) {
            $product = Product::where('id', $request->product_id)->first();
            if($product) {
                \DB::beginTransaction();
                try {
                    $product->update($request->all());
                    $productTranslation = $product->translate($language)->first();
                    if($productTranslation) {
                        $productTranslation->update($request->all());
                    } else {
                        $data = $request->all();
                        $data['language_id'] = $language->id;
                        $product->translations()->create($data);
                    }
                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollback();
                    return CommonResponses::exception($e);
                }
                return CommonResponses::success('Product updated successfully!');
            }
            return CommonResponses::error('Invalid product id!');
        }
        return CommonResponses::error('Invalid language code!', 422);
    }

    public function all() {
        $products = Product::all();
        $language = Language::where('language', 'en')->first();
        $productList = null;

        foreach($products as $product) {
            $productTranslation = $product->translate($language)->first();
            $productList[] = [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $productTranslation->name,
            ];
        }

        return CommonResponses::success('success', true, $productList);
    }

    public function findProductByID(Request $request, $id) {
        $language = Language::where('language', $request->language)->first();
        if($language) {
            $product = Product::find($id);
            if($product) {
                $productTranslation = $product->translate($language)->first();
                if($productTranslation) {
                    $productData = [
                        'id' => $product->id,
                        'logo' => [
                            'path' => $product->logo,
                            'url' => AppUtils::pathToAWSUrl($product->logo),
                        ],
                        'secondary_color' => $product->secondary_color,
                        'code' => $product->code,
                        'name' => $productTranslation->name,
                        'tag'  => $productTranslation->tag,
                        'grade'  => $productTranslation->grade,
                        'type'  => $productTranslation->type,
                        'school_services' => $productTranslation->school_services,
                        'student_services' => $productTranslation->student_services,
                        'description' => $productTranslation->description,
                        'facts' => $productTranslation->facts,
                        'features' => $productTranslation->features,
                        'brochure' => [
                            'path' => $productTranslation->brochure,
                            'url' => AppUtils::pathToAWSUrl($productTranslation->brochure),
                        ],
                        'featured_image' => [
                            'path' => $product->featured_image,
                            'url' => AppUtils::pathToAWSUrl($product->featured_image),
                        ],
                    ];
                    return CommonResponses::success('success', true, $productData);
                } 
                return CommonResponses::error('No product data found for the specified language!', 404);
            }
            return CommonResponses::error('Invalid product id', 422);
        } 
        return CommonResponses::error('Invlaid language code', 422);
    }
}
