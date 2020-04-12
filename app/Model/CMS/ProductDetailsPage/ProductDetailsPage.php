<?php

namespace App\Model\CMS\ProductDetailsPage;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;
use App\Model\Language;
use App\Model\Product;
use App\Common\AppUtils;
use App\Model\CMS\PageModel;

class ProductDetailsPage extends PageModel implements SerializerInterface{
    public $gradeLabel = null;
    public $typeLabel  = null;
    public $productLabel  = null;
    public $schoolServicesLabel = null;
    public $studentServicesLabel = null;
    public $learn_more_label = null;
    public $download_label = null;
    public $product_code = null;
    public $product = null;
    public $feature_label = null;
    public $facts_label = null;
    public $code = null;

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
            'feature_label' => $this->feature_label,
            'facts_label' => $this->facts_label,
            'language' => $this->language,
            'product' => $this->product,
            'code' => $this->code,
        ];
    }

    public function __construct($data) {
        parent::__construct($data);

        $product = Product::where('code', $data['code'])->first();
        $language = Language::where('language', $this->language)->first();
        $productTranslation = $product->translate($language)->first();

        $product = [
            'code' => $product->code ?? null,
            'name' => $productTranslation->name ?? null,
            'logo' => AppUtils::pathToAWSUrl($product->logo),
            'color' => $product->color ?? null,
            'secondary_color' => $product->secondary_color ?? null,
            'featured_image' => [
                'path' => $product->featured_image,
                'url' => AppUtils::pathToAWSUrl($product->featured_image),
            ],
            'tag' => $productTranslation->tag ?? null,
            'grade' => $productTranslation->grade ?? null,
            'type' => $productTranslation->type ?? null,
            'school_services' => $productTranslation->school_services ?? null,
            'student_services' => $productTranslation->student_services ?? null,
            'description' => $productTranslation->description ?? null,
            'facts' => $productTranslation->facts ?? null,
            'features' => $productTranslation->features ?? null,
            'brochure' => AppUtils::pathToAWSUrl($productTranslation->brochure ?? null),
        ];

        $this->product = $product;
        $this->gradeLabel = $data['grade_label'] ?? null;
        $this->typeLabel  = $data['type_label'] ?? null;
        $this->productLabel  = $data['product_label'] ?? null;
        $this->schoolServicesLabel = $data['school_services_label'] ?? null;
        $this->studentServicesLabel = $data['student_services_label'] ?? null;
        $this->learn_more_label = $data['learn_more_label'] ?? null;
        $this->download_label = $data['download_label'] ?? null;
        $this->feature_label = $data['feature_label'] ?? null;
        $this->facts_label = $data['facts_label'] ?? null;
        $this->code = $data['code'] ?? null;
    }

    public static function fromJson($data) {
        return new ProductDetailsPage($data);
    }
}