@extends('layouts.content')
@section('content')
    <br/>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">


    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br/>
    @endif
    {{--@php dd($searchArr); @endphp--}}
    <div class="container  border border-default p-0">
        <form action="/index" method="get">

            <div class="form-group m-0">
                <div class="input-group">
                    <div class="col-3 p-0 mr-2">
                        <input type="text" class="form-control" name="search"
                               value="{{$searchArr['search']}}"></div>


                    <select name="select" class="btn btn-info col-2 mr-2" value="">
                        <option value="name" {{$searchArr['select']=='name'?'selected':''}}> name</option>
                        <option value="email"{{$searchArr['select']=='email'?'selected':''}}>email</option>
                    </select>
                    <div class="btn-group btn-group-toggle mr-2" data-toggle="buttons">
                        <label class="btn btn-dark active">

                            <input type="radio" name="sort" id="asc" value="asc"
                                   autocomplete="off" {{$searchArr['sort'] == 'asc' ? 'checked' : ''}}> ASC
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="sort" id="desc" value="desc"
                                   autocomplete="off" {{$searchArr['sort'] == 'desc' ? 'checked' : ''}}> DESC
                        </label>
                    </div>

                    <span class=" col-1 btn-success  btn-group-vertical p-0"> <p class="m-auto">More than</p></span>
                    <div class="col-1 p-0 ">
                        <input type="text" class="form-control" id="max" name="max" value="{{$searchArr['max']}}">
                    </div>
                    <span class=" col-1 btn-success  btn-group-vertical text-md-center p-0"><p
                                class="m-auto">Less than</p></span>
                    <div class="col-1 p-0 mr-2">
                        <input type="text" class="form-control" id="min" name="min" value="{{$searchArr['min']}}">
                    </div>

                    <button type="submit" id="bt" class="btn btn-primary col-1">Search</button>

                </div>
            </div>
        </form>
    </div>







    <table class="table table-bordered table-hover ">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Projects</th>
            <th>Tasks</th>
            <th>Edit</th>
            <th colspan="2">Delate</th>
        </tr>
        </thead>
        <tbody>
        <br/>
        {{--<@php dd($userArr) @endphp--}}

        @foreach($userArr as $userObj)
            <tr>
                <td>{{$userObj->id}}</td>
                <td><a href="{{action('ProjectController@projects',$userObj->id)}}"
                       class="btn">{{$userObj->name}} </a></td>
                <td>{{$userObj->email}}</td>
                <td>
                    {{count($userObj->projects)}}
                </td>
                <td><a href="{{action('TaskController@tasks',$userObj->id)}}" class="btn">{{count($userObj->tasks)}}</a>
                </td>
                <td>
                    <button type="button" data-userid="{{$userObj->id}}"
                            class="btn btn-warning" data-toggle="modal"
                            data-target="#edit"
                    >Edit
                    </button>


                </td>


                <td>
                    <form action="{{action('UserController@destroy', $userObj->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    {{ $userArr->appends(Request::except('page'))->links()}}




    <div class="offset-5 ">
        <a href="{{action('HomeController@index')}}" class="btn btn-warning">Home</a></div>



    <div class="modal" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <form class="content">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <small name='name' class="text-danger "></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mail">E-mail:</label>
                                <input type="text" class="form-control" name="email" id="email">
                                <small name="email" class="text-danger "></small>
                            </div>
                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success" id="ajaxSubmit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>







    <script>
        $(document).ready(function () {

            $('#edit').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('userid');
                $.ajax({
                    type: 'get',
                    url: 'editUser',
                    data: {id: userId},
                    success: function (data) {
                        $('.modal-body #name').val(data['name']);
                        $('.modal-body #email').val(data['email']);
                        $('.modal-body #user_id').val(data['id']);


                    }
                });
            });

            $('#ajaxSubmit').on('click', function (e) {
                e.preventDefault();
                var formData = $('form.content').serialize();


                $.ajax({
                    type: 'post',
                    url: 'updateUser',
                    data: formData,
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

            });
            $('#bt')

        });
    </script>

@endsection