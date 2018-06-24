<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\Adverts\Advert\Advert;
use App\Http\Controllers\Controller;
use App\UseCases\Adverts\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    private $service;

    public function __construct(FavoriteService $service) {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
       $adverts = Advert::favoredByUser(Auth::user())->orderByDesc('id')->paginate(20);

        return view('cabinet.favorites.index',compact('adverts'));
    }
    public function remove(Advert $advert)
    {
        try {
            $this->service->remove(Auth::id(),$advert->id);
        }catch (\DomainException $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('cabinet.favorites.index', $advert)->with('success','Объявление успешно удалено из избранного');

    }
}
