<?php


if (! function_exists('adverts_path')) {
    function adverts_path(?\App\Entity\Region $region, ?\App\Entity\Adverts\Category $category)
    {
        return app()->make(\App\Http\Router\AdvertsPath::class)
                    ->withRegion($region)
                    ->withCategory($category);
    }
}

if (! function_exists('page_path')) {
    function page_path(\App\Entity\Page $page)
    {
        return app()->make(\App\Http\Router\PagePath::class)
                    ->withPage($page);
    }
}
