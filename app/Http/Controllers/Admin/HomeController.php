<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        $client->indices()->create([

        ]);

        return view('admin.index');
    }
}
