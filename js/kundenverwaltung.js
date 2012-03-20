function FindProvisionError(block) {
    $(block).find('input').each(function () {
        if ($(this).val() != '')
            $(this).removeClass('error');
        else
            $(this).addClass('error');
    });

    if (parseInt($(block).find('.from input').val()) >= parseInt($(block).find('.to input').val()))
        $(block).find('.from input, .to input').addClass('error');
    else
        $(block).find('.from input, .to input').removeClass('error');

    return $(block).find('input.error').size() > 0;
}

function UpdateProvisionLevels() {
    $('#provisionlevels-list tbody tr').click(function () {
        if ($(this).hasClass('new-line'))
            return false;
        if ($(this).hasClass('current')) {
            $(this).find('span').hide();
            $(this).find('input, a').show();
            $(this).find('.delete-level').hide();
        }
        else {
            $('#provisionlevels-list tbody tr').removeClass('current');
            $(this).addClass('current');
        }
    });

    $('#provisionlevels-list tbody tr a.save').click(function () {

        if (FindProvisionError($(this).parents('tr')))
            return false;

        var block = $(this).parents('tr');
        $(block).find('.save').hide();
        $(block).find('input').attr('disabled', 'disabled');


        $(block).find('.loading').show();
        $.ajax({
            url:'provisionierung/' + $(block).find('.level_id').val(),
            type:'post',
            data:'from=' + $(block).find('.from input').val() + '&to=' + $(block).find('.to input').val() + '&percent=' +
                $(block).find('.percent input').val(),
            success:function () {
                $(block).find('input').removeAttr('disabled').hide();
                $(block).find('.loading').hide();
                $(block).find('.from span').html($(block).find('.from input').val()).show();
                $(block).find('.to span').html($(block).find('.to input').val()).show();
                $(block).find('.percent span').html($(block).find('.percent input').val()).show();
                $(block).find('.delete-level').show();
            }
        });

        return false;
    });

    $('#provisionlevels-list tbody tr a.delete-level').click(function () {
        block = $(this).parents('tr');
        $("#delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            title:'Delete Confirmation',
            buttons:{
                "Delete":function () {
                    $.ajax({
                        url:'provisionierung/delete/' + $(block).find('.level_id').val(),
                        success:function (data) {
                            $('#provisionlevels-list tbody').empty().html(data);
                            UpdateProvisionLevels();
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel:function () {
                    $(this).dialog("close");
                }
            }
        });
        return false;
    });

    $('#provisionlevels-list a.new-level').click(function () {
        $(this).parents('tr').find('input,.add-new').show();
        $(this).hide();
        return false;
    });

    $('#provisionlevels-list .new-line .add-new').click(function () {

        if (FindProvisionError('#provisionlevels-list .new-line'))
            return false;

        $(this).hide();

        $('.new-line input').attr('disabled', 'disabled');
        $('.new-line .loading').show();

        $.ajax({
            url:'provisionierung/new',
            type:'post',
            data:'from=' + $('.new-line .from input').val() + '&to=' + $('.new-line .to input').val() + '&percent=' + $('.new-line .percent input').val(),
            success:function (data) {
                $('#provisionlevels-list tbody').empty().html(data);
                UpdateProvisionLevels();
            }
        });

        return false;
    });
}

$(document).ready(function () {

    $('.contact-block .block-header').click(function () {
        if ($(this).parents('.contact-block').find('.contact-content').is(':hidden')) {
            $(this).parents('.contact-block').find('.contact-content').slideDown();
            $(this).removeClass('closed');
        }
        else {
            $(this).parents('.contact-block').find('.contact-content').slideUp();
            $(this).addClass('closed');
        }
    });

    $('#new-ketten-page #submit-button').click(function () {

        if ($('#new-ketten-page #name').val())
            return true;
        $('#new-ketten-page #name').addClass('error');
        return false;
    });

    $('.kundenverwaltung-rasdel .delete-link').click(function (e) {
        var link = $(this);
        $("#delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            title:'Delete Confirmation',
            buttons:{
                "Delete":function () {
                    document.location = $(link).attr('href');
                },
                Cancel:function () {
                    $(this).dialog("close");
                }
            }
        });

        return false;
    });

    UpdateProvisionLevels();

    $('#new-incoming-page #submit-button').click(function () {

        if ($('#new-incoming-page #name').val())
            return true;
        $('#new-incoming-page #name').addClass('error');
        return false;
    });

    $('#new-agenturen-page #submit-button').click(function () {
        if ($('#new-agenturen-page #name').val())
            return true;
        $('#new-agenturen-page #name').addClass('error');
        return false;
    });

    $('#new-stammkunden-page #submit-button').click(function () {

        $('#new-stammkunden-page').find('#name, #surname').each(function () {
            if ($(this).val() == '')
                $(this).addClass('error');
            else
                $(this).removeClass('error');
        });

        return $('#new-stammkunden-page input.error').size() == 0;

    });


    $('.kundenverwaltung-rasdel .search-block #search-input').keyup(function () {
        $.post('kundenverwaltung/search/' + $('#search-type').val(), 'str=' + $('#search-input').val(), function (data) {
            $('.product-list tbody').html(data);
        });
    });

});

