@extends('layouts.admin')
@section('content')
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" href="{{route('admin.home')}}">Админ. Панель</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">Пользователи</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('admin.region.index')}}">Регионы</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('admin.adverts.category.index')}}">Категории</a></li>
    </ul>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    You are logged in Adminka!
                </div>
            </div>
        </div>
    </div>
@endsection
