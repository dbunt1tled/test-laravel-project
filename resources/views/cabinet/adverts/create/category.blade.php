@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Выберите категорию</div>

                <div class="card-body">
                    @include('cabinet.adverts.create._categories',['categories' => $categories])
                </div>
            </div>
        </div>
    </div>
@endsection
