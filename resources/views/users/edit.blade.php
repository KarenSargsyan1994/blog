@extends('layouts.content')
@section('content')
    <h2>Edit A User</h2><br/>

    <form method="post" action="{{action('UserController@update', $id)}}">
        {{csrf_field()}}
        <input name="_method" type="hidden" value="PATCH">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="{{$userObj->name}}">
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="price">E-mail:</label>
                <input type="text" class="form-control" name="email" value="{{$userObj->email}}">
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Update User</button>
            </div>
        </div>
    </form>
@endsection