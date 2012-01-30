$(document).ready(function () {
    $('#hotelcreate-page #tabs span').click(function()
    {
        $('#tabs li').removeClass('active').each(function()
        {
            $('#' + $(this).find('span').attr('for')).hide();
        });

        $('#' + $(this).attr('for')).show();

        $(this).parent().addClass("active");

    });

    $('#hotelcreate-page #zimmer-add').click(function()
    {

        return false;
    });

    $('#hotelcreate-page #zimmer-delete').click(function()
    {
        $(this).parents('.item').remove();
        return false;
    });
});
