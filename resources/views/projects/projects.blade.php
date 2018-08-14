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
            <th>Description</th>
            <th>Tasks</th>
            <th>Edit</th>


        </tr>
        </thead>
        <tbody>
        <br/>
        @foreach($projectArr as $projectObj)
            <tr>
                <td>{{$projectObj->id}}</td>
                <td><a href="{{action('TaskController@projtask',$projectObj->id)}}"
                       class="btn">{{$projectObj->name}}</a>
                </td>
                <td>{{$projectObj->description}}</td>
                <td>{{count($projectObj->tasks)}}</td>

                <td><button type="button" data-projectid="{{$projectObj->id}}" data-name="{{$projectObj->name}}"
                            data-des="{{$projectObj->description}}" class="btn btn-warning btn-lg" data-toggle="modal"
                            data-target="#editProj">Edit
                    </button>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $projectArr->links()}}
    <div class="col-md-3 m-auto">
        <a href="{{action('UserController@index', $projectObj->id)}}" class="btn btn-warning ">Prev</a>
    </div>




    <div class="modal" tabindex="-1" role="dialog" id="editProj">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">

                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('projects.update','edit')}}" method="post">
                    {{method_field('patch')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="project_id" id="project_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mail">Description:</label>
                               <input type="text"  class="form-control" name="description" id="des">
                                <small class="text-danger">{{ $errors->first('description') }}</small>
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
