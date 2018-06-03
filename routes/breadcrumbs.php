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