<?php

namespace App\Http\Controllers\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Router\AdvertsPath;
use App\UseCases\Adverts\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FavoriteController extends Controller
{
    private $service;

    public function __construct(FavoriteService $service) {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function add(Advert $advert)
    {
        try {
            $this->service->add(Auth::id(),$advert->id);
        }catch (\DomainException $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('adverts.show', $advert)->with('success','Объявление успешно добавленно в избранное');
    }
    public function remove(Advert $advert)
    {
        try {
            $this->service->remove(Auth::id(),$advert->id);
        }catch (\DomainException $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('adverts.show', $advert)->with('success','Объявление успешно удалено из избранного');

    }

}
