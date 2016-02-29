$(document).on('click','.pagination a', function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var posts = {
        '_token': $('meta[name=_token]').attr('content'),
        'page': page,
        'current': $('#current-current').val(),
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
