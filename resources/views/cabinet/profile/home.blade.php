@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ваш профиль</div>
                <div class="card-body">
                   <div class="mb-3">
                       <a href="{{route('cabinet.profile.edit')}}" class="btn btn-primary">Редактировать</a>
                   </div>
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td>Имя</td><td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td>Фамилия</td><td>{{$user->last_name}}</td>
                            </tr>
                            <tr>
                                <td>Email</td><td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <td>Телефон</td>
                                <td>
                                    @if($user->phone)
                                        {{$user->phone}}
                                        @if(!$user->isPhoneVerified())
                                            <i class="text-danger">Не подтвержден</i>
                                            <form method="POST" action="{{route('cabinet.profile.phone')}}">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Подтвердить</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @if($user->phone && $user->isPhoneVerified())
                                <tr>
                                    <td>Двуфакторная авторизация</td>
                                    <td>
                                        <form method="POST" action="{{route('cabinet.profile.phone.auth')}}">
                                            @csrf
                                            <input type="hidden" name="phoneAuthEnable" value="{{(int)!$user->isPhoneAuthEnabled()}}" />
                                            @if($user->isPhoneAuthEnabled())
                                                <button class="btn btn-sm btn-danger">Отключить</button>
                                            @else
                                                <button class="btn btn-sm btn-success">Включить</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
