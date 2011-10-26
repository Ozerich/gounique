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
        url: "ajax.php?mode=" + param,
        async: false,
        data: data,
        type: "POST",
        success: function(data) {
            ret_data = data;
        }
    });
    return ret_data;
}

function BindHotelEvents() {
    $('.hotel-wr:visible').each(function() {

        $(this).find('#hotelcode').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ESC) {
                $(hotel_block).remove();
                $('#buttons').show().find("#addhotel-button").focus();
                return false;
            }
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                data = update("hotelname", hotel_block);
                if (data.length > 0) {
                    $(hotel_block).find('#hotelname').html(data);
                    $(hotel_block).find('#hotelname_hid').val(data);
                    data = update("roomtype", hotel_block);

                    $(hotel_block).find('#roomtype').empty();
                    data = jQuery.parseJSON(data);
                    if (data.length == 0)return;
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo($(hotel_block).find("#roomtype"));
                    $(hotel_block).find('#roomtype-wr').show().find("#roomtype").focus();
                    $(hotel_block).find("#roomcapacity-wr,#service-wr,#date-wr,#transfer-wr,#price-wr,#dayscount-wr,#remark-wr,#hotels-page #buttons").hide();
                }
                else
                    $(hotel_block).find('#hotelname').html('NO FOUND');
                return false;
            }
        });

        $(this).find('#roomtype').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                data = update("roomcapacity", hotel_block);
                $(hotel_block).find('#roomcapacity').empty();
                data = jQuery.parseJSON(data);
                for (var i = 0; i < data.length; i++)
                    $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo($(hotel_block).find("#roomcapacity"));
                $(hotel_block).find('#roomcapacity-wr').show().find('#roomcapacity').focus();
                $(hotel_block).find("#service-wr,#date-wr,#transfer-wr,#price-wr,#remark-wr,#dayscount-wr,#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).find('#hotelcode').focus();
                return false;
            }
        });

        $(this).find('#roomcapacity').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                data = update("service", hotel_block);
                $(hotel_block).find('#service').empty();
                data = jQuery.parseJSON(data);
                for (var i = 0; i < data.length; i++)
                    $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo($(hotel_block).find("#service"));
                $(hotel_block).find('#service-wr').show().find('#service').focus();
                $(hotel_block).find("#date-wr,#transfer-wr,#price-wr,#remark-wr#dayscount-wr,#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find('#roomtype').focus();
                return false;
            }
        });


        $(this).find('#service').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('#date-wr input').val('');
                $(hotel_block).find('#date-wr').show().find('.datestart').focus();
                $(hotel_block).find("#transfer-wr,#price-wr,#remark-wr,#dayscount-wr,#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find('#roomtype').focus();
                return false;
            }
        });

        $(this).find(".datestart").change(function() {
            hotel_block = $(this).parents('.hotel-wr');
            if ($(this).val() != "")
                $(hotel_block).find(".dateend").change();
        });

        $(this).find(".datestart").datepicker({
            onClose: function(date, inst) {
                hotel_block = $(this).parents('.hotel-wr');
                $(hotel_block).find(".datestart").focus();
            },
            onSelect: function(date, inst) {
                hotel_block = $(this).parents('.hotel-wr');
                $(hotel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(hotel_block).find('.datestart').val());
                $(hotel_block).find(".dayscount").removeAttr("disabled");
            }
        }).keypress(function(event) {
                hotel_block = $(this).parents('.hotel-wr');
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(hotel_block).find('.dateend').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_block).find('#service').focus();
                    return false;
                }
            });

        $(this).find(".dateend").change(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            var a = $(hotel_block).find('.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(hotel_block).find('.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(hotel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(this).find(".dateend").datepicker({
            onSelect: function(date, inst) {
                hotel_block = $(this).parents('.hotel-wr');
                $(hotel_block).find(".dateend").change();
                return true;
            },
            onClose: function() {
                $(this).focus();
            }
        }).keypress(function(event) {
                hotel_block = $(this).parents('.hotel-wr');
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
            function() {
                $(this).change();
            }).change(function() {
                hotel_block = $(this).parents('.hotel-wr');
                if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                    var a = $(hotel_block).find('.datestart').val();
                    a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2)) - 1, a.substr(0, 2));
                    a.setDate(a.getDate() + parseInt($(this).val()));
                    $(hotel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
                }
            });


        $(this).find('.dayscount').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(this).change();
                data = update("price", hotel_block);
                if (data != 0) {
                    $(hotel_block).find('#transfer-wr').show().find('#transfer').focus();
                    $(hotel_block).find("#price-wr" + ",#hotels-page #buttons").hide();
                    $(hotel_block).find("#price").val(data);
                    $(hotel_block).find("#nohotel").hide();
                }
                else {
                    $(hotel_block).find('#transfer-wr').hide();
                    $(hotel_block).find("#price-wr").show().find("#price").focus();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).change();
                $(hotel_block).find(".dateend").focus();
                return false;
            }
        });

        $(this).find('#transfer').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $(hotel_block).find('#price-wr').show().find('#price').focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find(".dayscount").focus();
                return false;
            }
        });

        $(this).find('#price').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if (isInt($(this).val())) {
                    $(hotel_block).find('#remark-wr').show().find("#remark").focus();
                    return false;
                }
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find("#transfer").focus();
                return false;
            }
        });

        $(this).find('#remark').keypress(function(event) {
            hotel_block = $(this).parents('.hotel-wr');
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $('#buttons').show().find("#addhotel-button").focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_block).find("#price").focus();
                return false;
            }
        });

    });

}

function BindManuelEvents() {
    $(".manuel-wr:visible").each(function() {
        $(this).find("#text").keypress(function(event) {
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

        $(this).find(".datestart").change(function() {
            manuel_block = $(this).parents('.manuel-wr');
            if ($(manuel_block).find(".datend").val() != "")
                $(manuel_block).find(".datend").change();
        });

        $(this).find(".datestart").datepicker({
            onClose: function(date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".datestart").focus();
            },
            onSelect: function(date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".dateend").removeAttr("disabled").datepicker("option", "minDate", $(manuel_block).find('.datestart').val());
                $(manuel_block).find(".dayscount").removeAttr("disabled");
            }
        }).keypress(function(event) {
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

        $(this).find(".dateend").change(function(event) {
            manuel_block = $(this).parents('.manuel-wr');
            var a = $(manuel_block).find('.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(manuel_block).find('.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(manuel_block).find('.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(this).find(".dateend").datepicker({
            onSelect: function(date, inst) {
                manuel_block = $(this).parents('.manuel-wr');
                $(manuel_block).find(".dateend").change();
                return true;
            },
            onClose: function() {
                $(this).focus();
            }
        }).keypress(function(event) {
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
            function() {
                $(this).change();
            }).change(function() {
                manuel_block = $(this).parents('.manuel-wr');
                if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                    var a = $(manuel_block).find('.datestart').val();
                    a = new Date(a.substr(4, 4), parseInt(a.substr(2, 2)) - 1, a.substr(0, 2));
                    a.setDate(a.getDate() + parseInt($(this).val()));
                    $(manuel_block).find('.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 9 ? "0" + (a.getMonth() + 1) : (a.getMonth() + 1)) + "" + a.getFullYear());
                }
            });

        $(this).find('.dayscount').keypress(function(event) {
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

        $(this).find('#price').keypress(function(event) {
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

$(document).ready(function() {
    BindHotelEvents();
    BindManuelEvents();

    $('button').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $(this).click();
            return false;
        }
        return true;
    });

    /*
     * PAGE 1
     */

    $("#page1 input, #page1 select").bind("change",
        function(event) {
            $("#" + $(this).attr('id') + "_hid").html($(this).val());
        }).bind("keypress", function(event) {
            $(this).change();
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if ($(this).attr("noempty") == undefined || $(this).val() != "")
                    if ($(this).attr("numerical") == undefined || isInt($(this).val()))
                        $(this).parent().nextAll('.input:visible').find('input,select').first().focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).parent().prev('.input:visible').find('input,select').focus();
                return false;
            }
        });

    $('#agent_kunden').bind('change', function() {
        if ($(this).val() == 'A')
            $('#provision-wr').show();
        else
            $('#provision-wr').hide();
    });

    $('#personcount').bind("keypress",
        function(event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                if (isInt($(this).val()) != "") {
                    $('#buttons').show().find('#addhotel-button').focus();
                    $('#page1 input, #page1 select').hide();
                    $('#page1 .hiddentext').show();
                    $('#personen').focus();
                }
                return false;
            }
        });


    /*
     * PAGE 2 PERSONS
     */

    $('#personen').keypress(function(event) {
        if (event.keyCode == KEY_ESC) {
            $('#persons-page').hide();
            $('#buttons').show().find("#hotel-button").focus();
            return false;
        }
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            if (!isInt($(this).val()))
                return false;
            if ($(this).val() < $('#persons-page .person').size()) {
                while ($('#persons-page .person:visible').size() > $('#personen').val())
                    $('#persons-page .person:last').remove();
                $($('#persons-page .person')[1]).find('#sex').focus();
            }
            for (var i = $('#persons-page .person').size(); i <= $('#personen').val(); i++) {
                var div = $($('#persons-page .person')[0]).clone().show();
                div.find('#sex').attr('name', 'sex[' + $('#persons-page .person').size() + ']');
                div.find('#person_name').attr('name', 'person_name[' + $('#persons-page .person').size() + ']');
                $(div).find('span').html(i);
                div.appendTo($('#persons'));
            }
            $($('.person')[1]).find('#sex').focus();
            $('#persons-page .person input, #persons-page .person select').unbind('keypress');
            $('#persons-page .person #sex').keypress(function(event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    $(this).parent().parent().find('#person_name').focus();
                    return false;
                }
                if (event.keyCode == KEY_ESC) {
                    if ($(this).parent().parent().index('.person') == 1)
                        $('#personen').focus();
                    else
                        $(this).parent().parent().prev().find('#person_name').focus();
                    return false;
                }
            });

            $('#persons-page .person #person_name').keypress(function(event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    if ($(this).val() != "")
                        $(this).parent().parent().next('#persons-page .person').find('#sex').focus();
                    return false;
                }
                if (event.keyCode == KEY_ESC) {
                    $(this).parent().parent().find('#sex').focus();
                    return false;
                }
            });

            $('#persons-page .person:last').find('#person_name').keypress(function(event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                    if ($(this).val() != "") {
                        $('#persons-page').hide();
                        $('#buttons').show();
                        $('#buttons #hotel-button').focus();
                    }
                    return false;
                }
            });
            return false;
        }
    });


    /*
     * PAGE 3 BUTTONS
     */

    $('#buttons button').keypress(function(event) {
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


    $('#flug-button').click(function() {
        $('#buttons').hide();
        $('#flugpage').show().find('#flightplan').focus();
        return false;
    });


    /*
     * PAGE 4 HOTELS
     */


    $('#addhotel-button').click(function() {
        $('#hotels-page').show();
        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', "hotel_" + ($('.hotel-wr').size() - 1)).show();
        $('#buttons').hide();
        $(this).find('#hotelcode').focus();
        hotel_div = "#hotel_" + ($('.hotel-wr').size() - 1) + " ";
        $(hotel_div + '#hotelcode').attr('name', "hotelcode[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomcapacity').attr('name', "roomcapacity[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomtype').attr('name', "roomtype[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#service').attr('name', "service[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '.datestart').attr('name', "datestart[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '.dateend').attr('name', "dateend[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '.dayscount').attr('name', "dayscount[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#transfer').attr('name', "transfer[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#price').attr('name', "price[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#remark').attr('name', "remark[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#hotelname_hid').attr('name', "hotelname[" + ($('.hotel-wr').size() - 1) + "]");

        BindHotelEvents();

        return false;
    });

    $('#buttons #addmanuel-button').click(function() {
        $('#hotels-page').show();
        $('.manuel-wr:first').clone().appendTo(".hotels").attr('id', "manuel_" + ($('.manuel-wr').size() - 1)).show();
        $('#buttons').hide();
        $('.manuel-wr:last #text').focus();
        var manuel_div = "#manuel_" + ($('.manuel-wr').size() - 1) + " ";
        $(manuel_div).find('.datestart').attr('name', "manueldatestart[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div).find('.dateend').attr('name', "manueldateend[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div).find('.dayscount').attr('name', "dayscount[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div).find('#price').attr('name', "manuelprice[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div).find('#text').attr('name', "manueltext[" + ($('.manuel-wr').size() - 1) + "]");

        BindManuelEvents();

        return false;
    });


    /*
     * PAGE FLUG
     */

    $('#flugpage #flightplan').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $('#flugpage #flightprice').focus();
            return false;
        }
        else if (event.keyCode == KEY_ESC) {
            $('#flugpage').hide();
            $('#buttons').show().find("#flug-button").focus();
            return false;
        }
    });

    $('#flugpage #flightprice').keypress(function(event) {
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


    /*
     * PAGE 5
     */


});
