<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>edit page</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta name="_token" content="{{ csrf_token() }}"/>
</head>
<body>
<div class="container">

    @yield('content')

</div>
<script>
    $('#edit').on('shown.bs.modal', function (event) {


        var button = $(event.relatedTarget);
        var name = button.data('name');
        var email = button.data('email');
        var userId = button.data('userid');

        var modal = $(this);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #user_id').val(userId);


    });

    $('#ajaxSubmit').click( function () {
console.log('kjskdf');
        $.ajax({
            type: 'post',
            url: '/editUser',
            data: {
                '_token':$('input[name=_token]').val(),
                'id': $("#user_id").val(),
                'email': $('#email').val(),
                'name':$('#name').val(),

            },
            success:function (data) {

            }
        })


    })
















    //    $('#editProj').on('shown.bs.modal', function (event) {
    //
    //
    //        var button = $(event.relatedTarget);
    //        var name = button.data('name');
    //        var des = button.data('des');
    //        var projectId = button.data('projectid');
    //
    //        var modal = $(this);
    //        modal.find('.modal-body #name').val(name);
    //        modal.find('.modal-body #des').val(des);
    //        modal.find('.modal-body #project_id').val(projectId);
    //
    //    })


</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>
</html>