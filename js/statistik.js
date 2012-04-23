
function update_daily_statistic_events(){
    $('.statictic-table tr.day').click(function(){
        $(this).next().toggle();
    });
}

$(document).ready(function () {
    $('#search_button.paymenttype-button').click(function () {

        $('#statistics-loader').show();
        $('#search_button').attr('disabled', 'disabled');
        $('#statistics-list, #previewstats-list').hide();

        var data = $('#search-form').serialize();

        $.ajax({
            url:'statistik/search',
            type:'post',
            data:data,
            success:function (data) {
                $('#statistik_table-wr').empty().html(data);
            },
            complete:function () {
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

    $('#clear_search').click(function () {
        $('.search-block input, .search-block select').val('');
        $('.search-block input[type=checkbox], .table-fields input[type=checkbox]').attr('checked', 'checked');
        $('#search_button').click();
        return false;
    });


    $('#daily_statistic .tabs a').click(function () {
        $('#daily_statistic .tabs li').removeClass('active');
        $('.statistic-tabpage').hide();
        $('#' + $(this).attr('for')).show();
        $(this).parent().addClass("active");

        return false;
    });

    $('#daily_statistic .date-period input[type=text]').setdatepicker();

    $('#daily_statistic #search_button').click(function(){
        $('#daily_statistic_loading').show();
        $(this).hide();

        $.post('statistik/daily', $('#daily_statistic_filter').find('*').serialize(), function(data){
            data = jQuery.parseJSON(data);

            $('#statistic_angebot_page table').html(data.angebot);
            $('#statistic_rechnung_page table').html(data.rechnung);

            $('#daily_statistic_loading').hide();
            $('#daily_statistic #search_button').show();

            update_daily_statistic_events();
        });

        return false;
    });

    update_daily_statistic_events();
});
