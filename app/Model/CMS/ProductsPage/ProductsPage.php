<?php

namespace App\Model\CMS\ProductsPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;
use App\Model\Language;
use App\Model\Product;
use App\Common\AppUtils;
use App\Model\CMS\PageModel;

class ProductsPage extends PageModel implements SerializerInterface{
    public $products = null;
    public $gradeLabel = null;
    public $typeLabel  = null;
    public $productLabel  = null;
    public $schoolServicesLabel = null;
    public $studentServicesLabel = null;
    public $learn_more_label = null;
    public $download_label = null;

    public function toJson() {
        return [
            'header' => $this->header ? $this->header->toJson() : null,
            'grade_label' => $this->gradeLabel,
            'type_label' => $this->typeLabel,
            'product_label' => $this->productLabel,
            'school_services_label' => $this->schoolServicesLabel,
            'student_services_label' => $this->studentServicesLabel,
            'learn_more_label' => $this->learn_more_label,
            'download_label' => $this->download_label,
            'products' => $this->products,
            'language' => $this->language,
        ];
    }

    public function __construct($data) {
        parent::__construct($data);

        $products = Product::all();
        $language = Language::where('language', $this->language)->first();
        $productList = null;

        if($products) {
            foreach($products as $product) {
                $productTranslation = $product->translate($language)->first();
                $productList[] = [
                    'code' => $product->code,
                    'name' => $productTranslation->name ?? null,
                    'logo' => AppUtils::pathToAWSUrl($product->logo),
                    'color' => $product->color,
                    'secondary_color' => $product->secondary_color,
                    // 'tag' => $productTranslation->tag ?? null,
                    'grade' => $productTranslation->grade ?? null,
                    'type' => $productTranslation->type ?? null,
                    'school_services' => $productTranslation->school_services ?? null,
                    'student_services' => $productTranslation->student_services ?? null,
                    // 'description' => $productTranslation->description ?? null,
                    // 'facts' => $productTranslation->facts ?? null,
                    // 'features' => $productTranslation->features ?? null,
                    'brochure' => AppUtils::pathToAWSUrl($productTranslation->brochure ?? null),
                ];
            }
        }

        $this->products = $productList;
        $this->gradeLabel = $data['grade_label'] ?? null;
        $this->typeLabel  = $data['type_label'] ?? null;
        $this->productLabel  = $data['product_label'] ?? null;
        $this->schoolServicesLabel = $data['school_services_label'] ?? null;
        $this->studentServicesLabel = $data['student_services_label'] ?? null;
        $this->learn_more_label = $data['learn_more_label'] ?? null;
        $this->download_label = $data['download_label'] ?? null;
    }

    public static function fromJson($data) {
        return new ProductsPage($data);
    }
}