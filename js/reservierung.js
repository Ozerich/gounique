function BindDateEvents(hotel_block) {

    old1 = $(hotel_block).find('.date_start').val();
    old2 = $(hotel_block).find('.date_end').val();

    $(hotel_block).find('.date_start').datepicker({
        onSelect:function (date, inst) {
            $(hotel_block).find(".date_end").datepicker("option", "minDate", $(hotel_block).find('.date_start').val());
            $(hotel_block).find(".date_start").change();
            return true;
        },
        onClose:function () {
            $(this).focus();
        }
    });
    $(hotel_block).find(".date_start, .date_end").setdatepicker();

    $(hotel_block).find('.date_start').val(old1);
    $(hotel_block).find('.date_end').val(old2);

    $(hotel_block).find(".date_start, .date_end").
        bind('change', function (event) {

            var a = $(hotel_block).find('.date_start').val();
            var b = $(hotel_block).find('.date_end').val();

            if (!a || !b)
                return false;

            a = new Date(a.substr(4, 4), a.substr(2, 2) - 1, a.substr(0, 2));
            b = new Date(b.substr(4, 4), b.substr(2, 2) - 1, b.substr(0, 2));

            $(hotel_block).find('.days_count').val(Math.round((b - a) / 1000 / 3600 / 24));
        });


    $(hotel_block).find(".date_start").change(
        function () {
            if ($(this).val() != "")
                $(hotel_block).find(".date_end").change();
        }).bind('keypress', function (event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('.date_end').focus();
                return false;
            }
        });


    $(this).find(".date_end").datepicker({
        onSelect:function (date, inst) {
            $(hotel_block).find(".date_end").change();
            return true;
        },
        onClose:function () {
            $(this).focus();
        }
    }).bind('keypress', function (event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('.days_count').focus();
                $('#ui-datepicker-div').hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find('.date_start').focus();
                return false;
            }
        });

    $(hotel_block).find('.days_count').bind('keyup',
        function () {
            $(this).change();
        }).change(function () {

            if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                var a = $(hotel_block).find('.date_start').val();
                a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2) - 1), a.substr(0, 2));
                a.setDate(a.getDate() + parseInt($(this).val()));
                $(hotel_block).find('.date_end').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
            }
        });

}

function BindItemsBlockEvents(item_block) {

    var transfer_price = $(item_block).find('input#transfer_price');
    $(item_block).find('select#transfer').change(function () {
        if ($(this).val() == 'kein')
            $(transfer_price).attr('disabled', 'disabled').val('0');
        else
            $(transfer_price).removeAttr('disabled');
    });

    $(item_block).find('input#transfer_price, input#price, select#count, select#transfer').change(function () {
        var transfer_price = parseFloat($(item_block).find('#transfer_price').val());
        var price = parseFloat($(item_block).find('#price').val());
        transfer_price = isNaN(transfer_price) ? 0 : transfer_price;
        price = isNaN(price) ? 0 : price;
        var count = parseInt($(item_block).find('#count').val());
        $(item_block).find('.total-price .value').html((transfer_price + price) * count);
    });

    $(item_block).find('#date_enabled').change(function () {
        if ($(this).is(':checked'))
            $(this).parents('.params-block').find('input[type=text]').removeAttr('disabled');
        else
            $(this).parents('.params-block').find('input[type=text]').attr('disabled', 'disabled');
    });

    BindDateEvents(item_block);

    $(item_block).find('button.cancel').click(function () {
        $('#overlay-window .close').click();
        return false;
    });

    $(item_block).find('button.add').click(function () {
        $(item_block).find('button').attr('disabled', 'disabled');
        $(item_block).find('.alert-message').html('').hide();
        $.ajax({
            url:'reservierung/update_item/' + $('#formular_id').val(),
            data:$(item_block).find('*').serialize(),
            type:'post',
            success:function (data) {
                $('#item-list').html(data);
                BindItemsBlockEvents();
                $(item_block).reset().find('.alert-message.success').html('OK, added. You can add again').show();
            },
            complete:function () {
                $(item_block).find('button').removeAttr('disabled');
            },
            error:function () {
                $(item_block).find('.alert-message.error').html('<b>Error:</b>').show();
            }
        });
        return false;
    });

    $(item_block).find('button.save').click(function () {
        $(item_block).find('button').attr('disabled', 'disabled');
        $(item_block).find('.alert-message').html('').hide();
        $.ajax({
            url:'reservierung/update_item/' + $('#formular_id').val(),
            data:$(item_block).find('*').serialize(),
            type:'post',
            success:function (data) {
                $('#item-list').html(data);
                BindItemsBlockEvents();
                $(item_block).find('.alert-message.success').html('Item saved. You can close window').show();
            },
            complete:function () {
                $(item_block).find('button').removeAttr('disabled');
            },
            error:function () {
                $(item_block).find('.alert-message.error').html('<b>Error:</b>').show();
            }
        });
        return false;
    });

    $('#overlay-window .close').bind('click', function () {
        if (!$('#dark-overlay').hasClass('finished'))
            return false;
        $('#dark-overlay').click();
        $('#overlay-window .close').unbind('click');
        return false;
    });

    $(item_block).find('#price').change();
}

function edit_item(item_id, item_type) {
    OpenOverlay();
    $.get('reservierung/update_item/' + $('#formular_id').val() + '/' + item_id + '/' + item_type, function (data) {
        $('#edit-item').html(data);
        $('#overlay-window').empty().show();
        $('#edit-item').clone().appendTo('#overlay-window').show();
        $('#overlay-window').center();
        BindItemsBlockEvents($('#overlay-window'));
    });
    return false;
}

function delete_item(item_id, item_type) {

    $("#item-delete-confirm").dialog({
        resizable:false,
        height:140,
        modal:true,
        stack:true,
        buttons:{
            "Delete":function () {
                $.ajax({
                    url:'reservierung/delete_item/' + item_id + '/' + item_type,
                    type:'post',
                    success:function (data) {
                        $('#item-list').html(data);
                        BindItemsBlockEvents();
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
}

$(document).ready(function () {
    $('#flight-window').draggable();
    BindItemsBlockEvents();

    $('#createformular-page form').submit(function () {
        $('.hidden-param-block').remove();
        return true;
    });

    $('.reservierung-page button').bind('keypress', function (event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $(this).click();
            return false;
        }
        return true;
    });

    /*-----------------------------------------------------------------------------------------
     Formular header
     ------------------------------------------------------------------------------------------*/

    $('.reservierung-page .formular-header #formulartype-value').click(function () {
        $('.reservierung-page .changetype-block').show();
        $('.reservierung-page .formular-content').hide();
        $('.reservierung-page #flight-window').hide();
        return false;
    });

    $('.reservierung-page .formular-header #change-ag').click(function () {
        $(this).hide();
        $('#new_aghid').val('');
        $('.formular-header').find('#save-ag, #new_agnum').show();
        return false;
    });

    $('.reservierung-page .formular-header #new_agnum').liveSearch({
        url:'kundenverwaltung/livesearch/',
        width:400,
        onSelect:function (data) {
            $('#new_ag_id').val(data.id);
            $('#new_ag_num').val(data.num);
        }
    });

    $('.reservierung-page .formular-header #save-ag').click(function () {
        if ($('#new_ag_id').val() == '') {
            $('.reservierung-page .formular-header #new_agnum').addClass('error');
            return false;
        }
        $('.reservierung-page .formular-header #new_agnum').removeClass('error');

        if ($('input#formular_id').size() > 0)
            $.ajax({
                url:'reservierung/change_agency/' + $('input#formular_id').val() + '/' + $('#new_ag_id').val()
            });
        else
            $('input[name=kunde_id]').val($('#new_ag_id').val());

        $('#kunde_link').html($('#new_ag_num').val()).attr('for', $('#new_ag_id').val());

        $('.formular-header').find('#save-ag, #new_agnum').val('').hide();
        $('.reservierung-page .formular-header #change-ag').show();

        return false;
    });

    $('.formular-header #save-vnum').click(function () {
        var val = $('#new_vnum_value').val();
        if (val.length < 5) {
            $('#new_vnum_value').addClass('error');
            return false;
        }
        else
            $('#new_vnum_value').removeClass('error');

        $.post('reservierung/change_vnum/' + $('input#formular_id').val(), 'value=' + val);
        $('#vorgangsnummer-value').html(val).show();
        $(this).parents('.editparam').hide();

        return false;
    });


    $('.formular-header #save-ownertype').click(function () {
        var val = $('#new_ownertype_value').val();
        $.post('reservierung/change_ownertype/' + $('input#formular_id').val(), 'value=' + val);

        $('#ownertype-value').html($('#new_ownertype_value option:selected').html()).show();
        $(this).parents('.editparam').hide();

        return false;
    });


    $('#kunde_link').click(function () {
        document.location = "kunderverwaltung/historie/" + $(this).attr('for');
        return false;
    });

    $('.formular-header a.change-value').click(function () {
        $(this).hide().parents('.param').find('.editparam').show();
        return false;
    });


    /*-----------------------------------------------------------------------------------------
     Change type block
     ------------------------------------------------------------------------------------------*/

    $('.reservierung-page .changetype-block #type-radio, .reservierung-page #changeowner_type').buttonset();

    $('.reservierung-page .changetype-block #type-radio input').click(function () {
        $('.reservierung-page .changetype-block .typeedit-block').hide();
        if ($('#type-radio #type_1').is(':checked')) {
            $('.reservierung-page .changetype-block #pausschalreise-type').show();
        }
        else if ($('#type-radio #type_2').is(':checked')) {
            $('.reservierung-page .changetype-block #bausteinreise-type').show();
        }
        else if ($('#type-radio #type_3').is(':checked')) {
            $('.reservierung-page .changetype-block #nurflug-type').show();
        }
    });

    $('.reservierung-page .changetype-block #nurflug-type .flight-price,' +
        '.reservierung-page .changetype-block #nurflug-type #servicecharge-amount').keyup(function () {
            var flight_price = parseFloat($('.reservierung-page .changetype-block #nurflug-type .flight-price').val());
            var service_amount = parseFloat($('.reservierung-page .changetype-block #nurflug-type #servicecharge-amount').val());

            if (!flight_price)flight_price = 0;
            if (!service_amount)service_amount = 0;

            $('.reservierung-page .changetype-block #nurflug-type #total-amount').val(flight_price + service_amount);
        });

    $('.reservierung-page .changetype-block #nurflug-type #servicecharge-percent').keyup(function () {
        var percent = parseFloat($(this).val());
        var flight_price = parseFloat($('.reservierung-page .changetype-block #nurflug-type .flight-price').val());

        if (!percent)percent = 0;
        if (!flight_price)flight_price = 0;

        $('.reservierung-page .changetype-block #nurflug-type #servicecharge-amount').val(flight_price / 100 * percent).keyup();
    });

    $('.reservierung-page .changetype-block #nurflug-type input[type=submit]').click(function () {

        var old_vnum = $('.reservierung-page .formular-header #vorgangsnummer-value').html();
        var vnum = $('.reservierung-page .changetype-block #nurflug-type [name=nurflug_vnum]').val();
        var person_count = $('.reservierung-page .changetype-block #nurflug-type [name=nurflug_personcount]').val();
        var flight = $('.reservierung-page .changetype-block #nurflug-type [name=nurflug_flight]').val();
        var flight_price = $('.reservierung-page .changetype-block #nurflug-type [name=nurflug_flightprice]').val();
        var service_charge = $('.reservierung-page .changetype-block #nurflug-type [name=nurflug_servicecharge]').val();

        var error_block = $('.reservierung-page #type-error').empty().hide();

        if (vnum.length != 6)
            $('<li>Vorgansnummer must contain 6 symbols</li>').appendTo(error_block);

        if (person_count == '' || person_count == 0)
            $('<li>Persons count must be positive integer</li>').appendTo(error_block);

        if (flight == '')
            $('<li>Flight can not be empty</li>').appendTo(error_block);

        if (flight_price == '' || flight_price == 0)
            $('<li>Flight price must be positive integer</li>').appendTo(error_block);

        var find_error = $(error_block).find('li').size() > 0;

        if (!find_error && old_vnum != vnum) {
            $.ajax({
                url:'reservierung/find/vnum',
                type:'post',
                data:'value=' + vnum,
                async:false,
                success:function (data) {
                    if (data == 1)
                        $('<li>Vorgansnummer ' + vnum + ' is exist</li>').appendTo(error_block);
                }
            });
        }

        find_error = $(error_block).find('li').size() > 0;
        if (find_error)
            $(error_block).show();

        return !find_error;
    });

    $('.reservierung-page .changetype-block #create-submit').click(function () {
        var error_block = $('.reservierung-page #type-error').empty().hide();

        var block = $('.typeedit-block:visible');
        var flight = $(block).find('.flight-text').val();
        var flight_price = $(block).find('.flight-price').val();

        var old_vnum = $('.reservierung-page .formular-header #vorgangsnummer-value').html();
        var vnum = '';

        if ($(block).attr('id') == 'bausteinreise-type') {
            $.ajax({
                url:'reservierung/generate_vnum/bausteinreise',
                async:false,
                success:function (data) {
                    $('#b_vnum').val(data);
                }
            });
        }
        else if ($(block).attr('id') == 'pausscahlreise-type') {
            vnum = $(block).find('.vnum-input').val();

            if (vnum.length != 6)
                $('<li>Vorgansnummer must contain 6 symbols</li>').appendTo(error_block);

            if (flight == '')
                $('<li>Flight can not be empty</li>').appendTo(error_block);

            if (flight_price == '' || flight_price == 0)
                $('<li>Flight must be positive integer</li>').appendTo(error_block);

            find_error = $(error_block).find('li').size() > 0;

            if (!find_error && old_vnum != vnum) {
                $.ajax({
                    url:'reservierung/find/vnum',
                    type:'post',
                    data:'value=' + vnum,
                    async:false,
                    success:function (data) {
                        if (data == 1)
                            $('<li>Vorgansnummer ' + vnum + ' is exist</li>').appendTo(error_block);
                    }
                });
            }
        }

        var find_error = $(error_block).find('li').size() > 0;

        if (find_error)
            $(error_block).show();
        else
            return true;

        return false;
    });

    /*-----------------------------------------------------------------------------------------
     Formular buttons
     ------------------------------------------------------------------------------------------*/


    $('.reservierung-page .formular-buttons button').bind('keypress', function (event) {
        if (event.keyCode == KEY_LEFT) {
            if ($(this).index('button:visible') == 0)
                $('#buttons button:visible:last').focus();
            else
                $(this).prev().focus();
        }
        else if (event.keyCode == KEY_RIGHT)
            if ($(this).index('button:visible') == $('#buttons button:visible').size() - 1)
                $('#buttons button:visible:first').focus();
            else
                $(this).next().focus();
        else if (event.keyCode == KEY_ESC) {
            $('#page1 input, #page1 select').show();
            $('#page1 .hiddentext').hide();
            $('#page1 #personcount').focus();
            $('#buttons').hide();
        }
    });

    $('#dark-overlay').click(function () {
        if (!$(this).hasClass('finished'))
            return false;
        $(this).fadeOut();
        $(this).removeClass('finished');
        $('#overlay-window').hide();
    });

    $('.reservierung-page .formular-buttons #addhotel-button').click(function () {
        OpenOverlay();
        $('#overlay-window').empty().show();
        $('#new-hotel').clone().appendTo('#overlay-window').show();
        $('#overlay-window').center();
        BindItemsBlockEvents($('#overlay-window'));
        return false;
    });

    $('.reservierung-page .formular-buttons #addmanuel-button').click(function () {
        OpenOverlay();
        $('#overlay-window').empty().show();
        $('#new-manuel').clone().appendTo('#overlay-window').show();
        $('#overlay-window').center();
        BindItemsBlockEvents($('#overlay-window'));
        return false;
    });

    $('.reservierung-page .formular-buttons #flug-button').click(function () {
        $('.formular-buttons').hide();
        $('#flugpage').show().find('#flightplan').focus();
        return false;
    });

    $('.reservierung-page .formular-buttons #fertig-button').click(function () {

        var persons_count = $('.reservierung-page #intro-page #personcount').val();
        if (persons_count == '' || persons_count == 0) {
            $('.reservierung-page #intro-page #personcount').addClass('error');
            return false;
        }
        else
            $('.reservierung-page #intro-page #personcount').removeClass('error');

        return true;
    });


    /*-----------------------------------------------------------------------------------------
     Flight block in create page
     ------------------------------------------------------------------------------------------*/

    $('.reservierung-page #flugpage .buttons button.close').click(function () {
        $('.formular-buttons').show();

        $('#flight-window .price').html($('.reservierung-page #flugpage #flightprice').val());
        $('#flight-window .text').html($('.reservierung-page #flugpage #flightplan').val());

        $('.changetype-block #flight-text').val($('.reservierung-page #flugpage #flightplan').val());
        $('.changetype-block #flight-price').val($('.reservierung-page #flugpage #flightprice').val());

        $('#flugpage').hide();
        return false;
    });

    $('.reservierung-page #flugpage #flightplan').bind('keypress', function (event) {
        if (event.keyCode == KEY_TAB) {
            $('#flugpage #flightprice').focus();
            return false;
        }
        else if (event.keyCode == KEY_ESC) {
            $('#flugpage').hide();
            $('#buttons').show().find("#flug-button").focus();
            return false;
        }
    });

    $('.reservierung-page #flugpage #flightprice').bind('keypress', function (event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            if (isInt($(this).val())) {
                $('#flugpage').hide();
                $('#buttons').show().find("#flug-button").focus();
            }
            return false;
        }
        else if (event.keyCode == KEY_ESC) {
            $('#flugpage #flightplan').focus();
            return false;
        }
    });


    /*-------------------------------------------------------------------------------------------------
     Status page
     ---------------------------------------------------------------------------------------------------*/

    $('#status-page .status-radio').buttonset();

    $('#status-page .change-button').click(function () {
        var block = $(this).parents('.item');

        $(block).find('.item-edit').show().find('.error').html('');
        ;
        $(block).find('.buttons').hide();

        return false;
    });

    $('#status-page .item-edit .cancel-button').click(function () {
        var block = $(this).parents('.item');

        $(block).find('.item-edit').hide();
        $(block).find('.buttons').show();

        $('#flight-window').show();

        return false;
    });

    $('#status-page .item-edit .ok-button').click(function () {
        var block = $(this).parents('.item');

        if ($(block).find('.status-radio input:checked').length == 0) {
            $(block).find('.error').html('ERROR: No selected status').show();
            return false;
        }

        $.ajax({
            url:'reservierung/status/' + $('input[name=formular_id]').val(),
            type:'post',

            data:'status=' + $(block).find('.status-radio input:checked').val() +
                '&item_type=' + $(block).find('input[name=item_type]').val() +
                '&item_id=' + $(block).find('input[name=item_id]').val() +
                '&comment=' + $(block).find('.item-edit textarea').val(),

            success:function (data) {
                document.location = 'reservierung/status/' + $('input[name=formular_id]').val();
            }
        });

        return false;
    });

    $('#status-page .openlog').click(function () {
        var block = $(this).parents('.item');

        $(block).find('.buttons').hide();
        $(block).find('.status-log').show();

        return false;
    });

    $('#status-page .closelog').click(function () {
        var block = $(this).parents('.item');

        $(block).find('.buttons').show();
        $(block).find('.status-log').hide();

        return false;
    });

    /*----------------------------------------------------------------------------------------------------------
     Result page
     ----------------------------------------------------------------------------------------------------------*/

    $('#result-page #speichern').click(function () {
        var error = false;
        $('#result-page .person-name, #result-page #departure_date, #result-page #arrival_date').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('error');
                error = true;
            }
            else
                $(this).removeClass('error');
        });

        return !error;
    });

    /*------------------------------------------------------------------------------------------------------------
     Final page
     ------------------------------------------------------------------------------------------------------------*/

    $('.reservierung-page .incoming-send').click(function () {
        $(this).parents('.incoming-sendblock').hide();
        var block = $(this).parents('.item');
        $.ajax({
            url:'reservierung/send_report',
            type:'post',
            data:'type=' + $(block).find('.item_type').val() + '&id=' + $(block).find('.item_id').val(),
            success:function (data) {
                alert(data);
                $(block).find('.incoming-sendok').show();
            }
        });
        return false;
    });

    $('.reservierung-page #sofort').click(function () {
        if ($(this).is(':checked'))
            $('.prepayment-block').hide();
        else
            $('.prepayment-block').show();
    });

    $('.reservierung-page').find('#prepayment_date,#departure_date, #arrival_date, #finalpayment_date').setdatepicker().datepicker({
        onSelect:function () {
            $(this).change();
            return false;
        }
    });


    $('.reservierung-page #departure_date').change(
        function () {
            var val = $(this).val();

            var departure = new Date(val.substr(4, 4), val.substr(2, 2) - 1, val.substr(0, 2));
            if (!isValidDate(departure))
                return false;

            var prepayment = new Date(departure - new Date(35 * ONE_DAY));
            var today = new Date();

            $('.reservierung-page #finalpayment_date,.reservierung-page #prepayment_date').datepicker("option", "maxDate", new Date(departure - ONE_DAY));

            if (prepayment < today) {
                $('.reservierung-page #sofort').attr('checked', 'checked');
                $('.reservierung-page .prepayment-block').hide();

                prepayment = today;
                prepayment.setDate(prepayment.getDate() + 2);
                $('.reservierung-page #finalpayment_date').datepicker('setDate', DateToInput(prepayment));
            }
            else {
                $('.reservierung-page #finalpayment_date').val(DateToInput(prepayment));
                prepayment = today;
                prepayment.setDate(prepayment.getDate() + 7);
                $('.reservierung-page #prepayment_date').datepicker('setDate', DateToInput(prepayment));
                $('.reservierung-page .prepayment-block').show();
                $('.reservierung-page #sofort').removeAttr('checked');
            }
            return false;
        }).change();

    $('.reservierung-page #anzahlung').keyup(
        function () {
            $(this).change();
        }).change(
        function () {
            var val = $(this).val() != "" ? parseInt($(this).val()) : 0;
            $(".reservierung-page #anzahlungsum").html((parseFloat($("input#brutto_price").val().split(' ').join('')) / 100 * val).toFixed(2));
        }).change();

    $('.reservierung-page #do_rechnung').click(function () {

        $('#final-page .anzahlung-block').find('#departure_date, #finalpayment_date').each(function () {
            if ($(this).val() == '')
                $(this).addClass('error');
            else
                $(this).removeClass('error');
        });

        if (!$('#final-page #sofort').is(':checked')) {
            $('#final-page .prepayment-block input').each(function () {
                if ($(this).val() == '')
                    $(this).addClass('error');
                else
                    $(this).removeClass('error');
            });
        }
        else
            $('#final-page .prepayment-block input').removeClass('error');

        return $('#final-page .anzahlung-block input.error').size() == 0;
    });

    $('#final-page #addmail-button').click(
        function (event) {
            $('.mail:first').clone().appendTo('.mail-block').show();
            $('.mail:last span:first').html("E-Mail " + ($('.mail').size() - 1));
            $('.mail:last input').attr("name", "email[" + ($('.mail').size() - 1) + "]");
            $('.mail:last input').focus();

            $('.mail input').bind('keypress', function (event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB && $(this).val != "") {
                    $(this).parent().next().find('input').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(this).parent().remove();
                    $("#addmail-button").focus();
                    return false;
                }
            });
            $('.mail:last input').bind('keypress', function (event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB)
                    $('#addmail-button').focus();
            });
            return false;
        });

    $('#final-page #stage').buttonset();


    $('#final-page #druck-link').click(function () {
        if ($(this).hasClass('in_progress'))
            return false;
        $(this).addClass('in_progress');
        var formular_id = $('input[name=formular_id]').val();
        var type = $("#stage input:checked").val();
        $.ajax({
            url:'reservierung/print_file/' + formular_id + '/' + type,
            async:false,
            success:function (data) {
                $('#druck-link').attr('href', data).removeClass('in_progress');
            }
        });
        return true;
    });

    $('#final-page #send-button').click(function () {
        $('#final-page .mail-block .mail:visible').each(function () {

            if ($(this).find('.sended').val() == 1)
                return true;

            var mail = $(this).find('.email').val();
            if (!validateEmail(mail)) {
                $(this).find('.status').html('incorrect email');
                return true;
            }
            else
                $(this).find('.status').html('sending...');

            var mail_block = $(this);

            $.ajax({
                url:'reservierung/sendmail/' + $('input[name=formular_id]').val(),
                type:'post',
                data:'email=' + mail + '&type=' + $("#stage input:checked").val(),
                success:function (data) {
                    if (data == "ok") {
                        $(mail_block).find('.sended').val(1);
                        $(mail_block).find('.email').attr('disabled', 'disabled');
                    }

                    $(mail_block).find('.status').html(data);
                }
            });
        });

        return false;
    });

    $('#createstart-page #kunde_id').liveSearch({
        url:'kundenverwaltung/livesearch/',
        width:400
    });

    $('#createstart-page #r_num').liveSearch({
        url:'reservierung/livesearch/rnum/',
        width:400
    });

    $('#createstart-page #v_num').liveSearch({
        url:'reservierung/livesearch/vnum/',
        width:400
    });

    $('#createstart-page #kunde_name').liveSearch({
        url:'reservierung/livesearch/kundename/',
        width:400,
        onSelect:function (data) {
            $('#createstart-page input[name=formular_id]').val(data.formular_id);
        }
    });


    /*----------------------------------------------------------------------------------------------------------
     Vouchers page
     */

    $('#vouchers-page .openclose-button').click(function () {
        var voucher_block = $(this).parents('.voucher');
        var voucher_content = $(voucher_block).find('.voucher-content');
        if ($(voucher_content).is(':visible')) {
            $(voucher_content).hide();
            $(this).html('Print');
        }
        else {
            $(voucher_content).show();
            $(this).html('Close');
        }
        return false;
    });

    $('#vouchers-page .print-button').click(function () {
        var voucher_block = $(this).parents('.voucher');
        var status = $(voucher_block).find('.status');
        var selected = $(voucher_block).find('input[type=checkbox]:checked');

        if (selected.length == 0) {
            $(status).html('No selected');
            return false;
        }

        var selected_array = [];
        $(selected).each(function () {
            selected_array.push($(this).val());
        });

        $(status).html('Generating...');

        $.ajax({
            url:'reservierung/create_voucher',
            type:'post',
            data:'persons=' + selected_array + '&item_id=' + $(voucher_block).attr('id').substr(8) + "&item_type=" +
                $(voucher_block).find('input[name=item-type]').val() + "&incoming_id=" + $(voucher_block).find('#incoming option:selected').val(),
            success:function (data) {
                window.open(data);
                $(status).html('ok');
            }
        })

        return false;
    });

    /*------------------------------------------------------------------------------------------------------------
     Storeno Page
     ------------------------------------------------------------------------------------------------------------*/
    $('#storeno-page #who-radio').buttonset();

    $('#storeno-page #storno-date').setdatepicker();


    $('#storeno-page #storno-submit').click(function () {

        if ($('#storno-date').val() == '')
            $('#storno-date').addClass('error');
        else
            $('#storno-date').removeClass('error');

        if ($('#storno-percent').val() != '' && $('#storno-value').val() != '')
            $('#storno-percent, #storno-value').addClass('error');
        else
            $('#storno-percent, #storno-value').removeClass('error');

        if ($('#storeno-page input.error').size() > 0)
            return false;

        $("#storno-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            buttons:{
                "Storno":function () {
                    $('.storeno-content form').submit();
                    $(this).dialog("close");
                },
                Cancel:function () {
                    $(this).dialog("close");
                }
            }
        });

        return false;
    });

    $('#storno_manual_date').setdatepicker();

    $('#storno_edit_open').click(function () {
        $('#storno_manual span, #storno_edit_open').hide();
        $('#storno_manual .param input,#storno_save, #storno_close').show();
    });

    $('#storno_close').click(function () {
        $('#storno_manual span, #storno_edit_open').show();
        $('#storno_manual .param input,#storno_save, #storno_close').hide();
    });

    $('#storno_save').click(function () {

        $('#storno_manual .param input').removeClass('error');

        if ($('#storno_manual_date').val().length < 6)
            $('#storno_manual_date').addClass('error');

        var amount = $('#storno_betrag').val();
        var percent = $('#storno_manual_percent').val();

        if (amount.length && !isNumber(amount))
            $('#storno_betrag').addClass('error');
        if (percent.length && !isNumber(percent))
            $('#storno_manual_percent').addClass('error');

        if(amount > 0 && percent > 0)
            $('#storno_betrag, #storno_manual_percent').addClass('error');

        if($('#storno_manual .param input.error').size())
            return false;

        $(this).attr('disabled', 'disabled');

        $.ajax({
            url: 'reservierung/update_storno/' + $('#formular_id').val(),
            type: 'post',
            data: $('#storno_manual').find('*').serialize(),
            success: function(){
                document.location = 'reservierung/final/' + $('#formular_id').val();
            }
        });
    });
});
