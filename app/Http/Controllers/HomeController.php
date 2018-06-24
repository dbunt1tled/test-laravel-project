<?php

namespace App\Http\Controllers;

use App\Entity\Adverts\Category;
use App\Entity\Region;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Region::roots()->orderBy('name')->getModels();
        $categories = Category::whereIsRoot()->defaultOrder()->getModels();
        return view('home',compact('regions','categories'));
    }
}
