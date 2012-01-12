function InputToTime(time) {
    return time.substr(0, 2) + '.' + time.substr(2, 2) + '.' + time.substr(4);
}

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

function GetPreview(hotel_block, type) {
    if (type == 'hotel') {
        return InputToTime($(hotel_block).find('.datestart').val()) + " - " + InputToTime($(hotel_block).find(".dateend").val()) + "&nbsp;" + $(hotel_block).find(".dayscount").val() + "N HOTEL: " +
            $(hotel_block).find("#hotelname").val() + " / " + $(hotel_block).find("#roomcapacity option:selected").html() + " / " + $(hotel_block).find("#roomtype option:selected").html() + " / " +
            $(hotel_block).find("#service option:selected").html() + " / " + $(hotel_block).find("#transfer option:selected").html() + " / " + $(hotel_block).find('#remark').val();
    }
    else {
        var result = $(hotel_block).find('.datestart').length > 0 ?
            InputToTime($(hotel_block).find('.datestart').val()) + " - " + InputToTime($(hotel_block).find(".dateend").val()) + '&nbsp;&nbsp;&nbsp;' : '';
        return result + $(hotel_block).find("#manuel_text").val();
    }
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
                        $(db_block).find('#hotelcode').trigger(jQuery.Event("keypress", { keyCode: KEY_ENTER }));
                    }
                });

            $(db_block).find('#hotelname')
                .liveSearch({
                    url:"reservierung/livesearch/hotelname/",
                    onSelect:function (data) {
                        $(db_block).find('#hotelcode').val(data.hotelcode);
                        $(this).trigger(jQuery.Event("keypress", { keyCode: KEY_ENTER }));
                    }
                });


            $(db_block).find('#roomtype').keypress(function (event) {
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

            $(db_block).find('#roomcapacity').keypress(function (event) {
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

            $(db_block).find('#service').keypress(function (event) {
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


            $(db_block).find('.dayscount').keypress(function (event) {

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

            $(db_block).find('.transfer').keypress(function (event) {

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

            $(db_block).find('.price').keypress(function (event) {
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

            $(db_block).find('.remark').keypress(function (event) {

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

    });

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


        $(this).find("#text").keypress(function (event) {

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

        $(this).find(".datestart").datepicker({
            onClose:function (date, inst) {
                $(manuel_block).find(".datestart").focus();
            },
            onSelect:function (date, inst) {
                $(manuel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(manuel_block).find('.datestart').val());
                $(manuel_block).find(".dayscount").removeAttr("disabled");
            }
        }).keypress(function (event) {
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

            var a = $(manuel_block).find('.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(manuel_block).find('.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(manuel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(this).find(".dateend").datepicker({
            onSelect:function (date, inst) {

                $(manuel_block).find(".dateend").change();
                return true;
            },
            onClose:function () {
                $(this).focus();
            }
        }).keypress(function (event) {

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

                if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                    var a = $(manuel_block).find('.datestart').val();
                    a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2)) - 1, a.substr(0, 2));
                    a.setDate(a.getDate() + parseInt($(this).val()));
                    $(manuel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
                }
            });

        $(this).find('.dayscount').keypress(function (event) {

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


    });
}

$(document).ready(function () {

    BindHotelEvents();
    BindManuelEvents();

    $('#createformular-page form').submit(function () {
        $('.hidden-param-block').remove();
        return true;
    })

    $('.reservierung-page button').keypress(function (event) {
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


    /*-----------------------------------------------------------------------------------------
     Change type block
     ------------------------------------------------------------------------------------------*/

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
            var new_vnum = $('.reservierung-page .changetype-block .vnum-input').val();
            var current_vnum = $('.reservierung-page .formular-header #vorgangsnummer-value').html();
            if (new_vnum != current_vnum)
                $.ajax({
                    url:'reservierung/find/vnum',
                    type:'post',
                    data:'value=' + new_vnum,
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
                url:'reservierung/generate_vnum/bausteinreise',
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


    /*-----------------------------------------------------------------------------------------
     Formular buttons
     ------------------------------------------------------------------------------------------*/

    $('.reservierung-page .formular-buttons button').keypress(function (event) {
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

    $('.reservierung-page #flugpage #flightplan').keypress(function (event) {
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

    $('.reservierung-page #flugpage #flightprice').keypress(function (event) {
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

    $('#result-page #anzahlung').keyup(
        function () {
            $(this).change();
        }).change(
        function () {
            var val = $(this).val() != "" ? parseInt($(this).val()) : 0;
            $("#result-page #anzahlungsum").html((parseFloat($("#result-page #brutto-value").text()) / 100 * val).toFixed(2));
        }).change();

    $('#result-page #prepayment_date, #result-page #departure_date, #result-page #finalpayment_date').datepicker({
        onSelect:function () {
            $(this).change();
            return false;
        }
    }).datepicker("option", "showAnim", "blind").datepicker("option", "dateFormat", 'ddmmyy');

    $('#result-page #departure_date').change(function () {
        var val = $(this).val();

        var a = new Date(val.substr(4, 4), parseInt(val.substr(2, 2)) - 1, val.substr(0, 2));

        a.setDate(a.getDate() - 35);
        $('#finalpayment_date').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());

        return false;
    });

    /*------------------------------------------------------------------------------------------------------------
     Final page
     ------------------------------------------------------------------------------------------------------------*/

    $('#final-page #addmail-button').click(
        function (event) {
            $('.mail:first').clone().appendTo('.mail-block').show();
            $('.mail:last span:first').html("E-Mail " + ($('.mail').size() - 1));
            $('.mail:last input').attr("name", "email[" + ($('.mail').size() - 1) + "]");
            $('.mail:last input').focus();

            $('.mail input').keypress(function (event) {
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
            $('.mail:last input').keypress(function (event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB)
                    $('#addmail-button').focus();
            });
            return false;
        }).click();

    $('#final-page #stage').buttonset();


    $('#final-page #druck-button').click(function () {
        window.location = "pdf/" + $('input[name=formular_id]').val() + "_" + $("#stage input:checked").val() + ".pdf";
        return false;
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

    $('#findkunde-page #kunde_id').liveSearch({
        url:'kundenverwaltung/livesearch/',
        width:400
    })


    /*----------------------------------------------------------------------------------------------------------
        Vouchers page
    */

    $('#vouchers-page .openclose-button').click(function()
    {
        var voucher_block = $(this).parents('.voucher');
        var voucher_content = $(voucher_block).find('.voucher-content');
        if($(voucher_content).is(':visible'))
        {
            $(voucher_content).hide();
            $(this).html('Print');
        }
        else
        {
            $(voucher_content).show();
            $(this).html('Close');
        }
        return false;
    });

    $('#vouchers-page .print-button').click(function(){
        var voucher_block = $(this).parents('.voucher');
        var status = $(voucher_block).find('.status');
        var selected = $(voucher_block).find('input[type=checkbox]:checked');

        if(selected.length == 0)
        {
            $(status).html('No selected');
            return false;
        }

        var selected_array = [];
        $(selected).each(function(){
            selected_array.push($(this).val());
        });

        $(status).html('Generating...');

        $.ajax({
            url: 'reservierung/create_voucher',
            type: 'post',
            data: 'persons=' + selected_array + '&item_id=' + $(voucher_block).attr('id').substr(8) + "&item_type=" +
                $(voucher_block).find('input[name=item-type]').val() + "&incoming_id=" + $(voucher_block).find('#incoming option:selected').val(),
            success: function(data){
                window.open(data);
                $(status).html('ok');
            }
        })

        return false;
    });


});
