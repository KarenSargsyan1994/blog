@extends('layouts.content')
@section('content')
    <br/>
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br/>
    @endif


    <table class="table table-striped mt-5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>description</th>



        </tr>
        </thead>
        <tbody>
        <br/>
        @foreach($taskArr as $taskObj)
            <tr>
                <td>{{$taskObj->id}}</td>


                <td> {{$taskObj->name}}</td>
                <td>{{$taskObj->description}}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $taskArr->links()}}
    <div class="col-md-3 m-auto">
        <a href="{{action('UserController@index')}}" class="btn btn-warning ">Prev</a>
    </div>



@endsection