$(document).ready(function(){
    $('#search_button').click(function(){

        $('#statistics-loader').show();
        $('#search_button').attr('disabled', 'disabled');
        $('#statistics-list, #previewstats-list').hide();

        var data = $('#search-form').serialize();

        $.ajax({
            url: 'statistik/search',
            type: 'post',
            data: data,
            success: function(data){
                $('#statistik_table-wr').empty().html(data);
            },
            complete: function(){
                $('#statistics-list, #previewstats-list').show();
                $('#statistics-loader').hide();
                $('#search_button').removeAttr('disabled');
            }
        });

        return false;
    });

    $('.search-block #ag_num').liveSearch({
            url:'kundenverwaltung/livesearch/',
            width:400
        });

    $('#search-von, #search-bis').setdatepicker();

    $('#clear_search').click(function(){
        $('.search-block input, .search-block select').val('');
        $('.search-block input[type=checkbox], .table-fields input[type=checkbox]').attr('checked', 'checked');
        $('#search_button').click();
        return false;
    });
});