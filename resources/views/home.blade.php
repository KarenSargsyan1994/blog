@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class=" col-md-6">

                <a href="{{action('UserController@index')}}" class="btn btn-success">List page</a>

            </div>
        </div>
    </div>
@endsection
