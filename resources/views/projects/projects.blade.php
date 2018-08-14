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
            <th>tasks</th>


        </tr>
        </thead>
        <tbody>
        <br/>
        @foreach($projectArr as $projectObj)
            <tr>
                <td>{{$projectObj->id}}</td>
                <td> {{$projectObj->name}}</td>
                <td>{{$projectObj->description}}</td>
                <td><a href="{{action('TaskController@tasks',$projectObj->id)}}"
                       class="btn">{{count($projectObj->tasks)}}</a></td>


            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $projectArr->links()}}
    <div class="col-md-3 m-auto">
        <a href="{{action('UserController@index', $projectObj->id)}}" class="btn btn-warning ">Prev</a>
    </div>

@endsection
