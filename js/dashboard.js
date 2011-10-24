var hotel_div;

function update(param) {
    ret_data = "";

    data = "hotelcode=" + $(hotel_div + "#hotelcode").val() +
           "&roomtype=" + $(hotel_div + "#roomtype").val() +
           "&roomcapacity=" + $(hotel_div + "#roomcapacity").val() +
           "&service=" + $(hotel_div + "#service").val() +
           "&datestart=" + $(hotel_div + ".datestart").val() +
           "&dateend=" + $(hotel_div + ".dateend").val();
           "&transfer=" + $(hotel_div + "#transfer").val();

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

$(document).ready(function() {


    $('button').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
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
        });


    $('#action').change(function(event) {
        if ($(this).val() == 'b') {
            $('#rechnungsnummber-wr').show();
            $('#anzahling-wr').show();
            $('#vorgangsnummer-wr').hide();
        }
        else {
            $('#vorgangsnummer-wr').show();
            $('#anzahling-wr').hide();
            $('#rechnungsnummber-wr').hide();
        }
    });
    $('#action').change();
    $('#action').keypress(function(event) {
        $('#action').change();
        if (event.keyCode == KEY_ENTER) {
            $('#agent_kunden').focus();
            return false;
        }
    });

    $('#agent_kunden').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            $('#kundennummer').focus();
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $('#action').focus();
            return false;
        }
    });

    $('#kundennummer').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            if ($('#kundennummer').val() != "") {
                if ($('#vorgangsnummer').is(':visible'))
                    $('#vorgangsnummer').focus();
                else
                    $('#rechnungsnummber').focus();
                return false;
            }
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $('#agent_kunden').focus();
            return false;
        }
    });

    $('#vorgangsnummer, #rechnungsnummber').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            $('#personcount').focus();
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $('#kundennummer').focus();
            return false;
        }
    });

    $('#personcount').keypress(
        function(event) {
            if (event.keyCode == KEY_ENTER) {
                if (isInt($(this).val()) != "") {
                    $('#buttons').show().find('#hotel-button').focus();
                    $('#page1 input, #page1 select').hide();
                    $('#page1 .hiddentext').show();
                    $('#personen').focus();
                }
                return false;
            }
            if (event.keyCode == KEY_ESC) {
                if ($('#vorgangsnummer').is(':visible'))
                    $('#vorgangsnummer').focus();
                else
                    $('#rechnungsnummber').focus();
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
        if (event.keyCode == KEY_ENTER) {
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
                if (event.keyCode == KEY_ENTER) {
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
                if (event.keyCode == KEY_ENTER) {
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
                if (event.keyCode == KEY_ENTER) {
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

    $('#hotel-button').click(function() {
        $('#buttons').hide();
        $('#hotels-page').show();
        $('#hotel-buttons').show().find('#addhotel').focus();
        return false;
    });

    $('#persons-button').click(function() {
        $('#persons-page').show().find('#personen').focus();
        $('#buttons').hide();
        return false;
    });

    $('#flug-button').click(function() {
        $('#buttons').hide();
        $('#flugpage').show().find('#flightplan').focus();
        return false;
    });


    /*
     * PAGE 4 HOTELS
     */

    $('#hotel-buttons button').keypress(function(event) {
        if (event.keyCode == KEY_LEFT) {
            if ($(this).index('button:visible') == 0)
                $('#hotel-buttons button:visible:last').focus();
            else
                $(this).prev().focus();
        }
        else if (event.keyCode == KEY_RIGHT)
            if ($(this).index('button:visible') == $('#hotel-buttons button:visible').size() - 1)
                $('#hotel-buttons button:visible:first').focus();
            else
                $(this).next().focus();
        else if (event.keyCode == KEY_ESC) {
            $('#hotel-buttons').hide();
            $('#buttons').show().find("#hotel-button").focus();
        }
    });

    $('#hotel-buttons #addhotel').click(function() {
        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', "hotel_" + ($('.hotel-wr').size() - 1)).show();
        $('#hotel-buttons').hide();
        $('.hotel-wr:last #hotelcode').focus();
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


        $('.hotel-wr:last #hotelcode').keypress(function(event) {
            if (event.keyCode == KEY_ESC) {
                $(hotel_div).remove();
                $('#hotel-buttons').show().find("#addhotel").focus();
                return false;
            }
            if (event.keyCode == KEY_ENTER) {
                data = update("hotelname");
                if (data.length > 0) {
                    $(hotel_div + '#hotelname').html(data);
                    $(hotel_div + '#hotelname-hid').val(data);
                    data = update("roomcapacity");

                    $(hotel_div + '#roomcapacity').empty();
                    data = jQuery.parseJSON(data);
                    if (data.length == 0)return;
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo(hotel_div + "#roomcapacity");
                    $(hotel_div + '#roomcapacity-wr').show();
                    $(hotel_div + '#roomcapacity').focus();
                    $(hotel_div + "#roomtype-wr," + hotel_div + "#service-wr," + hotel_div + "#date-wr,"
                        + hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div + "#dayscount-wr," + hotel_div + "#remark-wr" + ",#hotels-page #buttons").hide();
                }
                else
                    $(hotel_div + '#hotelname').html('NO FOUND');
                return false;
            }
        });

        $('.hotel-wr:last #roomcapacity').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                data = update("roomtype");
                $(hotel_div + '#roomtype').empty();
                data = jQuery.parseJSON(data);
                for (var i = 0; i < data.length; i++)
                    $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#roomtype");
                $(hotel_div + '#roomtype-wr').show().find('#roomtype').focus();
                $(hotel_div + "#service-wr," + hotel_div + "#date-wr," + hotel_div + "#transfer-wr,"
                    + hotel_div + "#price-wr," + hotel_div + "#remark-wr" + hotel_div + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + '#hotelcode').focus();
                return false;
            }
        });

        $('.hotel-wr:last #roomtype').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                data = update("service");
                $(hotel_div + '#service').empty();
                data = jQuery.parseJSON(data);
                for (var i = 0; i < data.length; i++)
                    $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#service");
                $(hotel_div + '#service-wr').show().find('#service').focus();
                $(hotel_div + "#date-wr," + hotel_div + "#transfer-wr," +
                    hotel_div + "#price-wr," + hotel_div + "#remark-wr" + hotel_div + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + '#roomcapacity').focus();
                return false;
            }
        });

        $('.hotel-wr:last #service').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $(hotel_div + '#date-wr').show().find('.datestart').focus();
                $(hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div + hotel_div + "#remark-wr"
                    + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + '#roomtype').focus();
                return false;
            }
        });

        $(hotel_div + ".datestart").change(function() {
            if ($(hotel_div + ".datend").val() != "")
                $(hotel_div + ".datend").change();
        });

        $(hotel_div + ".datestart").datepicker({
            onClose: function(date, inst) {
                $(hotel_div + ".datestart").focus();
            },
            onSelect: function(date, inst) {
                $(hotel_div + ".dateend").removeAttr("disabled").datepicker("option", "minDate", $(hotel_div + '.datestart').val());
                $(hotel_div + ".dayscount").removeAttr("disabled");
            }
        }).keypress(function(event) {
                if (event.keyCode == KEY_ENTER) {
                    $(hotel_div + '.dateend').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_div + '#service').focus();
                    return false;
                }
            });

        $(hotel_div + ".dateend").change(function(event) {
            var a = $(hotel_div + '.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(hotel_div + '.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(hotel_div + '.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(hotel_div + ".dateend").datepicker({
            onSelect: function(date, inst) {
                $(hotel_div + ".dateend").change();
                return true;
            }
        }).keypress(function(event) {
                if (event.keyCode == KEY_ENTER) {
                    $(hotel_div + '.dayscount').focus();
                    $('#ui-datepicker-div').hide();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_div + '.datestart').focus();
                    return false;
                }
            });

        $(hotel_div + ".datestart, " + hotel_div + ".dateend").datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');

        $(hotel_div + '.dayscount').change(function() {
            if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                var a = $(hotel_div + '.datestart').val();
                a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
                a.setDate(a.getDate() + parseInt($(this).val()));
                $(hotel_div + '.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 10 ? "0" + a.getMonth() : a.getMonth()) + "" + a.getFullYear());
            }
        });


        $('.hotel-wr:last .dayscount').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $(this).change();
                data = update("price");
                if (data != 0) {
                    $(hotel_div + '#transfer-wr').show().find('#transfer').focus();
                    $(hotel_div + "#price-wr" + ",#hotels-page #buttons").hide();
                    $(hotel_div + "#price").val(data);
                    $(hotel_div + "#nohotel").hide();
                }
                else {
                    $(hotel_div + '#transfer-wr').hide();
                    $(hotel_div + "#nohotel").show();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).change();
                $(hotel_div + ".dateend").focus();
                return false;
            }
        });

        $('.hotel-wr:last #transfer').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $(hotel_div + '#price-wr').show().find('#price').focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + ".dayscount").focus();
                return false;
            }
        });

        $('.hotel-wr:last #price').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                if (isInt($(this).val())) {
                    $(hotel_div + '#remark-wr').show().find("#remark").focus();
                    return false;
                }
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + "#transfer").focus();
                return false;
            }
        });

        $('.hotel-wr:last #remark').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $('#hotel-buttons').show().find("#addhotel").focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(hotel_div + "#price").focus();
                return false;
            }
        });


        return false;
    });

    $('#hotel-buttons #addmanuel').click(function() {
        $('.manuel-wr:first').clone().appendTo(".hotels").attr('id', "manuel_" + ($('.manuel-wr').size() - 1)).show();
        $('#hotel-buttons').hide();
        $('.manuel-wr:last #text').focus();
        var manuel_div = "#manuel_" + ($('.manuel-wr').size() - 1) + " ";
        $(manuel_div + '.datestart').attr('name', "manueldatestart[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div + '.dateend').attr('name', "manueldateend[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div + '#price').attr('name', "manuelprice[" + ($('.manuel-wr').size() - 1) + "]");
        $(manuel_div + '#text').attr('name', "manueltext[" + ($('.manuel-wr').size() - 1) + "]");

        $(manuel_div + "#text").keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                if ($(this).val() != "")
                    $(manuel_div + ".datestart").focus();
                return false;
            }
            if (event.keyCode == KEY_ESC) {
                $(manuel_div).remove();
                $('#hotel-buttons').show().find("#addmanuel").focus();
                return false;
            }
        });

        $(manuel_div + ".datestart").change(function() {
            if ($(manuel_div + ".datend").val() != "")
                $(manuel_div + ".datend").change();
        });

        $(manuel_div + ".datestart").datepicker({
            onClose: function(date, inst) {
                $(manuel_div + ".datestart").focus();
            },
            onSelect: function(date, inst) {
                $(manuel_div + ".dateend").removeAttr("disabled").datepicker("option", "minDate", $(manuel_div + '.datestart').val());
                $(manuel_div + ".dayscount").removeAttr("disabled");
            }
        }).keypress(function(event) {
                if (event.keyCode == KEY_ENTER) {
                    $(manuel_div + '.dateend').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(manuel_div + '#text').focus();
                    return false;
                }
            });

        $(manuel_div + ".dateend").change(function(event) {
            var a = $(manuel_div + '.datestart').val();
            a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
            var b = $(manuel_div + '.dateend').val();
            b = new Date(b.substr(4, 4), b.substr(2, 2), b.substr(0, 2));
            $(manuel_div + '.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24));
        });

        $(manuel_div + ".dateend").datepicker({
            onSelect: function(date, inst) {
                $(manuel_div + ".dateend").change();
                return true;
            }
        }).keypress(function(event) {
                if (event.keyCode == KEY_ENTER) {
                    $(manuel_div + '.dayscount').focus();
                    $('#ui-datepicker-div').hide();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(manuel_div + '.datestart').focus();
                    return false;
                }
            });

        $(manuel_div + ".datestart, " + manuel_div + ".dateend").datepicker("option", "showAnim", "blind").
            datepicker("option", "dateFormat", 'ddmmyy');

        $(manuel_div + '.dayscount').change(function() {
            if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                var a = $(manuel_div + '.datestart').val();
                a = new Date(a.substr(4, 4), a.substr(2, 2), a.substr(0, 2));
                a.setDate(a.getDate() + parseInt($(this).val()));
                $(manuel_div + '.dateend').val((a.getDate() < 10 ? "0" + a.getDate() : a.getDate()) + "" + (a.getMonth() < 10 ? "0" + a.getMonth() : a.getMonth()) + "" + a.getFullYear());
            }
        });

        $(manuel_div + '.dayscount').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                if (isInt($(this).val())) {
                    $(this).change();
                    $(manuel_div + '#price').focus();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(manuel_div + ".dateend").focus();
                return false;
            }
        });

        $(manuel_div + '#price').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                if (isInt($(this).val())) {
                    $('#hotel-buttons').show().find("#addmanuel").focus();
                    $(manuel_div).hide();
                }
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(manuel_div + "#price").focus();
            }
        });


        return false;
    });

    $('#hotel-buttons #showmenu').click(function() {
        $('#buttons').show().find("#hotel-button").focus();
        $('#hotels-page').hide();
        return false;
    });


    /*
     *
     */

    $('#viewresult').click(function(event) {
        $('#hotels-page').hide();
        $('#page5').show();

        var price = $('#flightprice').val() != "" ? parseInt($('#flightprice').val()) : 0;
        var hotel_price = 0;
        var price_elems = $('.hotel-wr #price');
        for (var i = 1; i < price_elems.length; i++)
            hotel_price += parseInt($(price_elems[i]).html());
        price += hotel_price;
        var persons = parseInt($('#personen').val());
        var oneprice = (price / persons).toFixed(2);
        $('input[name=priceperson]').val(oneprice);
        var gesamtpreis = price.toFixed(2);
        var netto = (gesamtpreis / 1.19).toFixed(2);
        var provision = (hotel_price * 0.2).toFixed(2);
        var percent = (gesamtpreis / 1.19 * 0.19).toFixed(2);

        $('#priceresult #oneprice').html(oneprice);
        $('#priceresult #gesamtpreis').html(gesamtpreis);
        $('#priceresult #provision').html(provision);
        $('#priceresult #percent').html(percent);
        $('#priceresult #netto').html(netto);

        $('#summary-wr *').clone().appendTo('#results');

        $('.flightplan').html($('#flightplan').val());

        $('#persons-page .person').each(function(index) {
            if (index > 0)
                $('#page5 .person:first').clone().html($(this).find('#person_name').val() + " ("
                    + $(this).find('select option:selected').text() + ")").show().appendTo('#personresult');
        });

        $('#addmail').click();
        return false;
    });


    /*
     * PAGE FLUG
     */

    $('#flugpage #flightplan').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
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
        if (event.keyCode == KEY_ENTER) {
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

    $('#addmail').keypress(function(event) {
        if (event.keyCode == 37 || event.keyCode == 39)
            $('#sendmail').focus();
    });
    $('#sendmail').keypress(function(event) {
        if (event.keyCode == 37 || event.keyCode == 39)
            $('#addmail').focus();
    });

    $('#addmail').click(function(event) {
        $('.mail:first').clone().appendTo('.mail-wr').show();
        $('.mail:last span:first').html("Mail " + ($('.mail').size() - 1));
        $('.mail:last input').attr("name", "email[" + ($('.mail').size() - 1) + "]");
        $('.mail:last input').focus();

        $('.mail input').keypress(function(event) {
            if (event.keyCode == KEY_ENTER && $(this).val != "")
                $(this).parent().next().find('input').focus();
            else if (event.keyCode == KEY_ESC) {
                $(this).parent().remove();
                $('.mail:last span').html("Mail " + ($('.mail').size() - 1));
                $('#addmail').focus();
            }
        });
        $('.mail:last input').keypress(function(event) {
            if (event.keyCode == KEY_ENTER)
                $('#addmail').focus();
        });
        return false;
    });

    $('#sendmail').click(function(event) {
        var subject = $('#aktion').val() + " / " + $('#agent_kunden').val() + " / " + $('#kundennummer').val() + " / "
            + $('#vorgangsnummer').val() + " / " + $('#rechnungsnummber').val();
        subject = encodeURI(subject);
        $('.mail:visible').each(function() {
            var input = this;
            $.ajax({
                url: "ajax.php",
                type: "post",
                data: "mode=pdf&sendmail=1&vorgangsnummer=" + $('#vorgangsnummer').val() + "&subject=" + subject + $('form').serialize(),
                success: function(data) {
                    $('.mail:visible .good').show();
                    $('.mail:visible input').attr('disabled', 'disabled');
                }
            });
        });
        return false;
    });

    $('#druck').click(function() {
        $.ajax({
            url: "ajax.php",
            type: "post",
            data: "mode=pdf&vorgangsnummer=" + $('#vorgangsnummer').val() + $('form').serialize(),
            success: function(data) {
                window.location = "php/result.pdf";
            }
        });
        return false;
    });

});
