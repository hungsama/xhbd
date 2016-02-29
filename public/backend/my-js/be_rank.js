$(document).on('click','.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': page,
        'title': $('#title-current').val(),
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
        'title': $('#title-search').val(),
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

function resetRank(cate_id, rank) {
    var url = base_url+'club/listRank';
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        cate_id : cate_id,
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

function resetClub(cate_id, id_reset) {
    var url = base_url+'club/resetClub';
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        cate_id : cate_id
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
        $('#'+id_reset).html(data.response_view);
        $('#place-show').html(data.response_rank_view);
    });
}

function changeNation(nation_id, place) {
    url = base_url+'rank/changeNation';
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        club_type : place,
        nation_id : nation_id
    }
    console.log(posts);

    $.ajax({
        url: url,
        method: 'post',
        data: posts,
        beforeSend: function() {
            tsp([0,100],'success');
        }
    }).done(function(data){
        $('#tsp').remove();
        $('#'+place).html(data.response_view);
    });
}
