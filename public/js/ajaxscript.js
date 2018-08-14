var url = "http://localhost:8080/blog/public/productajaxCRUD";


$(document).on('click','.open_modal',function(){
    var user_id = $(this).val();

    $.get(url + '/' + user_id, function (data) {
        //success data
        console.log(data);
        $('#user_id').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.details);
        $('#btn-save').val("update");
        $('#myModal').modal('show');
    })
});