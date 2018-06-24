@extends('layouts.admin')
@section('content')
    @include ('admin._nav', ['page' => ''])
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
