<?php

namespace App\Http\Controllers;

use App\Company;
use App\Models\Article;
use App\Models\Faq;
use App\Models\Service;
use App\Video;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        return view('site')->with(['videos' => Video::latest()->get(), 'companies' => Company::all(),'services' => Service::latest()->get(),'faqs' => Faq::latest()->get(), 'articles' => Article::latest()->SimplePaginate(10)]);
    }
}
