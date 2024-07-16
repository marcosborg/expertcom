<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.home');
    }

    public function cms($page_id, $slug)
    {
        $page = Page::find($page_id);

        return view('website.cms', compact('page'));
    }
}
