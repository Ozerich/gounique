var KEY_ENTER = 13;
var KEY_ESC = 27;
var KEY_RIGHT = 39;
var KEY_LEFT = 37;

function FixDate(input) {
    return input.substr(0, 2) + "." + input.substr(2, 2) + "." + input.substr(4);
}

function GenerateResult(div) {
    var result = FixDate($(div + '.datestart').val()) + " - " + FixDate($(div + '.dateend').val()) + "  " + $(div + "#dayscount").html() + " N HOTEL: " +
        $(div + "#hotelname").html() + " / " + $(div + "#roomcapacity option:selected").text() + " - " + $(div + "#roomtype").val() + " / " + $(div + "#service").val() +
        " / " + $(div + "#transfer option:selected").text() + " / " + $(div + "#remark").val();
    $(div + "#hoteldate").val(FixDate($(div + '.datestart').val()) + " - " + FixDate($(div + '.dateend').val()));
    $(div + "#hotelcontent").val($(div + "#dayscount").html() + " N HOTEL: " +
        $(div + "#hotelname").html() + " / " + $(div + "#roomcapacity option:selected").text() + " - " + $(div + "#roomtype").val() + " / " + $(div + "#service").val() +
        " / " + $(div + "#transfer option:selected").text() + " / " + $(div + "#remark").val());
    return result;
}

function UpdateDaysCount(div) {
    var start = $(div + ".datestart").val();
    var end = $(div + ".dateend").val();
    if (start == "" || end == "")
        $(div + '#dayscount').html('').hide();
    else {
        start = new Date(start.substr(4), start.substr(2, 2), start.substr(0, 2));
        end = new Date(end.substr(4), end.substr(2, 2), end.substr(0, 2));
        var result = (end - start) / 1000 / 3600 / 24;
        if (result < 0)
            result = "ERROR";
        else
            result = result == 1 ? "1 Nacht" : result + " Nächte";
        $(div + "#dayscount-wr").show().find('#dayscount').html(result);
    }
}

function isInt(x) {
    var y = parseInt(x);
    if (isNaN(y)) return false;
    return x == y && x.toString() == y.toString();
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
            $('#abresedatum').focus();
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $('#kundennummer').focus();
            return false;
        }
    });

    $('#abresedatum').keypress(
        function(event) {
            if (event.keyCode == KEY_ENTER) {
                if ($(this).val() != "") {
                    if ($('#anzahling-wr').is(':visible'))
                        $('#anzahling').focus();
                    else {
                        $('#buttons').show().find('#hotel-button').focus();
                        $('#page1 input, #page1 select').attr('disabled', 'disabled');
                        $('#personen').focus();
                    }
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
        }).datepicker({
            onClose: function(date, inst) {
                $("#" + inst.id).focus();
            }
        }).datepicker("option", "showAnim", "blind");

    $('#anzahling').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            if (isInt($(this).val())) {
                $('#buttons').show().find('#hotel-button').focus();
                $('#page1 input, #page1 select').attr('disabled', 'disabled');
                $('#personen').focus();
            }
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $('#abresedatum').focus();
            return false;
        }
    });


    /*
     * PAGE 2 PERSONS
     */

    $('#personen').keypress(function(event) {
        if (event.keyCode == KEY_ESC) {
            $('#persons-page').hide();
            $('#page1 input, #page1 select').attr('disabled', '');
            $('#vorgangsnummer').focus();
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
    });

    $('#hotel-button').click(function() {
        $('#buttons').hide();
        $('#hotels-page').show();
        $('#hotel-buttons #addhotel').click();
        return false;
    });

    $('#persons-button').click(function() {
        $('#persons-page').show().find('#personen').focus();
        $('#buttons').hide();
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
    });

    $('#hotel-buttons #addhotel').click(function() {
        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', "hotel_" + ($('.hotel-wr').size() - 1)).show();
        $('#buttons').hide();
        $('.hotel-wr:last #hotelcode').focus();
        var hotel_div = "#hotel_" + ($('.hotel-wr').size() - 1) + " ";
        $(hotel_div + '#hotelcode').attr('name', "hotelcode[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomcapacity').attr('name', "roomcapacity[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomtype').attr('name', "roomtype[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#service').attr('name', "service[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '.datestart').attr('name', "datestart[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '.dateend').attr('name', "dateend[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#transfer').attr('name', "transfer[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#hoteldate').attr('name', "hoteldate[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#hotelcontent').attr('name', "hotelcontent[" + ($('.hotel-wr').size() - 1) + "]");


        $('.hotel-wr:last #hotelcode').keypress(function(event) {
            if (event.keyCode == KEY_ESC) {
                $(hotel_div).remove();
                $('#hotel-buttons').show().find("#addhotel").focus();
                return false;
            }
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=hotelname&hotelcode=" + $(this).val(),
                    success: function(data) {
                        if (data.length > 0) {
                            $(hotel_div + '#hotelname').html(data);
                            $.ajax({
                                url: "php/ajax.php",
                                type: "post",
                                data: "mode=roomcapacity",
                                success: function(data) {
                                    $(hotel_div + '#roomcapacity').empty();
                                    data = jQuery.parseJSON(data);
                                    if (data.length == 0)return;
                                    for (var i = 0; i < data.length; i++)
                                        $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo(hotel_div + "#roomcapacity");
                                    $(hotel_div + '#roomcapacity-wr').show();
                                    $(hotel_div + '#roomcapacity').focus();
                                    $(hotel_div + "#roomtype-wr," + hotel_div + "#service-wr," + hotel_div + "#date-wr,"
                                        + hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                                }
                            });
                        }
                        else
                            $(hotel_div + '#hotelname').html('NO FOUND');
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #roomcapacity').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=roomtype&roomcapacity=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#roomtype').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#roomtype");
                        $(hotel_div + '#roomtype-wr').show().find('#roomtype').focus();
                        $(hotel_div + "#service-wr," + hotel_div + "#date-wr," + hotel_div + "#transfer-wr,"
                            + hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                    }
                });
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).parent().hide();
                $(hotel_div + '#hotelcode').focus();
                return false;
            }
        });

        $('.hotel-wr:last #roomtype').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=service&roomtype=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#service').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#service");
                        $(hotel_div + '#service-wr').show().find('#service').focus();
                        $(hotel_div + "#date-wr," + hotel_div + "#transfer-wr," +
                            hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                    }
                });
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).parent().hide();
                $(hotel_div + '#roomcapacity').focus();
                return false;
            }
        });

        $('.hotel-wr:last #service').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=datestart&service=" + $(this).val(),
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + ".datestart");
                        $(hotel_div + '#date-wr').show().find('.datestart').focus();
                        $(hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div
                            + "#dayscount-wr" + ",#hotels-page #buttons").hide();
                    }
                });
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $(this).parent().hide();
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
                    $(hotel_div + '#date-wr').hide();
                }
            });

        $(hotel_div + ".dateend").change(function(event) {
            var a = new Date($(hotel_div + '.datestart').val());
            var b = new Date($(hotel_div + '.dateend').val());
            $(hotel_div + '.dayscount').val(Math.round((b - a) / 1000 / 3600 / 24 + 1));
        });

        $(hotel_div + ".dateend").datepicker({
            onSelect: function(date, inst) {
                $(hotel_div + ".dateend").change();
            }
        }).keypress(function(event) {
                if (event.keyCode == KEY_ENTER) {
                    $(hotel_div + '.dayscount').focus();
                    return false;
                }
                else if (event.keyCode == KEY_ESC) {
                    $(hotel_div + '.datebegin').focus();
                    return false;
                }
            });

        $(hotel_div + ".datestart, " + hotel_div + ".dateend").datepicker("option", "showAnim", "blind");

        $(hotel_div + '.dayscount').change(function() {
            if (isInt($(this).val()) && parseInt($(this).val()) > 0) {
                var a = new Date($(hotel_div + '.datestart').val());
                a.setDate(a.getDate() + parseInt($(this).val()) - 1);
                $(hotel_div + '.dateend').val((a.getMonth() + 1) + "/" + a.getDate() + "/" + a.getFullYear());
            }
        });


        $('.hotel-wr:last .dayscount').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=price&datestart=" + $(hotel_div + '.datestart').val() + "&dateend=" + $(hotel_div + '.dateend').val(),
                    success: function(data) {
                        if (data != 0) {
                            $(hotel_div + '#transfer-wr').show().find('#transfer').focus();
                            $(hotel_div + "#price-wr" + ",#hotels-page #buttons").hide();
                            $(hotel_div + "#nohotel").hide();
                        }
                        else {
                            $(hotel_div + '#transfer-wr').hide();
                            $(hotel_div + "#nohotel").show();
                        }
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #transfer').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=price&transfer=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#price').html(data + " EUR");
                        $(hotel_div + '#price-wr').show();
                        $(hotel_div + '#remark-wr').show().find("#remark").focus();
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #remark').keypress(function(event) {
            if (event.keyCode == KEY_ENTER) {
                $('#buttons').show().find("#addhotel").focus();
                return false;
            }
        });
        return false;
    });

    $('#hotel-buttons #menu').click(function() {
        $('#buttons').show();
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
                url: "php/ajax.php",
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
            url: "php/ajax.php",
            type: "post",
            data: "mode=pdf&vorgangsnummer=" + $('#vorgangsnummer').val() + $('form').serialize(),
            success: function(data) {
                window.location = "php/result.pdf";
            }
        });
        return false;
    });

});
