$(document).on('click','.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': page,
        'admin_name': $('#admin-name-current').val(),
        'group_name': $('#group-name-current').val(),
        'status': $('#status-current').val(),
        'start_date': $('#start-date-current').val(),
        'end_date': $('#end-date-current').val()
    }
    getProducts(posts);
});

$(document).on('click', '#search-available', function(e) {
    e.preventDefault();
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': 1,
        'admin_name': $('#admin-name-search').val(),
        'group_name': $('#group-name-search').val(),
        'status': $('#status-search').val(),
        'start_date': $('#start-date-search').val(),
        'end_date': $('#end-date-search').val()
    }
    getProducts(posts);
});

function getProducts(posts){
    $.ajax({
        url: $('#search-paginate').attr('href'),
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        console.log(data);
        $('#tsp').remove();
        $('#content').html(data.response_view);
        $('#search-hidden').html(data.current_search_view);
    });
}

function getPermissions(id, type) {
    var url = base_url + 'auth/permission/'+ id+'/'+type;
    $.ajax({
        url: url,
        method: 'get',
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#per-group').html(data.response_view);
    });
}

function createGroup() {
    var url = base_url + 'auth/create-admin-group';
    $.ajax({
        url: url,
        method: 'get',
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#per-group').html(data.response_view);
    });
}

function saveGroup() {
    var url = base_url + 'auth/create-admin-group';
    var group_name = $('#group_name').val();
    var description = $('#description').val();
    var permissions = [];
    $('input:checkbox[name=permission]').each(function() 
    {    
        if($(this).is(':checked')) permissions.push($(this).val());
    });
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'group_name' : group_name,
        'description' : description,
        'permissions' : permissions
    }
    var error = '';
    if (group_name.length < 6) 
        error += 'The group name must be at least 6 characters.\n';
    if (description.length <6) 
        error += 'The description must be at least 6 characters.';

    if (error.length > 1) {
        swal("", error, "error");
        return;
    }
    console.log(posts);

    swal(
    {   
        title: "Are you sure create this group?",   
        type: "warning",
        showCancelButton: true,   
        confirmButtonColor: "#149B1D",
        confirmButtonText: "Accept",   
        cancelButtonText: "Cancel",   
        closeOnConfirm: false,   closeOnCancel: false }, 
        function(isConfirm){   
            if (isConfirm) {     
                $.ajax({
                    url: url,
                    method: 'post',
                    data: posts,
                    beforeSend: function() {
                        tsp([0,100],'success');
                    }
                }).done(function(data){
                    $('#tsp').remove();
                    if (data.error == 0) {
                        swal({
                           title: data.msg,   
                           type:'success',
                           text: "Page will refresh in 2 seconds.",   
                           timer: 2000,   
                           showConfirmButton: true 
                        }, function() {
                            location.href=base_url+'auth/admin-groups';
                        });
                    } else {
                        swal(data.msg, "You clicked the button!", "error");
                    }
                });
                  
            } else {     
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

function updatePermissionGroup(group_id, admin_id) {
    var url = base_url + 'auth/update-permission-group/'+group_id;
    var group_name = $('#group_name').val();
    var description = $('#description').val();
    var status = $('input[name=status]:checked').val();

    var error = "";
    if (group_name.length < 6) 
        error += 'The group name must be at least 6 characters.\n';
    if (description.length <6) 
        error += 'The description must be at least 6 characters.';

    if (error.length > 1) {
        swal("", error, "error");
        return;
    }

    var permissions = [];
    $('input:checkbox[name=permission]').each(function() 
    {    
        if($(this).is(':checked')) permissions.push($(this).val());
    });
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'group_name' : group_name,
        'description' : description,
        'permissions' : permissions,
        'admin_id' : admin_id,
        'status' : status
    }
    
    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        if (data.error == 0)
            swal(data.msg, "", "success");
        else 
            swal(data.msg, "", "error");
    });
}

function change_group(group_id) {
    $('#view_group').attr({"onclick":"getPermissions("+group_id+",0)"});
}

function change_role(role) {
    if(role=='limited') 
        $('#belog_group').show();
    else
        $('#belog_group').hide();
}