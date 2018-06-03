<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{

    public function __construct() {
        $this->middleware(FilledProfile::class);
    }

    public function index()
    {
        return view('cabinet.adverts.index');
    }
    public function create()
    {
        return view('cabinet.adverts.create');
    }
}
