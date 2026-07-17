<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Services\Website\HomePageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends BaseController
{
    public function __construct(
        protected HomePageService $homePageService
    ) {}

    /**
     * Landing Page
     */
    public function index(): View
    {
        $pageData = $this->homePageService->getPageData();

        return view('website.home', compact('pageData'));
    }

    public function about(): View
    {
        return view('website.about');
    }

    public function contact(): View
    {
        return view('website.contact');
    }

    public function news(): View
    {
        return view('website.news');
    }

    public function events(): View
    {
        return view('website.events');
    }
}
