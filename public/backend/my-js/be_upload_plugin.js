
$(function() {
    var var_img = "";
    var var_url = "";
});
var pagex = 1;

function getAjaxFiles(){
    pagex = pagex + 1;
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': pagex
    }
    var url = base_url+'upload/search-file';
    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#append-file').append(data.response_view);
    });
}

function change_tab(id) {
    if (id==1)
        $('#applyFile').attr({'onclick':"applyFile('"+var_img+"')"});
    else 
        $('#applyFile').attr({'onclick':"uploadFile('"+var_img+"')"});
}

function getFiles(id) {
    pagex = 1;
    var url = base_url + 'upload/listfiles';
    $.ajax({
        url: url,
        method: 'get',
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#form-upload').html(data.response_view);
    });
    var_img = id;
}

function selectFile(id) {
    $('.lib-image').css({
        border:"0"
    });

    $(id).css({
        border:"3px solid #00C543"
    });
    var_url = $(id).attr('src');
    $('#applyFile').attr({'onclick':"applyFile('"+var_img+"')"});
}

function uploadFile(id) {
    url = base_url + 'upload/uploadfile';
    $.ajax({
        url: url,
        dataType:'json',
        method: 'post',
        data: new FormData($("#form_submit")[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $(id+"_show").attr('src', data.url);
        $('#form-upload').modal('hide');
    });
}

function applyFile(id) {
    $(id).val(var_url);
    $(id+"_show").attr('src', var_url);
    $('#form-upload').modal('hide');
}