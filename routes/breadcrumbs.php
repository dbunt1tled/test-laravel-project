<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.05.18
 * Time: 17:23
 */

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use App\Entity\User;

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
Breadcrumbs::register('cabinet', function (BreadcrumbsGenerator $bread){
    $bread->parent('home');
    $bread->push('Изменить пароль', route('cabinet'));
});
