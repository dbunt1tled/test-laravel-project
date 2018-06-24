<?php


if (! function_exists('adverts_path')) {
    function adverts_path(?\App\Entity\Region $region, ?\App\Entity\Adverts\Category $category)
    {
        return app()->make(\App\Http\Router\AdvertsPath::class)
                    ->withRegion($region)
                    ->withCategory($category);
    }
}
/*
if (! function_exists('page_path')) {
    function page_path(Page $page)
    {
        return app()->make(PagePath::class)
                    ->withPage($page);
    }
}
/**/