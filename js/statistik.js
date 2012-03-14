$(document).ready(function(){
    $('#search_button').click(function(){

        $('#statistics-loader').show();
        $('#search_button').attr('disabled', 'disabled');
        $('#statistics-list').hide();

        var data = $('#search-form').serialize();

        $.ajax({
            url: 'statistik/search/',
            type: 'post',
            data: data,
            success: function(data){
                $('#statistik_table-wr').empty().html(data);
            },
            complete: function(){
                $('#statistics-list').show();
                $('#statistics-loader').hide();
                $('#search_button').removeAttr('disabled');
            }
        });

        return false;
    });
});