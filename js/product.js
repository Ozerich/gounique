function GetBonusText(bonus_block) {
    var bonus_type = $(bonus_block).find('.bonustype:checked').val();
    var period = InputToTime($(bonus_block).find('.bonus-von').val()) + " - " + InputToTime($(bonus_block).find(".bonus-bis").val()) + ' ';

    if (bonus_type == "night_bonus")
        return period + $(bonus_block).find('#from').val() + '=' + $(bonus_block).find('#to').val();
    else if (bonus_type == "long_stay")
        return period + "Longstay for " + $(bonus_block).find('#days_count').val() + " days " + $(bonus_block).find('#discount3').val() + "%";
    else if (bonus_type == "earlybird_days")
        return period + "Booking before " + $(bonus_block).find('#days').val() + " days " + $(bonus_block).find('#percent').val() + "%";
    else if (bonus_type == "earlybird_date")
        return period + "Booking till " + InputToTime($(bonus_block).find('.booking_till').val()) + " " + $(bonus_block).find('#discount2').val() + "%";
    else if (bonus_type == "turbo_bonus")
        return period + "Booking till " + InputToTime($(bonus_block).find('.booking_till_2').val()) + " " + $(bonus_block).find('#discount4').val() + "&euro;";
    else return "Unknown bonus";
}

$(document).ready(function () {

    $('#hotelcreate-page input#tlc').liveSearch({
        url:'product/hotel/tlc_search/',
        width:400
    });

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

        var row = $(block).find('tr.example').clone().removeClass('example').appendTo($(block).find('table')).show();
        $(row).find('input').each(
            function () {
                if ($(this).attr('for-name'))
                    $(this).attr('name', $(this).attr('for-name') + '[' + ($(block).find('.child-content tr').size() - 2) + ']');
            });

        $(block).find('.child-content input[type=checkbox]').click(function () {
            if (!$(this).is(':checked'))
                $(this).parents('tr').find('input[type=text]').attr('disabled', 'disabled');
            else
                $(this).parents('tr').find('input[type=text]').removeAttr('disabled');
        });


        return false;
    });

    $('#hotel_submit').click(function () {
        $('.child-content input[type=text]').each(
            function () {
                $(this).next().val($(this).val());
            });
        return true;
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

        $(bonus_block).find('input').setValidator({only_digits:true});

        $(bonus_block).show().find('.bonus-preview').hide();
        $(bonus_block).find('.bonus-content').show();

        $(bonus_block).find('input').each(function () {
            $(this).attr('name', $(this).attr('for-name') + '[' + $('.bonus-item:visible').size() + ']');
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

        $(bonus_block).find('.bonus-von, .bonus-bis, .booking_till, .booking_till_2').datepicker().datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');

        $(bonus_block).find('.bonustype').attr('name', 'bonustype[' + ($('.bonus-item:visible').size()) + ']');

        $(bonus_block).find('.bonusadd-submit').click(function () {
            $('#hotelcreate-page #bonus-page .empty').hide();

            var period = $(bonus_block).find('.bonus-von').val() + ' - ' + $(bonus_block).find('.bonus-bis').val();
            var val = $(bonus_block).find('.bonustype:checked').val();

            var text = GetBonusText(bonus_block);


            $(bonus_block).find('.bonus-preview p').html(text);

            $(bonus_block).find('.bonus-preview').show();
            $(bonus_block).find('.bonus-content').hide();

            $('#bonusnew-open').show();
            return false;
        });

        $(bonus_block).find('.bonustype').click(function () {
            $(this).parents('.bonus-item').find('.bonus-block').removeClass('active');
            $(this).parents('.bonus-block').addClass('active');
        });

        $('#bonusnew-open').hide();
        return false;
    });

    $('#hotelcreate-page .bonus-item').not('.example').find('.bonus-von, .bonus-bis, .booking_till, .booking_till_2').each(function () {
        var old_val = $(this).val();
        $(this).datepicker().datepicker("option", "showAnim", "blind").datepicker("option", "dateFormat", 'ddmmyy');
        $(this).val(old_val);
    });

    $('#hotelcreate-page .bonusadd-submit').click(function () {
        $('#hotelcreate-page #bonus-page .empty').hide();

        var bonus_block = $(this).parents('.bonus-item');

        var period = $(bonus_block).find('.bonus-von').val() + ' - ' + $(bonus_block).find('.bonus-bis').val();
        var val = $(bonus_block).find('.bonustype:checked').val();

        var text = GetBonusText(bonus_block);

        $(bonus_block).find('.bonus-preview p').html(text);

        $(bonus_block).find('.bonus-preview').show();
        $(bonus_block).find('.bonus-content').hide();

        $('#bonusnew-open').show();
        return false;
    });

    $('#hotelcreate-page .bonustype').click(function () {
        $(this).parents('.bonus-item').find('.bonus-block').removeClass('active');
        $(this).parents('.bonus-block').addClass('active');
    });

    $('#hotelcreate-page .bonusadd-cancel').click(function () {
        if ($('#hotelcreate-page').parents('.bonus-item').find('.bonus-preview p').html() == '')
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

    $('#price-page #price-table tr').click(function () {
        var period_id = $(this).find('#period_id').val();
        $('.price-block #price-loader').show();
        $('input[name=period_id]').val(period_id);

        $('#price-page #price-table tr').removeClass('current');
        $(this).addClass('current');

        $('#price-page .price-input input').attr('disabled', 'disabled').val('');
        $('#price-page .datum-block #von').val($(this).find('.period_start').val());
        $('#price-page .datum-block #bis').val($(this).find('.period_finish').val());
        $('#price-page .datum-block #zimmerkontigent').val($(this).find('.zimmer_kontigent').html());
        $('#price-page .datum-block #relis').val($(this).find('.relis').html());
        $('#price-page .price-input input[name=erw_price]').val($(this).find('.period_price').html());
        $('#price-page .price-input input[name=marge_price]').val($(this).find('.price_marge').html());
        $('#price-page .price-input input[name=erm_price]').val($(this).find('.price_erm').html());
        $('#price-page .price-input input[name=marge_meal]').val($(this).find('.meal_marge').html());
        $('#edit-price').show();
        $('#price-page .price-input .percent_price1, #price-page .price-input .percent_price2').val('');
        $.ajax({
            url:'product/hotel/ajax_period/' + period_id,
            success:function (data) {
                data = jQuery.parseJSON(data);

                for (var age_id in data) {
                    for (var service_id in data[age_id])
                        $('input[name="meal[' + age_id + '][' + service_id + ']"]').val(data[age_id][service_id]);

                    if (age_id > 0) {
                        $('input[name="price1[' + age_id + ']"]').val(data[age_id]['price'][1]);
                        $('input[name="price2[' + age_id + ']"]').val(data[age_id]['price'][2]);
                    }
                }


                $('.price-block #price-loader').hide();
                $('#price-page .price-input input').removeAttr('disabled');
            }
        });
        return false;
    });

    $('#price-page .price-input .price1').keyup(function () {
        $(this).parents('tr').find('.percent_price1').val('');
    });

    $('#price-page .price-input .price2').keyup(function () {
        $(this).parents('tr').find('.percent_price2').val('');
    });

    $('#price-page .price-input .percent_price1').keyup(function () {
        var base_price = $('.price-input .base_price').val();
        $(this).parents('tr').find('.price1').val(Math.round(base_price - (base_price / 100 * $(this).val())));
    });

    $('#price-page .price-input .percent_price2').keyup(function () {
        var base_price = $('.price-input .base_price').val();
        $(this).parents('tr').find('.price2').val(Math.round(base_price - (base_price / 100 * $(this).val())));
    });


    $('.hotellist-top .search-hotel').keyup(function () {
        $.ajax({
            url:'product/hotel/search_hotel',
            data:'search=' + $(this).val(),
            type:'post',
            success:function (data) {
                $('#hotel-list tbody').html(data);
            }
        });
    });

    $('.hotellist-top .search-tour').keyup(function () {
        $.ajax({
            url:'product/rundreise/search_tour',
            data:'search=' + $(this).val(),
            type:'post',
            success:function (data) {
                $('#hotel-list tbody').html(data);
            }
        });
    });

    $('.datum-block #von, .datum-block #bis').datepicker({
        changeMonth:true,
        changeYear:true
    }).datepicker("option", "showAnim", "blind").datepicker("option", "dateFormat", 'ddmmyy');


    $('#hotel-list tr').click(function () {
        $('#hotel-list tr').removeClass('current');
        $('.submenu ul').hide();
        $(this).addClass('current');
        $(this).find('.submenu ul').show();
    });
});
