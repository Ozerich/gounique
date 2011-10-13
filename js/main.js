function FixDate(input) {
    return input.substr(0, 2) + "." + input.substr(2, 2) + "." + input.substr(4);
}

function GenerateResult(div) {
    var result = FixDate($(div + '#datestart').val()) + " - " + FixDate($(div + '#dateend').val()) + "  " + $(div + "#dayscount").html() + " N HOTEL: " +
        $(div + "#hotelname").html() + " / " + $(div + "#roomcapacity option:selected").text() + " - " + $(div + "#roomtype").val() + " / " + $(div + "#service").val() +
        " / " + $(div + "#transfer option:selected").text() + " / " + $(div + "#remark").val();
    $(div + "#hoteldate").val(FixDate($(div + '#datestart').val()) + " - " + FixDate($(div + '#dateend').val()));
    $(div + "#hotelcontent").val($(div + "#dayscount").html() + " N HOTEL: " +
        $(div + "#hotelname").html() + " / " + $(div + "#roomcapacity option:selected").text() + " - " + $(div + "#roomtype").val() + " / " + $(div + "#service").val() +
        " / " + $(div + "#transfer option:selected").text() + " / " + $(div + "#remark").val());
    return result;
}

function UpdateDaysCount(div) {
    var start = $(div + "#datestart").val();
    var end = $(div + "#dateend").val();
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

$(document).ready(function() {

    /*
     * PAGE 1
     */

    $('#aktion').keypress(function(event) {
        if (event.which == 13) {
            if ($('#aktion').val() != "") {
                $('#agent_kunden').focus();
                if ($(this).val().toUpperCase() == "B")
                    $('#rechnungsnummber-wr').show();
                else
                    $('#rechnungsnummber-wr').hide();
                return false;
            }
        }
    });

    $('#agent_kunden').keypress(function(event) {
        if (event.which == 13) {
            $('#kundennummer').focus();
            return false;
        }
    });

    $('#kundennummer').keypress(function(event) {
        if (event.which == 13) {
            if ($('#kundennummer').val() != "") {
                $('#vorgangsnummer').focus();
                return false;
            }
        }
    });

    $('#vorgangsnummer').keypress(function(event) {
        if (event.which == 13) {
            if ($('#vorgangsnummer').val() != "") {
                if ($('#aktion').val().toUpperCase() == 'B')
                    $('#rechnungsnummber').focus();
                else {
                    $('#page2').show();
                    $('#page1 input, #page1 select').attr('disabled', 'disabled');
                    $('#personen').focus();
                }
            }
            return false;
        }
    });

    $('#rechnungsnummber').keypress(function(event) {
        if (event.which == 13) {
            if ($('#rechnungsnummber').val() != "") {
                $('#page2').show();
                $('#page1 input, #page1 select').attr('disabled', 'disabled');
                $('#personen').focus();
            }
            return false;
        }
    });

    /*
     * PAGE 2
     */

    $('#personen').keypress(function(event) {
        if (event.which != 13 || $("#personen").val() == "") return true;
        if ($('#personen').val() < $('#page2 .person').size()) {
            while ($('#page2 .person:visible').size() > $('#personen').val())
                $('#page2 .person:last').remove();
            $($('#page2 .person')[1]).find('#sex').focus();
            return true;
        }
        for (var i = $('#page2 .person').size(); i <= $('#personen').val(); i++) {
            var div = $($('#page2 .person')[0]).clone().show();
            div.find('#sex').attr('name', 'sex[' + $('#page2 .person').size() + ']');
            div.find('#person_name').attr('name', 'person_name[' + $('#page2 .person').size() + ']');
            $(div).find('span').html(i);
            div.appendTo($('#persons'));
        }
        $($('.person')[1]).find('#sex').focus();
        $('#page2 .person input, #page2 .person select').unbind('keypress');
        $('#page2 .person #sex').keypress(function(event) {
            if (event.which == 13) {
                $(this).parent().parent().find('#person_name').focus();
                return false;
            }
        });

        $('#page2 .person #person_name').keypress(function(event) {
            if (event.which == 13) {
                if ($(this).val() != "")
                    $(this).parent().parent().next('#page2 .person').find('#sex').focus();
                return false;
            }
        });
        $('#page2 .person:last').find('#person_name').keypress(function(event) {
            if (event.which == 13) {
                if ($(this).val() != "") {
                    $('#page2').hide();
                    $('#page3').show();
                    $('#page3 #hotel-button').focus();
                }
                return false;
            }
        });
    return false;
    });


    /*
     * PAGE 3
     */

    $('#hotel-button').click(function() {
        $('#page3').hide();
        $('#page4').show();
        $('#addhotel').click();
        return false;
    });


    /*
     * PAGE 4
     */


    $('#buttons #viewremark').click(function(event) {
        $('.hotels').hide();
        $('#addinfo-wr').show().find('#flightplan').focus();
        $('#buttons').hide();
        for (var i = 1; i < $('.hotel-wr').size(); i++)
            $('.summary:first').clone().appendTo('#summary-wr').html(GenerateResult("#hotel_" + i + " ")).show();
        return false;
    });


    $('#buttons #addhotel').click(function() {
        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', "hotel_" + ($('.hotel-wr').size() - 1)).show();
        $('#buttons').hide();
        $('.hotel-wr:last #hotelcode').focus();
        var hotel_div = "#hotel_" + ($('.hotel-wr').size() - 1) + " ";
        $(hotel_div + '#hotelcode').attr('name', "hotelcode[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomcapacity').attr('name', "roomcapacity[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#roomtype').attr('name', "roomtype[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#service').attr('name', "service[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#datestart').attr('name', "datestart[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#dateend').attr('name', "dateend[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#transfer').attr('name', "transfer[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#hoteldate').attr('name', "hoteldate[" + ($('.hotel-wr').size() - 1) + "]");
        $(hotel_div + '#hotelcontent').attr('name', "hotelcontent[" + ($('.hotel-wr').size() - 1) + "]");
        $('.hotel-wr:last #hotelcode').keypress(function(event) {
            if (event.keyCode == 27) {
                $(hotel_div).remove();
                $('#buttons').show().find("#addhotel").focus();
            }
            if (event.which == 13) {
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
                                        + hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#page4 #buttons").hide();
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
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=roomtype&roomcapacity=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#roomtype').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#roomtype");
                        $(hotel_div + '#roomtype-wr').show();
                        $(hotel_div + '#roomtype').focus();
                        $(hotel_div + "#service-wr," + hotel_div + "#date-wr," + hotel_div + "#transfer-wr,"
                            + hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#page4 #buttons").hide();
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #roomtype').keypress(function(event) {
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=service&roomtype=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#service').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#service");
                        $(hotel_div + '#service-wr').show();
                        $(hotel_div + '#service').focus();
                        $(hotel_div + "#date-wr," + hotel_div + "#transfer-wr," +
                            hotel_div + "#price-wr," + hotel_div + "#dayscount-wr" + ",#page4 #buttons").hide();
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #service').keypress(function(event) {
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=datestart&service=" + $(this).val(),
                    success: function(data) {
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#datestart");
                        $(hotel_div + '#date-wr').show();
                        $(hotel_div + '#datestart-wr').show().find('#datestart').focus();
                        $(hotel_div + "#dateend-wr," + hotel_div + "#transfer-wr," + hotel_div + "#price-wr," + hotel_div
                            + "#dayscount-wr" + ",#page4 #buttons").hide();
                    }
                });
                return false;
            }
        });

        $('.hotel-wr:last #datestart').keypress(function(event) {
            if (event.which == 13) {
                if ($(this).val() != "")
                    $(hotel_div + '#dateend-wr').show().find('#dateend').focus();
                return false;
            }
        });


        $('.hotel-wr:last #dateend').keypress(function(event) {
            if (event.which == 13) {
                UpdateDaysCount(hotel_div);
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=price&datestart=" + $(this).parent().parent().find('#datestart').val() + "&dateend=" + $(this).val(),
                    success: function(data) {
                        if (data != 0) {
                            $(hotel_div + '#transfer-wr').show().find('#transfer').focus();
                            $(hotel_div + "#price-wr" + ",#page4 #buttons").hide();
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
            if (event.which == 13) {
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
            if (event.which == 13) {
                $('#buttons').show().find("#addhotel").focus();
                return false;
            }
        });
        return false;
    });


    $('button').keypress(function(event) {
        if (event.which == 13) {
            $(this).click();
            return false;
        }
        return true;
    });

    $('#addhotel').keypress(function(event) {
        if (event.keyCode == 39 || event.keyCode == 37)
            $('#viewremark').focus();
    });


    $('#viewremark').keypress(function(event) {
        if (event.keyCode == 39 || event.keyCode == 37)
            $('#addhotel').focus();
    });

    $('#remark').keypress(function(event) {
        if (event.which == 13) {
            $('#flightplan').focus();
            return false;
        }
    });

    $('#flightplan').keypress(function(event) {
        if (event.which == 13) {
            $('#flightprice').focus();
            return false;
        }
    });

    $('#flightprice').keypress(function(event) {
        if (event.which == 13) {
            if ($(this).val() != "")
                $('#viewresult').focus();
            return false;
        }
    });

    $('#viewresult').click(function(event) {
        $('#page4').hide();
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

        $('#page2 .person').each(function(index) {
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
            if (event.which == 13 && $(this).val != "")
                $(this).parent().next().find('input').focus();
            else if (event.keyCode == 27) {
                $(this).parent().remove();
                $('.mail:last span').html("Mail " + ($('.mail').size() - 1));
                $('#addmail').focus();
            }
        });
        $('.mail:last input').keypress(function(event) {
            if (event.which == 13)
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
                data: "mode=pdf&sendmail&vorgangsnummer=" + $('#vorgangsnummer').val() + "&subject=" + subject + $('form').serialize(),
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
