$(document).on('click','.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': page,
        'title': $('#name-current').val(),
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
        'title': $('#name-search').val(),
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
        $('#tsp').remove();
        $('#content').html(data.response_view);
        $('#search-hidden').html(data.current_search_view);
    });
}

function changeParent(number, cate_parent_id) {
    url = base_url+'category/listRank';
    if (number == 1)
        $('#cate-parent').hide();
    else
        $('#cate-parent').show();
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        is_parent : number,
        cate_parent_id : cate_parent_id
    }
    $("#parent").val($("#parent option:first").val());

    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#place-show').html(data.response_view);
    });
}

function resetRank(cate_parent_id, rank) {
    var url = base_url+'category/listRank';
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        cate_parent_id : cate_parent_id,
        is_parent : 0,
        rank : rank
    };

    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#place-show').html(data.response_view);
    });
}

