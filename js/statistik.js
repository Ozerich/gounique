$(document).ready(function()
{
    $("#datestart, #dateend").datepicker().datepicker("option", "showAnim", "blind").
        datepicker("option", "dateFormat", 'ddmmyy');

    $('#brutto-submit').click(function()
    {
        $.ajax({
            url: 'statistik/count_brutto',
            type: 'post',
            data: 'date_start=' + $('#datestart').val() + '&date_end=' + $('#dateend').val(),
            success: function(data)
            {
                $('#brutto-count .result .value').html(data);
            }
        });
        return false;
    })
});