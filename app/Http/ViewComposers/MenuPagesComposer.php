<?php

namespace App\Http\ViewComposers;

use App\Entity\Page;
use Illuminate\View\View;

//Виджет
class MenuPagesComposer
{
    public function compose(View $view): void
    {
        $view->with('menuPages', Page::whereIsRoot()->defaultOrder()->getModels());
    }
}
