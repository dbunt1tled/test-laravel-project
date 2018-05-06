<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.05.18
 * Time: 17:23
 */

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

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