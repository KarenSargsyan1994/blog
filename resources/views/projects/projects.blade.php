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
                <td><a href="{{action('TaskController@projectTasks',$projectObj->id)}}"
                       class="btn">{{$projectObj->name}}</a>
                </td>
                <td>{{$projectObj->description}}</td>
                <td>{{count($projectObj->tasks)}}</td>

                <td>
                    <button type="button" data-projectid="{{$projectObj->id}}"
                            class="btn btn-warning " data-toggle="modal"
                            data-target="#editProject">Edit
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




    <div class="modal" id="editProject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="projectForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="project_id" id="project_id" value="">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <small name="name" class="text-danger"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mail">Description:</label>
                                <input type="text" class="form-control" name="description" id="des">
                                <small name="description" class="text-danger"></small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" id="projectSubmit">Save changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('#editProject').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var projectId = button.data('projectid');
                $.ajax({
                    type: 'get',
                    url: '/project/edit',
                    data: {id: projectId},
                    success: function (data) {
                        $('.modal-body #name').val(data['name']);
                        $('.modal-body #des').val(data['description']);
                        $('.modal-body #project_id').val(data['id']);
                        $('.modal-body #user_id').val(data['user_id']);

                    }
                });

            });

            $('#projectSubmit').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '/project/update',
                    data: $('form.projectForm').serialize(),

                    success: function (data) {
                        if ($.isEmptyObject(data.errors)) {

                            location.reload();
                        }
                        else {
                            $('.text-danger').each(function () {
                                $(this).text(data.errors[$(this).attr('name')])
                            });

                        }
                    }
                })

            })
        });
    </script>
@endsection
