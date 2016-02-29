function deleteRecord(id, msg) {
    swal(
    {   
        title: msg,   
        type: "warning",
        showCancelButton: true,   
        confirmButtonColor: "#149B1D",
        confirmButtonText: "Accept",   
        cancelButtonText: "Cancel",   
        closeOnConfirm: false,   closeOnCancel: false }, 
        function(isConfirm){   
            if (isConfirm) {     
                $(id).submit();
            }else{
                swal({
                   title: "Auto close alert!",   
                   text: "I will close in 2 seconds.",   
                   timer: 0,   
                   showConfirmButton: false 
                });
            }
        }
    );
}

function submitform(id, msg) {
    var username = $('#username').val();
    var password = $('#password').val();
    swal(
    {   
        title: msg,   
        type: "warning",
        showCancelButton: true,   
        confirmButtonColor: "#149B1D",
        confirmButtonText: "Accept",   
        cancelButtonText: "Cancel",   
        closeOnConfirm: false,   closeOnCancel: false }, 
        function(isConfirm){   
            if (isConfirm) {     
                $(id).submit();
            }else{
                swal({
                   title: "Auto close alert!",   
                   text: "I will close in 2 seconds.",   
                   timer: 0,   
                   showConfirmButton: false 
                });
            }
        }
    );
}

function changeStatus(url, id, status) {
    var posts = {
        id:id, 
        status:status,
        url:url,
        _token: $('meta[name=_token]').attr('content')
    };
    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            // tsp([0,100],'success');
        }
    }).done(function(data){
        if (data.error != 0) {
            sweetAlert("Error!", data.msg, "error");
        } else 
            $('.change-status-'+id).html(data.data);
    });
}