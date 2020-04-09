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

class PageController extends Controller
{
	use LanguageTrait;
    public function index(Request $request, $code)
    {
		$page = Page::where('code', $code)->first();

		if($page) {
			$language = $this->getLanguage($request);
			$section = $page->sections()->first()->translate($language)->first();

			switch($code) {
				case 'landing':
					$data = LandingPage::fromJson($section->data); 
					$response = $data->toJson();
					break;
				case 'header':
					$data = Header::fromJson($section->data);
					$response = $data->toJson();
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
