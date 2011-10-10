function GenerateResult(div) {
    var result = $(div + '#datestart').val() + " - " + $(div + '#dateend').val() + "  " + $(div + "#dayscount").html() + " N HOTEL: " +
        $(div + "#hotelname").html() + " / " + $(div + "#roomcapacity").val() + " - " + $(div + "#roomtype").val() + " / " + $(div + "#service").val() +
        " / " + $(div + "#remark").val();
    return result;
}

function UpdateDaysCount(div) {
    var start = $(div + "#datestart").val();
    var end = $(div + "#dateend").val();
    if (start == "" || end == "")
        $(div + '#dayscount').html('').hide();
    else {
        start = start.split('.');
        end = end.split('.');
        start = new Date(start[2], start[1], start[0]);
        end = new Date(end[2], end[1], end[0]);
        var result = end - start;
        $(div + "#dayscount-wr").show().find('#dayscount').html(result / 1000 / 3600 / 24);
    }
}

$(document).ready(function() {
    /*
     * PAGE 1
     */

    $('#aktion').keypress(function(event) {
        if (event.which == 13) {
            if ($('#aktion').val() != "")
                $('#agent_kunden').focus();
        }
    });

    $('#agent_kunden').keypress(function(event) {
        if (event.which == 13)
            $('#kundennummer').focus();
    });

    $('#kundennummer').keypress(function(event) {
        if (event.which == 13) {
            if ($('#kundennummer').val() != "")
                $('#vorgangsnummer').focus();
        }
    });

    $('#vorgangsnummer').keypress(function(event) {
        if (event.which == 13) {
            if ($('#vorgangsnummer').val() != "")
                $('#rechnungsnummber').focus();
        }
    });

    $('#rechnungsnummber').keypress(function(event) {
        if (event.which == 13) {
            if ($('#rechnungsnummber').val() != "") {
                $('#page2').show();
                $('#personen').focus();
            }
        }
    });

    /*
     * PAGE 2
     */

    $('#personen').keypress(function(event) {
        if (event.which != 13 || $("#personen").val() == "") return true;
        if ($('#personen').val() < $('.person').size()) {
            $($('.person')[1]).find('[name=sex]').focus();
            return true;
        }
        for (var i = $('.person').size(); i <= $('#personen').val(); i++) {
            var div = $($('.person')[0]).clone().show();
            $(div).find('span').html(i);
            div.appendTo($('#persons'));
        }
        $($('.person')[1]).find('[name=sex]').focus();
        $('.person input, .person select').unbind('keypress');
        $('.person [name=sex]').keypress(function(event) {
            if (event.which == 13)
                $(this).parent().parent().find('[name=person_name]').focus();
        });

        $('.person [name=person_name]').keypress(function(event) {
            if (event.which == 13 && $(this).val() != "") {
                $(this).parent().parent().next('.person').find('[name=sex]').focus();
            }
        });
        $('.person:last').find('[name=person_name]').keypress(function(event) {
            if (event.which == 13 && $(this).val() != "") {
                $('#page2').hide();
                $('#page3').show();
                $('#page3 #hotel-button').focus();
            }
        });

    });


    /*
     * PAGE 3
     */

    $('#hotel-button').click(function() {
        $('#page3').hide();
        $('#page4').show();
        $('#addhotel').click();
    });


    /*
     * PAGE 4
     */


    $('#buttons #viewremark').click(function(event) {
        $('#addinfo-wr').show().find('#remark').focus();
        for(var i = 1; i < $('.hotel-wr').size(); i++)
            $('.summary:first').clone().appendTo('#summary-wr').html(GenerateResult("#hotel_" + i + " ")).show();
    });

    $('#buttons #addhotel').click(function() {
        $('.hotel-wr:first').clone().appendTo(".hotels").attr('id', "hotel_" + ($('.hotel-wr').size() - 1)).show();
        $('#buttons').hide();
        $('.hotel-wr:last #hotelcode').focus();
        var hotel_div = "#hotel_" + ($('.hotel-wr').size() - 1) + " ";
        $('.hotel-wr:last #hotelcode').keypress(function(event) {
            if (event.keyCode == 27){
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
                                }
                            });
                        }
                        else
                            $(hotel_div + '#hotelname').html('NO FOUND');
                    }
                })
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
                    }
                });
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
                    }
                });
            }
        });

        $('.hotel-wr:last #service').keypress(function(event) {
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=datestart&service=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#datestart').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#datestart");
                        $(hotel_div + '#date-wr').show();
                        $(hotel_div + '#datestart-wr').show().find('#datestart').focus();
                    }
                });
            }
        });

        $('.hotel-wr:last #datestart').keypress(function(event) {
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=dateend&datestart=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#dateend').empty();
                        data = jQuery.parseJSON(data);
                        for (var i = 0; i < data.length; i++)
                            $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo(hotel_div + "#dateend");
                        $(hotel_div + '#dateend-wr').show().find('#dateend').focus();
                        UpdateDaysCount(hotel_div);
                    }
                });
            }
        });
        $('.hotel-wr:last #datestart').change(function() {
            $(hotel_div + '#datestart').keypress();
        });

        $('.hotel-wr:last #dateend').keypress(function(event) {
            if (event.which == 13) {
                $.ajax({
                    url: "php/ajax.php",
                    type: "post",
                    data: "mode=price&dateend=" + $(this).val(),
                    success: function(data) {
                        $(hotel_div + '#price').html(data + " EUR");
                        $(hotel_div + '#price-wr').show();
                        $('#buttons').show().find("#addhotel").focus();
                        UpdateDaysCount(hotel_div);
                    }
                });
            }
        });

    });

    $('button').keypress(function(event) {
        if (event.which == 13) {
            $(this).click();
            return false;
        }
        return true;
    });

    $('#addhotel').keypress(function(event){
        if(event.keyCode == 39 || event.keyCode == 37)
            $('#viewremark').focus();
    });


    $('#viewremark').keypress(function(event){
        if(event.keyCode == 39 || event.keyCode == 37)
            $('#addhotel').focus();
    });

    $('#remark').keypress(function(event) {
        if(event.which == 13)
            $('#flightplan').focus();    
    });

    $('#flightplan').keypress(function(event) {
        if(event.which == 13)
            $('#flightprice').focus();
    });

    $('#flightprice').keypress(function(event) {
        if (event.which == 13) {
            $('#viewresult').focus();
        }
    });

    $('#viewresult').click(function(event){
        $('#page4').hide();
        $('#page5').show();
        $('#addmail').click();
    });


    /*
    * PAGE 5
    */

    $('#addmail').keypress(function(event){
        if(event.keyCode == 37 || event.keyCode == 39)
            $('#sendmail').focus(); 
    });
    $('#sendmail').keypress(function(event){
        if(event.keyCode == 37 || event.keyCode == 39)
            $('#addmail').focus();    
    });

    $('#addmail').click(function(event){
        $('.mail:first').clone().appendTo('.mail-wr').show();
        $('.mail:last span').html("Mail " + ($('.mail').size() - 1));
        $('.mail:last input').attr('name', 'email[' + ($('.mail').size() - 1) + ']').focus();
        
        $('.mail input').keypress(function(event){
            if(event.which == 13)
                $(this).parent().next().find('input').focus(); 
        });  
        $('.mail:last input').keypress(function(event){
            if(event.which == 13)
                $('#addmail').focus(); 
        });

    });

});
