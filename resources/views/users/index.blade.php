@extends('layouts.content')
@section('content')
    <br/>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">


    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br/>
    @endif

    <div class="row mb-4 ">
        <form action="/users" class="col-md-12" method="get">

            <div class="col-md-4 mt-3 p-0 input-group">
                <input type="text" class="form-control" name="search"
                       placeholder="Search users">
                </button>
                </span>
            </div>

            <div class=" col-md-3 mt-3 p-0 ">
                <input type="text" class="form-control" name="counto"
                       placeholder="projects count">
                <span class="mt-3">
            <button type="submit" class="btn mt-3 btn-primary">
                Search
            </button>
        </span>
            </div>

        </form>
    </div>
    <table class="table table-striped mt-5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>email</th>
            <th>Projects</th>
            <th>Tasks</th>
            <th>edit</th>
            <th colspan="2">Delate</th>
        </tr>
        </thead>
        <tbody>
        <br/>
        @foreach($userArr as $userObj)
            <tr>
                <td>{{$userObj->id}}</td>
                <td>{{$userObj->name}}</td>
                <td>{{$userObj->email}}</td>
                <td><a href="{{action('ProjectController@projects',$userObj->id)}}"
                       class="btn">{{count($userObj->projects)}}
                    </a></td>
                <td><a href="{{action('TaskController@tasks',$userObj->id)}}" class="btn">{{count($userObj->tasks)}}</a>
                </td>
                <td>
                    <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#edit"
                            >Edit
                    </button>


                </td>


                <td>
                    <form action="{{action('UserController@destroy', $userObj->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>







    <div class="offset-5 ">
        <a href="{{action('HomeController@index')}}" class="btn btn-warning">Home</a></div>



        <div class="modal" tabindex="-1" role="dialog" id="edit">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger" style="display:none"></div>
                    <div class="modal-header">

                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="mail">E-mail:</label>
                                <input type="text" class="form-control" name="mail" id="mail">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" id="ajaxSubmit">Save changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>






@endsection