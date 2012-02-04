$(document).ready(function () {
    $('#hotelcreate-page #tabs span').click(function () {
        $('#tabs li').removeClass('active').each(function () {
            $('#' + $(this).find('span').attr('for')).hide();
        });

        $('#' + $(this).attr('for')).show();

        $(this).parent().addClass("active");

    });

    $('#hotelcreate-page #zimmer-value').liveSearch({
        url:'product/hotels/livesearch/room/',
        onSelect:function (data) {
            $('#hotelcreate-page #zimmer_id').val(data.room_id);
        }
    });

    $('#hotelcreate-page #zimmer-add').click(function () {
        var room_id = $('#zimmer_id').val();

        if (!room_id)
            return false;

        var new_item = $('.zimmer-list .item.example').clone().appendTo('.zimmer-list');

        $(new_item).removeClass('example').show().find('.room_id').attr('name', 'room_id[' + ($('.item').size() - 1) + ']').val(room_id);
        $(new_item).find('.zimmer-name').html($('.zimmer-new #zimmer-value').val());
        $(new_item).find('.zimmer-delete').click(function () {
            $(this).parents('.item').remove();
            return false;
        });

        $('#zimmer_id').val('');
        $('.zimmer-new #zimmer-value').val('');

        return false;
    });

    $('#hotelcreate-page .zimmer-delete').click(function () {
        $(this).parents('.item').remove();
        return false;
    });

    $('#hotelcreate-page .child-preview input[type=checkbox]').click(function () {
        if ($(this).is(':checked'))
            $(this).parents('.child-cat').find('.child-content').show();
        else
            $(this).parents('.child-cat').find('.child-content').hide();
    });

    $('#hotelcreate-page .child-content input[type=checkbox]').click(function () {
        if (!$(this).is(':checked'))
            $(this).parents('tr').find('input[type=text]').attr('disabled', 'disabled');
        else
            $(this).parents('tr').find('input[type=text]').removeAttr('disabled');
    });

    $('#hotelcreate-page .child-cat .child-new').click(function () {
        var block = $(this).parents('.child-cat');

        var row = $(block).find('tr.example').clone().removeClass('example').appendTo($(block).find('table')).show().
            find('input').each(
            function () {
                if ($(this).attr('for-name'))
                    $(this).attr('name', $(this).attr('for-name') + '[' + ($(block).find('.child-content tr').size() - 2) + ']');
            }).find('input[type=text]').keyup(
            function () {
                $(this).next().val($(this).val());
            });

        $(block).find('.child-content input[type=checkbox]').click(function () {
            if (!$(this).is(':checked'))
                $(this).parents('tr').find('input[type=text]').attr('disabled', 'disabled');
            else
                $(this).parents('tr').find('input[type=text]').removeAttr('disabled');
        });


        return false;
    });

    $('#hotelcreate-page .child-cat .child-content input[type=text]').keyup(function () {
        $(this).next().val($(this).val());
    });

    $('#hotelcreate-page #new-minimum').click(function () {

        var new_item = $('.minimum-item.example').clone().removeClass('example').appendTo('.minimum-list').show();

        $(new_item).find('.minimum-von').attr('name', 'minimum_von[' + ($('.minimum-item').size() - 1) + ']');
        $(new_item).find('.minimum-bis').attr('name', 'minimum_bis[' + ($('.minimum-item').size() - 1) + ']');
        $(new_item).find('.minimum-nights').attr('name', 'minimum_nights[' + ($('.minimum-item').size() - 1) + ']');

        $('#hotelcreate-page .minimum-list .empty').hide();

        $(new_item).find('.minimum-delete').click(function () {
            $(this).parents('.minimum-item').remove();

            if ($('#hotelcreate-page .minimum-item').size() < 2)
                $('#hotelcreate-page .minimum-list .empty').show();

            return false;
        });

        $(new_item).find('.minimum-von, .minimum-bis').
            datepicker().
            datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');


        return false;
    });

    $('#hotelcreate-page .minimum-item').not('.example').find('.minimum-von, .minimum-bis').each(function () {
        var a = $(this).val();
        $(this).datepicker().datepicker("option", "showAnim", "blind").datepicker("option", "dateFormat", 'ddmmyy');
        $(this).val(a);
    });

    $('#hotelcreate-page .minimum-delete').click(function () {
        $(this).parents('.minimum-item').remove();

        if ($('#hotelcreate-page .minimum-item').size() < 2)
            $('#hotelcreate-page .minimum-list .empty').show();

        return false;
    });


    $('#hotelcreate-page .bonus-type input[type=radio]').click(function () {
        if ($('#hotelcreate-page .bonus-type #bonus_1').is(':checked')) {
            $('#hotelcreate-page #bonus_1_page').show();
            $('#hotelcreate-page #bonus_2_page').hide();
        }
        else {
            $('#hotelcreate-page #bonus_1_page').hide();
            $('#hotelcreate-page #bonus_2_page').show();
        }
        return false;
    });

    $('#hotelcreate-page #bonusadd-cancel').click(function () {
        $('#bonus-new').hide();
        $('#bonusnew-open').show();
        return false;
    });

    $('#hotelcreate-page #bonusnew-open').click(function () {
        var bonus_block = $('.bonus-item.example').clone().removeClass('example');
        $(bonus_block).appendTo('.bonus-list');

        $(bonus_block).show().find('.bonus-preview').hide();
        $(bonus_block).find('.bonus-content').show();

        $(bonus_block).find('input').each(function () {
            $(this).attr('name', $(this).attr('for') + '[' + $('.bonus-item:visible').size() + ']');
        });

        $(bonus_block).find('.bonusadd-cancel').click(function () {
            if ($(bonus_block).find('.bonus-preview p').html() == '')
                $(this).parents('.bonus-item').remove();
            else {
                $(this).parents('.bonus-item').find('.bonus-preview').show();
                $(this).parents('.bonus-item').find('.bonus-content').hide();
            }

            $('#bonusnew-open').show();
            return false;
        });

        $(bonus_block).find('.bonus-edit').click(function () {
            $(this).parents('.bonus-item').find('.bonus-preview').hide();
            $(this).parents('.bonus-item').find('.bonus-content').show();
            return false;
        });

        $(bonus_block).find('.bonus-delete').click(function () {
            $(this).parents('.bonus-item').remove();
            if ($('#hotelcreate-page #bonus-page .bonus-item:visible').size() == 0)
                $('#hotelcreate-page #bonus-page .empty').show();
            return false;
        });

        $(bonus_block).find('.bonus-von, .bonus-bis').datepicker().datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');

        $(bonus_block).find('.bonustype').attr('name', 'bonustype[' + ($('.bonus-item:visible').size()) + ']');

        $(bonus_block).find('.bonusadd-submit').click(function () {
            $('#hotelcreate-page #bonus-page .empty').hide();

            var period = $(bonus_block).find('.bonus-von').val() + ' - ' + $(bonus_block).find('.bonus-bis').val();
            var val = $(bonus_block).find('.bonustype:checked').val();

            var text = '';
            if (val == 1)
                text = 'Bonus von ' + $(bonus_block).find('#from').val() + '=' + $(bonus_block).find('#to').val() +
                    ' Gultig fur den Reisezeitraum: ' + period;
            else if (val == 2)
                text = period + ' - ' + $(bonus_block).find('#days').val() + ' Tage vor Hotelankuft getatigate Buchungen erhalten ' +
                    $(bonus_block).find('#percent').val() + '% Ermabigurg';

            $(bonus_block).find('.bonus-preview p').html(text);

            $(bonus_block).find('.bonus-preview').show();
            $(bonus_block).find('.bonus-content').hide();

            $('#bonusnew-open').show();
            return false;
        });

        $('#bonusnew-open').hide();
        return false;
    });

    $('#hotelcreate-page .bonusadd-cancel').click(function () {
        if ($('#hotelcreate-page').find('.bonus-preview p').html() == '')
            $(this).parents('.bonus-item').remove();
        else {
            $(this).parents('.bonus-item').find('.bonus-preview').show();
            $(this).parents('.bonus-item').find('.bonus-content').hide();
        }
        $('#bonusnew-open').show();
        return false;
    });

    $('#hotelcreate-page .bonus-delete').click(function () {
        $(this).parents('.bonus-item').remove();
        return false;
    });

    $('#hotelcreate-page .bonus-edit').click(function () {
        $(this).parents('.bonus-item').find('.bonus-preview').hide();
        $(this).parents('.bonus-item').find('.bonus-content').show();
        return false;
    });

    $('#hotelcreate-page .bonusadd-submit').click(function () {
        $('#hotelcreate-page #bonus-page .empty').hide();

        var period = $('#hotelcreate-page').find('.bonus-von').val() + ' - ' + $(bonus_block).find('.bonus-bis').val();
        var val = $('#hotelcreate-page').find('.bonustype:checked').val();

        var text = '';
        if (val == 1)
            text = 'Bonus von ' + $('#hotelcreate-page').find('#from').val() + '=' + $('#hotelcreate-page').find('#to').val() +
                ' Gultig fur den Reisezeitraum: ' + period;
        else if (val == 2)
            text = period + ' - ' + $('#hotelcreate-page').find('#days').val() + ' Tage vor Hotelankuft getatigate Buchungen erhalten '
                + $('#hotelcreate-page').find('#percent').val() + '% Ermabigurg';

        $('#hotelcreate-page').find('.bonus-preview p').html(text);

        $('#hotelcreate-page').find('.bonus-preview').show();
        $('#hotelcreate-page').find('.bonus-content').hide();

        $('#bonusnew-open').show();

        return false;
    });

    $('#hotelcreate-page .bonus-item:visible').find('.bonus-von, .bonus-bis').datepicker().
        datepicker("option", "showAnim", "blind").
        datepicker("option", "dateFormat", 'ddmmyy');


    $('.room-page #persons-page .delete-icon').click(function () {
        $(this).parents('tr').remove();
        return false;
    });

    $('.room-page #persons-page #add-difference').click(function () {

        var row = $('.room-page #persons-page table tr.example').clone().removeClass('example').
            appendTo($('.room-page #persons-page table')).show();

        $(row).find('.delete-icon').click(function () {
            $(this).parents('tr').remove();
            return false;
        });

        $(row).find('input').each(function () {
            $(this).attr('name', $(this).attr('for-name') + '[' + ($(this).parents('table').find('tr').size() - 2) + ']');
        });

        return false;
    });

    $('.room-page #room-subtabs li').click(function () {

        $('.room-page #room-subtabs li').removeClass('active').each(function () {
            $('#' + $(this).attr('for-page')).hide();
        });

        $('#' + $(this).attr('for-page')).show();
        $(this).addClass("active");
        return false;
    });

});
