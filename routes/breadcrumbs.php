<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.05.18
 * Time: 17:23
 */

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use App\Entity\User;
use App\Entity\Region;
use App\Entity\Adverts\Category;
use App\Entity\Adverts\Attribute;
use App\Http\Router\AdvertsPath;
use App\Http\Router\PagePath;
use App\Entity\Banner\Banner;
use App\Entity\Adverts\Advert\Advert;

Breadcrumbs::register('admin.home', function (BreadcrumbsGenerator $bread){
    $bread->push('Админ. панель', route('admin.home'));
});
Breadcrumbs::register('admin.users.index', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.home');
    $bread->push('Пользователи', route('admin.users.index'));
});
Breadcrumbs::register('admin.users.create', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.users.index');
    $bread->push('Создать пользователя', route('admin.users.create'));
});
Breadcrumbs::register('admin.users.edit', function (BreadcrumbsGenerator $bread, User $user){
    $bread->parent('admin.users.index');
    $bread->push('Редактировать пользователя: '.$user->name, route('admin.users.edit',$user));
});
Breadcrumbs::register('admin.users.show', function (BreadcrumbsGenerator $bread, User $user){
    $bread->parent('admin.users.index');
    $bread->push('Данные пользователя: '.$user->name, route('admin.users.show',$user));
});

Breadcrumbs::register('admin.region.index', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.home');
    $bread->push('Регионы', route('admin.region.index'));
});
Breadcrumbs::register('admin.region.create', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.region.index');
    $bread->push('Создать регион', route('admin.region.create'));
});
Breadcrumbs::register('admin.region.edit', function (BreadcrumbsGenerator $bread, Region $region){
    $bread->parent('admin.region.index');
    $bread->push('Редактировать регион: '.$region->name, route('admin.region.edit',$region));
});
Breadcrumbs::register('admin.region.show', function (BreadcrumbsGenerator $bread, Region $region){
    if($parent = $region->parent){
        $bread->parent('admin.region.show',$parent);
    }else{
        $bread->parent('admin.region.index');
    }
    $bread->push(/*'Данные региона: './**/$region->name, route('admin.region.show',$region));
});

// Adverts

Breadcrumbs::register('admin.adverts.adverts.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('admin.home');
    $bread->push('Categories', route('admin.adverts.adverts.index'));
});

Breadcrumbs::register('admin.adverts.adverts.edit', function (BreadcrumbsGenerator $bread, Advert $advert) {
    $bread->parent('admin.home');
    $bread->push($advert->title, route('admin.adverts.adverts.edit', $advert));
});

Breadcrumbs::register('admin.adverts.adverts.reject', function (BreadcrumbsGenerator $bread, Advert $advert) {
    $bread->parent('admin.home');
    $bread->push($advert->title, route('admin.adverts.adverts.reject', $advert));
});


Breadcrumbs::register('admin.adverts.category.index', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.home');
    $bread->push('Категории', route('admin.adverts.category.index'));
});
Breadcrumbs::register('admin.adverts.category.create', function (BreadcrumbsGenerator $bread){
    $bread->parent('admin.adverts.category.index');
    $bread->push('Создать категорию', route('admin.adverts.category.create'));
});
Breadcrumbs::register('admin.adverts.category.edit', function (BreadcrumbsGenerator $bread, Category $category){
    $bread->parent('admin.adverts.category.index');
    $bread->push('Редактировать категорию: '.$category->name, route('admin.adverts.category.edit',$category));
});
Breadcrumbs::register('admin.adverts.category.show', function (BreadcrumbsGenerator $bread, Category $category){
    if($parent = $category->parent){
        $bread->parent('admin.adverts.category.show',$parent);
    }else{
        $bread->parent('admin.adverts.category.index');
    }
    $bread->push($category->name, route('admin.adverts.category.show',$category));
});

// Banners
Breadcrumbs::register('admin.banners.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('admin.home');
    $bread->push('Banners', route('admin.banners.index'));
});
Breadcrumbs::register('admin.banners.show', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('admin.banners.index');
    $bread->push($banner->name, route('admin.banners.show', $banner));
});
Breadcrumbs::register('admin.banners.edit', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('admin.banners.show', $banner);
    $bread->push('Edit', route('admin.banners.edit', $banner));
});
Breadcrumbs::register('admin.banners.reject', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('admin.banners.show', $banner);
    $bread->push('Reject', route('admin.banners.reject', $banner));
});
// Tickets
Breadcrumbs::register('admin.tickets.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('admin.home');
    $bread->push('Tickets', route('admin.tickets.index'));
});
Breadcrumbs::register('admin.tickets.show', function (BreadcrumbsGenerator $bread, Ticket $ticket) {
    $bread->parent('admin.tickets.index');
    $bread->push($ticket->subject, route('admin.tickets.show', $ticket));
});
Breadcrumbs::register('admin.tickets.edit', function (BreadcrumbsGenerator $bread, Ticket $ticket) {
    $bread->parent('admin.tickets.show', $ticket);
    $bread->push('Edit', route('admin.tickets.edit', $ticket));
});


Breadcrumbs::register('admin.adverts.category.attribute.create', function (BreadcrumbsGenerator $bread, Category $category) {
    $bread->parent('admin.adverts.category.show', $category);
    $bread->push('Новый аттрибут', route('admin.adverts.category.attribute.create', $category));
});

Breadcrumbs::register('admin.adverts.category.attribute.show', function (BreadcrumbsGenerator $bread, Category $category, Attribute $attribute) {
    $bread->parent('admin.adverts.category.show', $category);
    $bread->push($attribute->name, route('admin.adverts.category.attribute.show', [$category, $attribute]));
});

Breadcrumbs::register('admin.adverts.category.attribute.edit', function (BreadcrumbsGenerator $bread, Category $category, Attribute $attribute) {
    $bread->parent('admin.adverts.category.attribute.show', $category, $attribute);
    $bread->push($attribute->name, route('admin.adverts.category.attribute.edit', [$category, $attribute]));
});



Breadcrumbs::register('home', function (BreadcrumbsGenerator $bread){
    $bread->push('Adverts', route('home'));
});
Breadcrumbs::register('login', function (BreadcrumbsGenerator $bread){
    $bread->parent('home');
    $bread->push('Вход', route('login'));
});
Breadcrumbs::register('register', function (BreadcrumbsGenerator $bread){
    $bread->parent('home');
    $bread->push('Регистрация', route('register'));
});
Breadcrumbs::register('password.request', function (BreadcrumbsGenerator $bread){
    $bread->parent('login');
    $bread->push('Сбросить пароль', route('password.request'));
});
Breadcrumbs::register('password.email', function (BreadcrumbsGenerator $bread){
    $bread->parent('passwordChange');
    $bread->push('Изменить пароль', route('password.email'));
});
Breadcrumbs::register('cabinet.home', function (BreadcrumbsGenerator $bread){
    $bread->parent('home');
    $bread->push('Управление', route('cabinet.home'));
});
Breadcrumbs::register('cabinet.profile.home', function (BreadcrumbsGenerator $bread){
    $bread->parent('cabinet.home');
    $bread->push('Профиль', route('cabinet.profile.home'));
});
Breadcrumbs::register('cabinet.profile.edit', function (BreadcrumbsGenerator $bread){
    $bread->parent('cabinet.profile.home');
    $bread->push('Просмотр личных данных', route('cabinet.profile.edit'));
});
Breadcrumbs::register('cabinet.profile.phone', function (BreadcrumbsGenerator $bread){
    $bread->parent('cabinet.profile.edit');
    $bread->push('Проверка телефона', route('cabinet.profile.phone'));
});
Breadcrumbs::register('login.phone', function (BreadcrumbsGenerator $bread){
    $bread->parent('login');
    $bread->push('Проверочный код', route('login.phone'));
});

Breadcrumbs::register('cabinet.adverts.index', function (BreadcrumbsGenerator $bread){
    $bread->parent('cabinet.home');
    $bread->push('Объявления', route('cabinet.adverts.index'));
});

Breadcrumbs::register('cabinet.adverts.create', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.adverts.index');
    $bread->push('Создать объявления', route('cabinet.adverts.create'));
});

Breadcrumbs::register('cabinet.adverts.create.region', function (BreadcrumbsGenerator $bread, Category $category, Region $region = null) {
    $bread->parent('cabinet.adverts.create');
    $bread->push($category->name, route('cabinet.adverts.create.region', [$category, $region]));
});

Breadcrumbs::register('cabinet.adverts.create.advert', function (BreadcrumbsGenerator $bread, Category $category, Region $region = null) {
    $bread->parent('cabinet.adverts.create.region', $category, $region);
    $bread->push($region ? $region->name : 'All', route('cabinet.adverts.create.advert', [$category, $region]));
});

Breadcrumbs::register('adverts.inner_region', function (BreadcrumbsGenerator $bread, AdvertsPath $path) {
    if ($path->region && $parent = $path->region->parent) {
        $bread->parent('adverts.inner_region', $path->withRegion($parent));
    } else {
        $bread->parent('home');
        $bread->push('Adverts', route('adverts.index'));
    }
    if ($path->region) {
        $bread->push($path->region->name, route('adverts.index', $path));
    }
});
Breadcrumbs::register('adverts.inner_category', function (BreadcrumbsGenerator $bread, AdvertsPath $path, AdvertsPath $orig) {
    if ($path->category && $parent = $path->category->parent) {
        $bread->parent('adverts.inner_category', $path->withCategory($parent), $orig);
    } else {
        $bread->parent('adverts.inner_region', $orig);
    }
    if ($path->category) {
        $bread->push($path->category->name, route('adverts.index', $path));
    }
});
Breadcrumbs::register('adverts.index', function (BreadcrumbsGenerator $bread, AdvertsPath $path = null) {
    $path = $path ?: adverts_path(null, null);
    $bread->parent('adverts.inner_category', $path, $path);
});
Breadcrumbs::register('adverts.show', function (BreadcrumbsGenerator $bread, Advert $advert) {
    $bread->parent('adverts.index', adverts_path($advert->region, $advert->category));
    $bread->push($advert->title, route('adverts.show', $advert));
});

// Favorites
Breadcrumbs::register('cabinet.favorites.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.home');
    $bread->push('Adverts', route('cabinet.favorites.index'));
});
// Cabinet Banners
Breadcrumbs::register('cabinet.banners.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.home');
    $bread->push('Banners', route('cabinet.banners.index'));
});
Breadcrumbs::register('cabinet.banners.show', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('cabinet.banners.index');
    $bread->push($banner->name, route('cabinet.banners.show', $banner));
});
Breadcrumbs::register('cabinet.banners.edit', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('cabinet.banners.show', $banner);
    $bread->push('Edit', route('cabinet.banners.edit', $banner));
});
Breadcrumbs::register('cabinet.banners.file', function (BreadcrumbsGenerator $bread, Banner $banner) {
    $bread->parent('cabinet.banners.show', $banner);
    $bread->push('File', route('cabinet.banners.file', $banner));
});
Breadcrumbs::register('cabinet.banners.create', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.banners.index');
    $bread->push('Create', route('cabinet.banners.create'));
});
Breadcrumbs::register('cabinet.banners.create.region', function (BreadcrumbsGenerator $bread, Category $category, Region $region = null) {
    $bread->parent('cabinet.banners.create');
    $bread->push($category->name, route('cabinet.banners.create.region', [$category, $region]));
});
Breadcrumbs::register('cabinet.banners.create.banner', function (BreadcrumbsGenerator $bread, Category $category, Region $region = null) {
    $bread->parent('cabinet.banners.create.region', $category, $region);
    $bread->push($region ? $region->name : 'All', route('cabinet.banners.create.banner', [$category, $region]));
});
// Cabinet Tickets
Breadcrumbs::register('cabinet.tickets.index', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.home');
    $bread->push('Tickets', route('cabinet.tickets.index'));
});
Breadcrumbs::register('cabinet.tickets.create', function (BreadcrumbsGenerator $bread) {
    $bread->parent('cabinet.tickets.index');
    $bread->push('Create', route('cabinet.tickets.create'));
});
Breadcrumbs::register('cabinet.tickets.show', function (BreadcrumbsGenerator $bread, Ticket $ticket) {
    $bread->parent('cabinet.tickets.index');
    $bread->push($ticket->subject, route('cabinet.tickets.show', $ticket));
});