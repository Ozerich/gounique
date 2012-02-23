function update(param, hotel_block) {
    ret_data = "";

    data = "hotelcode=" + $(hotel_block).find("#hotelcode").val() +
        "&roomtype=" + $(hotel_block).find("#roomtype").val() +
        "&roomcapacity=" + $(hotel_block).find("#roomcapacity").val() +
        "&service=" + $(hotel_block).find("#service").val() +
        "&datestart=" + $(hotel_block).find(".datestart").val() +
        "&dateend=" + $(hotel_block).find(".dateend").val();

    $.ajax({
        url:"reservierung/find/" + param,
        async:false,
        data:data,
        type:"POST",
        success:function (data) {
            ret_data = data;
        }
    });
    return ret_data;
}

function GetPreview(hotel_block, type) {
    if (type == 'hotel') {
        return InputToTime($(hotel_block).find('.datestart').val()) + " - " + InputToTime($(hotel_block).find(".dateend").val()) + "&nbsp;" + $(hotel_block).find(".dayscount").val() + "N HOTEL: " +
            $(hotel_block).find("#hotelname").val() + " / " + $(hotel_block).find("#roomcapacity option:selected").html() + " / " +
            ($(hotel_block).find("#roomtype option:selected").length > 0 ? $(hotel_block).find("#roomtype option:selected").html() : $(hotel_block).find("#roomtype").val()) + " / " +
            $(hotel_block).find("#service option:selected").html() + " / " + $(hotel_block).find("#transfer option:selected").html() + " / " + $(hotel_block).find('#remark').val() +
            $(hotel_block).find("#city_tour").val();

    }
    else {
        var result = $(hotel_block).find('.datestart').length > 0 ?
            InputToTime($(hotel_block).find('.datestart').val()) + " - " + InputToTime($(hotel_block).find(".dateend").val()) + '&nbsp;&nbsp;&nbsp;' : '';
        return result + $(hotel_block).find("#manuel_text").val();
    }
}

function BindDateEvents(hotel_block) {

    old1 = $(hotel_block).find('.datestart').val();
    old2 = $(hotel_block).find('.dateend').val();

    $(hotel_block).find(".datestart, .dateend").datepicker().
        datepicker("option", "showAnim", "blind").
        datepicker("option", "dateFormat", 'ddmmyy').
        bind('change',
        function (event) {

            var a = $(hotel_block).find('.datestart').val();
            var b = $(hotel_block).find('.dateend').val();

            if (!a || !b)
                return false;

            a = new Date(a.substr(4, 4), a.substr(2, 2) - 1, a.substr(0, 2));
            b = new Date(b.substr(4, 4), b.substr(2, 2) - 1, b.substr(0, 2));

            $(hotel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

    $(hotel_block).find('.datestart').val(old1);
    $(hotel_block).find('.dateend').val(old2);


    $(hotel_block).find(".datestart").change(
        function () {
            if ($(this).val() != "")
                $(hotel_block).find(".dateend").change();
        }).datepicker({
            onSelect:function (date, inst) {
                $(hotel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(hotel_block).find('.datestart').val());
                $(hotel_block).find(".dayscount").removeAttr("disabled");
                $(hotel_block).find(".datestart").change();
                return true;
            },
            onClose:function () {
                $(this).focus();
            }
        }).bind('keypress', function (event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('.dateend').focus();
                return false;
            }
        });


    $(this).find(".dateend").datepicker({
        onSelect:function (date, inst) {
            $(hotel_block).find(".dateend").change();
            return true;
        },
        onClose:function () {
            $(this).focus();
        }
    }).bind('keypress', function (event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('.dayscount').focus();
                $('#ui-datepicker-div').hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find('.datestart').focus();
                return false;
            }
        });

    $(hotel_block).find('.dayscount').bind('keyup',
        function () {
            $(this).change();
        }).change(function () {

            if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                var a = $(hotel_block).find('.datestart').val();
                a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2) - 1), a.substr(0, 2));
                a.setDate(a.getDate() + parseInt($(this).val()));
                $(hotel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
            }
        });

}

function BindHotelEvents() {
    $('.hotel:visible').each(function () {
            var hotel_wrapper = $(this);
            var hotel_preview = $(hotel_wrapper).find('.hotel-preview');
            var hotel_editcontent = $(hotel_wrapper).find('.hotel-editcontent');
            var db_block = $(this).find('.database-hotel');
            var manuel_block = $(this).find('.manuel-hotel');
            var ok_button = $(this).find('.buttons .add');
            var hotel_block = $(this).find('.database-hotel, .manuel-hotel').filter(':visible');


            if (!hotel_block.length)
                hotel_block = $(this).find('.database-hotel, .manuel-hotel');

            $(this).find('#hoteltype input').click(function () {
                if ($(this).hasClass('hoteltype-db')) {
                    $(db_block).show();
                    $(manuel_block).hide();
                    $(ok_button).attr('disabled', 'disabled');
                }
                else {
                    $(db_block).hide();
                    $(manuel_block).show();
                    $(ok_button).removeAttr('disabled');
                }

                $(hotel_block).find('.database-hotel, .manuel-hotel').filter(':visible').find('input, select, textarea').each(function () {
                    var name = $(this).attr('name');
                    if (name[0] == '_')
                        $(this).attr('name', name.substr(1));
                });


                $(hotel_block).find('.database-hotel, .manuel-hotel').filter(':hidden').find('input, select, textarea').each(function () {
                    var name = $(this).attr('name');
                    if (name[0] != '_')
                        $(this).attr('name', '_' + name);
                });

                $(hotel_wrapper).find('#hoteltype input').removeAttr('checked');
                $(this).attr('checked', 'checked');
                return false;
            });

            if (hotel_block.length > 0) {

                BindDateEvents(db_block);
                BindDateEvents(manuel_block);

                $(db_block).find('#hotelcode').keypress(
                    function (event) {
                        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                            $(this).parents('.param').nextAll().find('input, textarea, select').not('#hotelname').attr('disabled', 'disabled');
                            $(ok_button).attr('disabled', 'disabled');

                            data = update("name", hotel_block);
                            if (data.length > 0) {
                                $(hotel_block).find('#hotelname, #hotelname_hid').val(data);
                                data = update("room_type", hotel_block);
                                $(hotel_block).find('#hotelname_hid').removeAttr('disabled');
                                $(hotel_block).find('#roomtype').empty().removeAttr('disabled');
                                data = jQuery.parseJSON(data);
                                if (data.length == 0)return;
                                for (var i = 0; i < data.length; i++)
                                    $('<option value="' + data[i].id + '">' + data[i].value + '</option>').appendTo($(hotel_block).find("#roomtype"));
                            }
                            else
                                $(hotel_block).find('#hotelname').val('NO FOUND');
                            $(hotel_block).find("#roomtype").focus();
                            return false;
                        }
                    }).liveSearch({
                        url:"reservierung/livesearch/hotelcode/",
                        onSelect:function (data) {
                            $(db_block).find('#hotelname').val(data.hotelname);
                            $(db_block).find('#hotelcode').trigger(jQuery.Event("keypress", { keyCode:KEY_ENTER }));
                        }
                    });

                $(db_block).find('#hotelname')
                    .liveSearch({
                        url:"reservierung/livesearch/hotelname/",
                        onSelect:function (data) {
                            $(db_block).find('#hotelcode').val(data.hotelcode);
                            $(db_block).find('#hotelcode').trigger(jQuery.Event("keypress", { keyCode:KEY_ENTER }));
                        }
                    });


                $(db_block).find('#roomtype').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');

                        data = update("room_capacity", hotel_block);
                        $(hotel_block).find('#roomcapacity').empty().removeAttr('disabled');
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i].id + '">' + data[i].value + '</option>').appendTo($(hotel_block).find("#roomcapacity"));
                        $(hotel_block).find('#roomcapacity').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find('#hotelcode').focus();
                        return false;
                    }
                });

                $(db_block).find('#roomcapacity').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');

                        data = update("hotel_service", hotel_block);
                        $(hotel_block).find('#service').empty().removeAttr('disabled');
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i].id + '">' + data[i].value + '</option>').appendTo($(hotel_block).find("#service"));

                        $(hotel_block).find('#service').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find('#roomtype').focus();
                        return false;
                    }
                });

                $(db_block).find('#service').bind('keypress', function (event) {
                    $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                    $(ok_button).attr('disabled', 'disabled');
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(hotel_block).find('#date-wr input').val('');
                        $(hotel_block).find('.datestart, .dateend, .dayscount').removeAttr('disabled');
                        $(hotel_block).find('.datestart').focus();
                        return false;
                    }

                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find('#roomtype').focus();
                        return false;
                    }
                });


                $(db_block).find('.dayscount').bind('keypress', function (event) {

                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).change();
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');

                        var price = update("price", hotel_block);

                        if (price > 0)
                            $(hotel_block).find('.price').removeAttr('disabled').val(price).focus();
                        else
                            $(hotel_block).find('.price').attr('disabled', 'disabled').val('-');

                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(this).change();
                        $(hotel_block).find(".dateend").focus();
                        return false;
                    }
                });


                $(db_block).find('.price').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(hotel_block).find('.transfer').removeAttr("disabled").focus();

                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".dayscount").focus();
                        return false;
                    }
                });

                $(db_block).find('.transfer').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');
                        $(hotel_block).find('.transfer-price').removeAttr("disabled").focus();

                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".transfer").focus();
                        return false;
                    }
                });

                $(db_block).find('.transfer-price').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');
                        $(hotel_block).find('.remark').removeAttr("disabled").focus();

                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".transfer").focus();
                        return false;
                    }
                });

                $(db_block).find('.remark').bind('keypress', function (event) {
                    if (event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');
                        $(hotel_block).find('.city-tour').removeAttr("disabled").focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".transfer-price").focus();
                        return false;
                    }
                });

                $(db_block).find('.city-tour').bind('keypress', function (event) {
                    if (event.keyCode == KEY_TAB) {
                        $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                        $(ok_button).attr('disabled', 'disabled');
                        $(hotel_block).find('.voucher-text').removeAttr("disabled").focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".remark").focus();
                        return false;
                    }
                });

                $(db_block).find('.voucher-text').bind('keypress', function (event) {
                    if (event.keyCode == KEY_TAB) {
                        $(ok_button).removeAttr('disabled').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find(".city-tour").focus();
                        return false;
                    }
                });

                $(manuel_block).find('#hotelname').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(manuel_block).find('#roomtype').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_wrapper).find(".close_button").focus();
                        return false;
                    }
                });

                $(manuel_block).find('#roomtype').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(manuel_block).find('#roomcapacity').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(manuel_block).find("#hotelname").focus();
                        return false;
                    }
                });

                $(manuel_block).find('#roomcapacity').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(manuel_block).find('#service').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(manuel_block).find("#roomtype").focus();
                        return false;
                    }
                });

                $(manuel_block).find('#service').bind('keypress', function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(manuel_block).find('.datestart').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(manuel_block).find("#roomcapacity").focus();
                        return false;
                    }
                });

            }

            $(this).find('button.add').click(function () {

                $(hotel_wrapper).find('.hoteltype-wr').hide();
                $(hotel_wrapper).find('.database-hotel, .manuel-hotel').filter(':hidden').remove();
                $(hotel_wrapper).find('.buttons').empty().append('<button class="close-button">Close</button>').click(
                    function () {

                        $(hotel_wrapper).find('.hotel-editcontent').hide();
                        $('.reservierung-page .formular-buttons').show();
                        $('#flight-window').hide();

                        $(hotel_wrapper).find('.hotel-preview').show().find('.text').html(GetPreview(hotel_wrapper, "hotel"));

                        return false;
                    }).click();

                $(hotel_wrapper).appendTo($('#item-list'));

                return false;
            });

            $(hotel_wrapper).find('.buttons .close-button').click(function () {
                $(hotel_wrapper).find('.hotel-editcontent').hide();
                $('.reservierung-page .formular-buttons').show();
                $('#flight-window').hide();

                $(hotel_wrapper).find('.hotel-preview').show().find('.text').html(GetPreview(hotel_wrapper, "hotel"));

                return false;
            });


            $(this).find('button.cancel').click(function () {
                $(hotel_wrapper).find('input, textarea').html('');
                $(hotel_wrapper).find('select option:first').attr('selected', 'selected');

                $(hotel_wrapper).remove();

                $('.reservierung-page .formular-buttons').show();

                $('#flight-window').hide();

                return false;
            });

            $(this).find('.hotel-preview button.edit').click(function () {

                $(hotel_preview).hide();

                $(hotel_editcontent).show();
                $('#flight-window').show();

                return false;
            });

            $(this).find('.hotel-preview button.delete').click(function () {
                $(hotel_wrapper).remove();
                return false;
            });

        }
    )
    ;

}

function BindManuelEvents() {
    $(".manuel-wr:visible").each(function () {

        var manuel_wrapper = $(this);
        var manuel_preview = $(manuel_wrapper).find('.manuel-preview');
        var manuel_editcontent = $(manuel_wrapper).find('.manuel-editcontent');
        var nodate_block = $(this).find('.manuel-nodate');
        var date_block = $(this).find('.manuel-date');
        var ok_button = $(this).find('.buttons .add');
        var manuel_block = $(this).find('.manuel-date, .manuel-nodate').filter(':visible');
        if (!manuel_block.length)
            manuel_block = $(this).find('.database-hotel, .manuel-hotel');

        $(this).find('.manueltype input').click(function () {

            if ($(this).hasClass('manueltype-date')) {
                $(date_block).show();
                $(nodate_block).hide();
            }
            else {
                $(date_block).hide();
                $(nodate_block).show();
            }

            $(manuel_block).find('.manuel-nodate, .manuel-date').filter(':visible').find('input, select, textarea').each(function () {
                var name = $(this).attr('name');
                if (name[0] == '_')
                    $(this).attr('name', name.substr(1));
            });


            $(manuel_block).find('.manuel-nodate, .manuel-date').filter(':hidden').find('input, select, textarea').each(function () {
                var name = $(this).attr('name');
                if (name[0] != '_')
                    $(this).attr('name', '_' + name);
            });

            return false;
        });


        $(this).find("#text").bind('keypress', function (event) {

            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if ($(this).val() != "")
                    $(manuel_block).find(".datestart").focus();
                return false;
            }
            if (event.keyCode == KEY_ESC) {
                $(manuel_block).remove();
                $('#buttons').show().find("#addmanuel-button").focus();
                return false;
            }
        });

        $(this).find(".datestart").change(function () {

            if ($(manuel_block).find(".datend").val() != "")
                $(manuel_block).find(".datend").change();
        });

        BindDateEvents(manuel_block);

        $(this).find('#price').bind('keypress', function (event) {

            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if (isInt($(this).val())) {
                    $('#buttons').show().find("#addmanuel-button").focus();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(manuel_block).find("#price").focus();
            }
        });

        $(this).find('button.cancel').click(function () {
            $(manuel_wrapper).find('input, textarea').html('');
            $(manuel_wrapper).find('select option:first').attr('selected', 'selected');

            $(manuel_wrapper).remove();

            $('.reservierung-page .formular-buttons').show();

            $('#flight-window').hide();

            return false;
        });

        $(this).find('button.add').click(function () {

            $(manuel_wrapper).find('.manueltype-wr').hide();
            $(manuel_wrapper).find('.manuel-date, .manuel-nodate').filter(':hidden').remove();
            $(manuel_wrapper).find('.buttons').empty().append('<button class="close-button">Close</button>').click(
                function () {

                    $(manuel_wrapper).find('.manuel-editcontent').hide();
                    $('.reservierung-page .formular-buttons').show();
                    $('#flight-window').hide();

                    $(manuel_wrapper).find('.manuel-preview').show().find('.text').html(GetPreview(manuel_wrapper, "manuel"));

                    return false;
                }).click();

            $(manuel_wrapper).appendTo($('#item-list'));

            return false;
        });

        $(manuel_wrapper).find('.buttons .close-button').click(function () {
            $(manuel_wrapper).find('.manuel-editcontent').hide();
            $('.reservierung-page .formular-buttons').show();
            $('#flight-window').hide();

            $(manuel_wrapper).find('.manuel-preview').show().find('.text').html(GetPreview(manuel_wrapper, "manuel"));

            return false;
        });

        $(this).find('.manuel-preview button.edit').click(function () {

            $(manuel_preview).hide();

            $(manuel_editcontent).show();
            $('#flight-window').show();

            return false;
        });

        $(this).find('.manuel-preview button.delete').click(function () {
            $(manuel_wrapper).remove();
            return false;
        });


    });
}

$(document).ready(function () {

    BindHotelEvents();
    BindManuelEvents();

    $('#flight-window').draggable();

    $('#createformular-page form').submit(function () {
        $('.hidden-param-block').remove();
        return true;
    })

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

    $('#kunde_link').click(function () {
        document.location = "kunderverwaltung/historie/" + $(this).attr('for');
        return false;
    });


    /*-----------------------------------------------------------------------------------------
     Change type block
     ------------------------------------------------------------------------------------------*/

    $('.reservierung-page .changetype-block #type-radio').buttonset();

    $('.reservierung-page .changetype-block #type-radio input').click(function () {
        $('.reservierung-page .changetype-block .typeedit-block').hide();
        if ($('#type-radio #type_1').is(':checked'))
            $('.reservierung-page .changetype-block #pausscahlreise-type').show();
        else if ($('#type-radio #type_2').is(':checked'))
            $('.reservierung-page .changetype-block #bausteinreise-type').show();
        else if ($('#type-radio #type_3').is(':checked'))
            $('.reservierung-page .changetype-block #nurflug-type').show();
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

        /*if (service_charge == '' || service_charge == 0)
         $('<li>Service charge must be positive integer</li>').appendTo(error_block);*/

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

    $('.reservierung-page .changetype-block .type-submit').click(function () {
        var error_block = $('.reservierung-page #type-error').empty().hide();

        var block = $(this).parents('.typeedit-block');
        var flight = $(block).find('.flight-text').val();
        var flight_price = $(block).find('.flight-price').val();

        var old_vnum = $('.reservierung-page .formular-header #vorgangsnummer-value').html();
        var vnum = '';

        if ($(block).attr('id') == 'bausteinreise-type') {
            $.ajax({
                url:'reservierung/generate_vnum/bausteinreise',
                async:false,
                success:function (data) {
                    vnum = data;
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
        else {

            $('.reservierung-page .changetype-block').hide();
            $('.reservierung-page .formular-content').show();

            $('.reservierung-page #flight-window .text').html(flight);
            $('.reservierung-page #flight-window .price').html(flight_price);

            $('.reservierung-page #flugpage #flightplan').html(flight);
            $('.reservierung-page #flugpage #flightprice').val(flight_price);

            var type = $('.reservierung-page [name=formular-type]:checked').val();

            $('.reservierung-page #vnum-value').val(vnum);
            $('.reservierung-page .formular-header #vorgangsnummer-value').html(vnum);
            $('.reservierung-page .formular-header #formulartype-value').html(type);
        }

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

    $('.reservierung-page .formular-buttons #addhotel-button').click(function () {
        var hotel_id = $('.hotel').size();
        var hotel_div = "#hotel_" + hotel_id;

        $('#hotels .hotel-wr:first').clone().appendTo("#hotels").attr('id', 'hotel_' + hotel_id).show();

        $(hotel_div).find('#hotelcode').setValidator({symbolic:false});

        $(hotel_div).find('input[type=text], input[type=radio], select, input[type=hidden], textarea').each(function () {
            $(this).attr('name', $(this).attr('name') + '[' + hotel_id + ']');
        });


        $('.formular-buttons').hide();
        $('#hotels-page').show();

        $('#flight-window').show();

        $(hotel_div).find('#hoteltype label').each(function () {
            $(this).attr('for', $(this).attr('for') + '_' + hotel_id);
        });

        $(hotel_div).find('#hoteltype input').each(function () {
            $(this).attr('id', $(this).attr('id') + '_' + hotel_id);
        });

        $(hotel_div).find('#hoteltype').buttonset().find('.hoteltype-db').attr('checked', 'checked')
        $(hotel_div).find('#hoteltype').buttonset('refresh');

        BindHotelEvents();

        return false;
    });

    $('.reservierung-page .formular-buttons #addmanuel-button').click(function () {
        var manuel_id = $('.manuel').size();
        var manuel_div = "#manuel_" + manuel_id;

        $('#manuels .manuel-wr:first').clone().appendTo("#manuels").attr('id', 'manuel_' + manuel_id).show();

        $(manuel_div).find('input[type=text], select, input[type=radio], input[type=hidden], textarea').each(function () {
            $(this).attr('name', $(this).attr('name') + '[' + manuel_id + ']');
        });

        $('.formular-buttons').hide();

        $('#manuel-page').show();

        $('#flight-window').show();


        $(manuel_div).find('.manueltype label').each(function () {
            $(this).attr('for', $(this).attr('for') + '_' + manuel_id);
        });

        $(manuel_div).find('.manueltype input').each(function () {
            $(this).attr('id', $(this).attr('id') + '_' + manuel_id);
        });

        $(manuel_div).find('.manueltype').buttonset().find('.manueltype-date').attr('checked', 'checked')
        $(manuel_div).find('.manueltype').buttonset('refresh');

        BindManuelEvents();

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
        $(this).attr('href', "pdf/" + $('input[name=formular_id]').val() + "_" + $("#stage input:checked").val() + ".pdf");
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
});
