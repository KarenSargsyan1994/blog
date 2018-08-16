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
            <th>Edit</th>


        </tr>
        </thead>
        <tbody>
        <br/>
        @foreach($taskArr as $taskObj)
            <tr>
                <td>{{$taskObj->id}}</td>


                <td> {{$taskObj->name}}</td>
                <td>{{$taskObj->description}}</td>

                <td>
                    <button type="button" data-taskid="{{$taskObj->id}}"
                            class="btn btn-warning " data-toggle="modal"
                            data-target="#editTask">Edit
                    </button>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $taskArr->links()}}
    <div class="col-md-3 m-auto">
        <a href="{{action('UserController@index')}}" class="btn btn-warning ">Prev</a>
    </div>



    <div class="modal" id="editTask">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="taskForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" id="task_id" value="">
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
                            <button class="btn btn-success" id="taskSubm">Save changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('#editTask').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var taskId = button.data('taskid');
                $.ajax({
                    type: 'get',
                    url: '/editTask',
                    data: {id: taskId},
                    success: function (data) {
                        $('.modal-body #name').val(data['name']);
                        $('.modal-body #des').val(data['description']);
                        $('.modal-body #task_id').val(data['id']);

                    }
                });

            });

            $('#taskSubm').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '/updateTask',
                    data: $('form.taskForm').serialize(),

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