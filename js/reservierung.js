function update(param, hotel_block) {
    ret_data = "";

    data = "hotelcode=" + $(hotel_block).find("#hotelcode").val() +
        "&roomtype=" + $(hotel_block).find("#roomtype").val() +
        "&roomcapacity=" + $(hotel_block).find("#roomcapacity").val() +
        "&service=" + $(hotel_block).find("#service").val() +
        "&datestart=" + $(hotel_block).find(".datestart").val() +
        "&dateend=" + $(hotel_block).find(".dateend").val();
    "&transfer=" + $(hotel_block).find("#transfer").val();

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

function BindHotelEvents() {
    $('.hotel:visible').each(function () {

        var hotel_wrapper = $(this);
        var db_block = $(this).find('.database-hotel');
        var manuel_block = $(this).find('.manuel-hotel');
        var ok_button = $(this).find('.buttons .add');
        var hotel_block = $(this).find('.database-hotel, .manuel-hotel').filter(':visible');

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


            return false;
        });


        if (hotel_block.length > 0) {

            $(this).find('#hotelcode').keypress(function (event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                    $(ok_button).attr('disabled', 'disabled');

                    data = update("name", hotel_block);
                    if (data.length > 0) {
                        $(hotel_block).find('#hotelname').val(data);
                        data = update("room_type", hotel_block);
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
            });
            $(this).find('#roomtype').keypress(function (event) {
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
            $(this).find('#roomcapacity').keypress(function (event) {
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
            $(this).find('#service').keypress(function (event) {
                $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                $(ok_button).attr('disabled', 'disabled');
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(hotel_block).find('#date-wr input').val('');
                    $(hotel_block).find('.datestart, .dateend, .dayscount, .transfer').removeAttr('disabled');
                    $(hotel_block).find('.datestart').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_block).find('#roomtype').focus();
                    return false;
                }
            });

            $(this).find(".datestart").change(function () {
                if ($(this).val() != "")
                    $(hotel_block).find(".dateend").change();
            });

            $(this).find(".datestart").datepicker({
                onClose:function (date, inst) {
                    $(hotel_block).find(".datestart").focus();
                },
                onSelect:function (date, inst) {
                    $(hotel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(hotel_block).find('.datestart').val());
                    $(hotel_block).find(".dayscount").removeAttr("disabled");
                }
            }).keypress(function (event) {
                    if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                        $(hotel_block).find('.dateend').focus();
                        return false;
                    }
                    else if (event.keyCode == KEY_ESC) {
                        $(hotel_block).find('#service').focus();
                        return false;
                    }
                });

            $(this).find(".dateend").change(function (event) {
                var a = $(hotel_block).find('.datestart').val();
                a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
                var b = $(hotel_block).find('.dateend').val();
                b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
                $(hotel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
            });

            $(this).find(".dateend").datepicker({
                onSelect:function (date, inst) {
                    $(hotel_block).find(".dateend").change();
                    return true;
                },
                onClose:function () {
                    $(this).focus();
                }
            }).keypress(function (event) {
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
            old1 = $(this).find('.datestart').val();
            old2 = $(this).find('.dateend').val();
            $(this).find(".datestart, .dateend").datepicker("option", "showAnim", "blind").
                datepicker("option", "dateFormat", 'ddmmyy');
            $(this).find('.datestart').val(old1);
            $(this).find('.dateend').val(old2);

            $(this).find('.dayscount').bind('keyup',
                function () {
                    $(this).change();
                }).change(function () {

                    if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                        var a = $(hotel_block).find('.datestart').val();
                        a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2)) - 1, a.substr(0, 2));
                        a.setDate(a.getDate() + parseInt($(this).val()));
                        $(hotel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
                    }
                });


            $(this).find('.dayscount').keypress(function (event) {

                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(this).change();
                    if ($(hotel_block).hasClass('hotel-wr')) {
                        data = update("price", hotel_block);
                        if (data != 0) {
                            $(hotel_block).find('#transfer-wr').show().find('#transfer').focus();
                            $(hotel_block).find("#price-wr" + ",#hotels-page #buttons").hide();
                            $(hotel_block).find("#price").val(data);
                            $(hotel_block).find("#nohotel").hide();
                        }
                        else {
                            $(hotel_block).find('#transfer-wr').hide();
                            $(hotel_block).find("#price").focus();
                        }
                    }
                    else
                        $(hotel_block).find('#transfer').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(this).change();
                    $(hotel_block).find(".dateend").focus();
                    return false;
                }
            });

            $(this).find('.transfer').keypress(function (event) {

                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {

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
                    $(hotel_block).find(".dayscount").focus();
                    return false;
                }
            });

            $(this).find('.price').keypress(function (event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(this).parents('.param').nextAll().find('input, textarea, select').attr('disabled', 'disabled');
                    $(ok_button).removeAttr('disabled').focus();
                    if (isInt($(this).val()))
                        $(hotel_block).find(".remark").removeAttr('disabled').focus();

                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_block).find(".transfer").focus();
                    return false;
                }
            });

            $(this).find('.remark').keypress(function (event) {

                if (event.keyCode == KEY_TAB) {
                    $(ok_button).removeAttr('disabled').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_block).find(".price").focus();
                    return false;
                }
            });
        }

        $(this).find('button.add').click(function () {
            return false;
        });

        $(this).find('button.cancel').click(function () {
            $(hotel_wrapper).find('input, textarea').html('');
            $(hotel_wrapper).find('select option:first').attr('selected', 'selected');

            $(hotel_wrapper).remove();

            $('.reservierung-page #formular-buttons').show();

            $('#flight-window').hide();

            return false;
        });


    });

}

function BindManuelEvents() {
    $(".manuel-wr:visible").each(function () {

        var manuel_wrapper = $(this);
        var nodate_block = $(this).find('.manuel-nodate');
        var date_block = $(this).find('.manuel-date');
        var ok_button = $(this).find('.buttons .add');

        var manuel_block = $(this).find('.manuel-date, .manuel-nodate').filter(':visible');

        $(this).find('#manueltype input').click(function () {

            if ($(this).hasClass('manueltype-date')) {
                $(date_block).show();
                $(nodate_block).hide();
                $(ok_button).attr('disabled', 'disabled');
            }
            else {
                $(date_block).hide();
                $(nodate_block).show();
                $(ok_button).removeAttr('disabled');
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


        $(this).find("#text").keypress(function (event) {
            manuel_block = $(this).parents('.manuel-wr');
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
            manuel_block = $(this).parents('.manuel-wr');
            if ($(manuel_block).find(".datend").val() != "")
                $(manuel_block).find(".datend").change();
        });

        $(this).find(".datestart").datepicker({
            onClose:function (date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".datestart").focus();
            },
            onSelect:function (date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(manuel_block).find('.datestart').val());
                $(manuel_block).find(".dayscount").removeAttr("disabled");
            }
        }).keypress(function (event) {
                manuel_block = $(this).parents('.manuel-wr');
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(manuel_block).find('.dateend').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(manuel_block).find('#text').focus();
                    return false;
                }
            });

        $(this).find(".dateend").change(function (event) {
            manuel_block = $(this).parents('.manuel-wr');
            var a = $(manuel_block).find('.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(manuel_block).find('.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(manuel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(this).find(".dateend").datepicker({
            onSelect:function (date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".dateend").change();
                return true;
            },
            onClose:function () {
                $(this).focus();
            }
        }).keypress(function (event) {
                manuel_block = $(this).parents('.manuel-wr');
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(manuel_block).find('.dayscount').focus();
                    $('#ui-datepicker-div').hide();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(manuel_block).find('.datestart').focus();
                    return false;
                }
            });

        old1 = $(this).find('.datestart').val();
        old2 = $(this).find('.dateend').val();
        $(this).find(".datestart, .dateend").datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');
        $(this).find('.datestart').val(old1);
        $(this).find('.dateend').val(old2);


        $(this).find('.dayscount').bind('keyup',
            function () {
                $(this).change();
            }).change(function () {
                manuel_block = $(this).parents('.manuel-wr');
                if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                    var a = $(manuel_block).find('.datestart').val();
                    a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2)) - 1, a.substr(0, 2));
                    a.setDate(a.getDate() + parseInt($(this).val()));
                    $(manuel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
                }
            });

        $(this).find('.dayscount').keypress(function (event) {
            manuel_block = $(this).parents('.manuel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if (isInt($(this).val())) {
                    $(this).change();
                    $(manuel_block).find('#price').focus();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(manuel_block).find(".dateend").focus();
                return false;
            }
        });

        $(this).find('#price').keypress(function (event) {
            manuel_block = $(this).parents('.manuel-wr');
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
    });
}

$(document).ready(function () {

    BindHotelEvents();
    BindManuelEvents();

    $('.reservierung-page .changetype-block #type-radio').buttonset();

    $('.reservierung-page .changetype-block #type-radio input').click(function () {
        if ($('#type-radio #type_1').is(':checked') || $('#type-radio #type_3').is(':checked'))
            $('.reservierung-page .changetype-block .type-edit').show().find('.vorgansnummer-wr').show().
                find('.vnum-input').val($('#vnum-value').text()).focus();
        else {
            $('.reservierung-page .changetype-block .type-edit').find('.vorgansnummer-wr').hide();
            $('.reservierung-page .changetype-block .type-edit #flight-text').focus();
        }
    });

    $('.reservierung-page .formular-header #formulartype-value').click(function () {
        $('.reservierung-page .changetype-block').show();
        $('.reservierung-page .formular-content').hide();
        $('.reservierung-page #flight-window').hide();
        return false;
    });

    $('.reservierung-page .changetype-block #type-submit').click(function () {

        var error_block = $('.reservierung-page .changetype-block #type-error');

        if (!$('.reservierung-page .changetype-block #type-radio input').is(':checked')) {
            $(error_block).html('Error: No selected type');
            return false;
        }

        if ($('#type-radio #type_1').is(':checked') || $('#type-radio #type_3').is(':checked')) {
            if ($('.reservierung-page .changetype-block .vnum-input').val() == '') {
                $(error_block).html('Error: Empty vorgangsnummer');
                return false;
            }

            var error = 0;
            $.ajax({
                url:'reservierung/find/vnum',
                type:'post',
                data:'value=' + $('.reservierung-page .changetype-block .vnum-input').val(),
                async:false,
                success:function (data) {
                    if (data == 1) {
                        $(error_block).html('Error: This vnum is exist. Choose another, please');
                        error = 1;
                    }
                }
            });

            if (error)
                return false;
        }
        else {
            $.ajax({
                url:'formular/generate_vnum/',
                async:false,
                success:function (data) {
                    $('.reservierung-page .changetype-block .vnum-input').val(data);
                }
            });
        }

        $(error_block).html('');

        $('.reservierung-page .changetype-block').hide();
        $('.reservierung-page .formular-content').show();

        $('.reservierung-page #flight-window .text').html($('.changetype-block .type-edit #flight-text').val());
        $('.reservierung-page #flight-window .price').html($('.changetype-block .type-edit #flight-price').val());

        $('.reservierung-page #flugpage #flightplan').html($('.changetype-block .type-edit #flight-text').val());
        $('.reservierung-page #flugpage #flightprice').val($('.changetype-block .type-edit #flight-price').val());


        var type = $('.reservierung-page .changetype-block #type-radio input:checked').val();
        var vnum = $('.reservierung-page .changetype-block .vnum-input').val();

        $('.reservierung-page .formular-header #formulartype-value').html(type);
        $('.reservierung-page .formular-header #vorgangsnummer-value').html(vnum);

        return false;
    });


    $('button').keypress(function (event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $(this).click();
            return false;
        }
        return true;
    });

    $('.buttons-block button').keypress(function (event) {
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


    $('.reservierung-page #formular-buttons #addhotel-button').click(function () {
        var hotel_div = "#hotel_" + ($('.hotel').size() - 1);

        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', 'hotel_' + ($('.hotel').size() - 2)).show();

        $(hotel_div).find('input[type=text], select, input[type=hidden], textarea').each(function () {
            $(this).attr('name', $(this).attr('name') + '[' + ($('.hotel').size() - 2) + ']');
        });


        $('#formular-buttons').hide();
        $('#hotels-page').show();

        $('#flight-window').show();

        $(hotel_div).find('#hoteltype label').each(function () {
            $(this).attr('for', $(this).attr('for') + '_' + ($('.hotel').size() - 1));
        });

        $(hotel_div).find('#hoteltype input').each(function () {
            $(this).attr('id', $(this).attr('id') + '_' + ($('.hotel').size() - 1));
        });

        $(hotel_div).find('#hoteltype').buttonset().find('.hoteltype-db').attr('checked', 'checked')
        $(hotel_div).find('#hoteltype').buttonset('refresh');

        BindHotelEvents();

        return false;
    });


    $('#formular-buttons #addmanuel-button').click(function () {
        var manuel_div = "#manuel_" + ($('.manuel').size() - 1);

        $('.manuel-wr:first').clone().appendTo(".manuels").attr('id', 'manuel_' + ($('.manuel').size() - 2)).show();

        $(manuel_div).find('input[type=text], select, input[type=hidden], textarea').each(function () {
            $(this).attr('name', $(this).attr('name') + '[' + ($('.hotel').size() - 2) + ']');
        });

        $('#formular-buttons').hide();

        $('#manuel-page').show();

        $('#flight-window').show();

        $(manuel_div).find('#manueltype label').each(function () {
            $(this).attr('for', $(this).attr('for') + '_' + ($('.manuel').size() - 1));
        });

        $(manuel_div).find('#manueltype input').each(function () {
            $(this).attr('id', $(this).attr('id') + '_' + ($('.manuel').size() - 1));
        });

        $(manuel_div).find('#manueltype').buttonset().find('.manuelttype-date').attr('checked', 'checked')
        $(manuel_div).find('#manueltype').buttonset('refresh');

        BindManuelEvents();

        return false;
    });


    $('#formular-buttons #flug-button').click(function () {

        $('#formular-buttons').hide();

        $('#flugpage').show().find('#flightplan').focus();

        return false;
    });

    $('#flugpage .buttons button.close').click(function () {
        $('#formular-buttons').show();

        $('#flugpage').hide();
        return false;
    });

    $('#flugpage #flightplan').keypress(function (event) {
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

    $('#flugpage #flightprice').keypress(function (event) {
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

    $('#cancel-storeno').click(function () {
        document.location = "formular/final/" + $('input[name=formular_id]').val();
        return false;
    });

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
            url:'formular/status/' + $('input[name=formular_id]').val(),
            type:'post',

            data:'status=' + $(block).find('.status-radio input:checked').val() +
                '&item_type=' + $(block).find('input[name=item_type]').val() +
                '&item_id=' + $(block).find('input[name=item_id]').val() +
                '&comment=' + $(block).find('.item-edit textarea').val(),

            success:function (data) {
                document.location = 'formular/status/' + $('input[name=formular_id]').val();
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


});
