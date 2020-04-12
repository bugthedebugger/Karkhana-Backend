<?php

/**
 *
 */
namespace App\Http\Controllers\Pages;

use App\User;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Traits\LanguageTrait;
use App\Http\Controllers\Controller;
use App\Common\CommonResponses;
use App\Model\CMS\LandingPage\LandingPage;
use App\Model\CMS\Header\Header;
use App\Model\CMS\ContactUsPage\ContactUsPage;
use App\Model\CMS\ProductsPage\ProductsPage;
use App\Model\CMS\ProductDetailsPage\ProductDetailsPage;
use App\Model\Language;
use App\Model\Product;

class PageController extends Controller
{
	use LanguageTrait;
    public function index(Request $request, $code)
    {
		$page = Page::where('code', $code)->first();

		if($page) {
			if($request->has('language')) {
				$language = Language::where('language', $request->language)->first();
				if($language) {
					// Do nothing
				} else {
					$language = Language::where('language', 'en')->first();
				}
			} else {
				$language = $this->getLanguage($request);
			}

			$section = $page->sections()->first()->translate($language)->first();

			switch($code) {
				case 'landing':
					$data = LandingPage::fromJson($section->data ?? null); 
					$response = $data->toJson();
					break;
				case 'header':
					$data = Header::fromJson($section->data ?? null);
					$response = $data->toJson();
					break;
				case 'contact':
					$data = ContactUsPage::fromJson($section->data ?? null);
					$response = $data->toJson();
					break;
				case 'products':
					$data = ProductsPage::fromJson($section->data ?? null);
					$response = $data->toJson();
					break;
				case 'product-details':
					$this->validate($request, [
						'code' => 'required',
					]);
					$product = Product::where('code', $request->code)->first();
					if($product) {
						$sectionData = $section->data ?? null;
						$sectionData['code'] = $product->code;
						
						$data = ProductDetailsPage::fromJson($sectionData);
						$response = $data->toJson();
					} else {
						return CommonResponses::error('Invalid product code!', 422);
					}
					break;
				default:
					$response = null;
				break;
			}

			return CommonResponses::success('success', true, $response ?? null);
		} 

		return CommonResponses::error('Invalid page code!', 400);
	}
	
	public function listPages() {
		$pages = Page::all();
		$pageList = null;

		foreach($pages as $page) {
			$pageList[] = [
				"code" => $page->code,
				"name" => $page->name,
			];
		}

		return CommonResponses::success('success', true, $pageList);
	}
}
