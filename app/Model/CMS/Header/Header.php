<?php

namespace App\Model\CMS\Header;

use App\Model\CMS\SerializerInterface;
use App\Model\Setting;
use App\Model\Language;
use App\Model\Product;
use App\Common\AppUtils;

class Header implements SerializerInterface{
    public $products = null;
    public $product_label = null;
    public $logo = null;
    public $blog = null;
    public $about = null;
    public $contact = null;
    public $facebook = null;
    public $instagram = null;
    public $youtube = null;
    public $language = null;

    public function toJson() {
        $settings = Setting::first();

        return [
            'language' => $this->language,
            'products' => $this->products,
            'product_label' => $this->product_label,
            'logo' => AppUtils::pathToAWSUrl($this->logo),
            'blog' => $this->blog,
            'about' => $this->about,
            'contact' => $this->contact,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
        ];
    }

    public function __construct($data) {
        $settings = Setting::first();
        $products = Product::all();
        $productList = null;
        $language = Language::where('language', $data['language'] ?? 'en')->first();
        $this->language = $data['language'] ?? 'en';

        if($products) {
            foreach($products as $product) {
                $productTranslation = $product->translate($language)->first();
                $productList[] = [
                    'code' => $product->code,
                    'name' => $productTranslation->name ?? null,
                    'logo' => AppUtils::pathToAWSUrl($product->logo),
                    'color' => $product->color,
                    'secondary_color' => $product->secondary_color,
                ];
            }
        }

        $this->product_label = $data['product_label'] ?? null;
        $this->blog = $data['blog'] ?? null;
        $this->about = $data['about'] ?? null;
        $this->contact = $data['contact'] ?? null;
        $this->facebook = $settings->facebook ?? null;
        $this->instagram = $settings->instagram ?? null;
        $this->youtube = $settings->youtube ?? null;
        $this->logo = $settings->logo ?? null;
        $this->products = $productList;
    }

    public static function fromJson($data) {
        return new Header($data);
    }
}