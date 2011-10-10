function GenerateResult() {
    var result = $('#datestart').val() + " - " + $('#dateend').val() + "  " + $("#dayscount").html() + " N HOTEL: " +
        $("#hotelname").html() + " / " + $("#roomcapacity").val() + " - " + $("#roomtype").val() + " / " + $("#service").val() +
        " / " + $("#remark").val();
    return result;
}

function UpdateDaysCount() {
    var start = $("#datestart").val();
    var end = $("#dateend").val();
    if (start == "" || end == "")
        $('#dayscount').html('').hide();
    else {
        start = start.split('-');
        end = end.split('-');
        start = new Date(start[0], start[1], start[2]);
        end = new Date(end[0], end[1], end[2]);
        var result = end - start;
        $('#dayscount-wr').show().find('#dayscount').html(result / 1000 / 3600 / 24);
    }
}

$(document).ready(function() {
    /*
     * PAGE 1
     */

    $('#aktion').keypress(function(event) {
        if (event.which == 13)
            $('#agent_kunden').focus();
    });

    $('#agent_kunden').keypress(function(event) {
        if (event.which == 13)
            $('#kundennummer').focus();
    });

    $('#kundennummer').keypress(function(event) {
        if (event.which == 13)
            $('#vorgangsnummer').focus();
    });

    $('#vorgangsnummer').keypress(function(event) {
        if (event.which == 13)
            $('#rechnungsnummber').focus();
    });

    $('#rechnungsnummber').keypress(function(event) {
        if (event.which == 13) {
            $('#page2').show();
            $('#personen').focus();
        }
    });

    /*
     * PAGE 2
     */

    $('#personen').keypress(function(event) {
        if (event.which != 13) return true;
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
            if (event.which == 13) {
                $(this).parent().parent().next('.person').find('[name=sex]').focus();
            }
        });
        $('.person:last').find('[name=person_name]').keypress(function(event) {
            if (event.which == 13) {
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
        $('#hotelcode').focus();
    });


    /*
     * PAGE 4
     */

    $('#hotelcode').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=hotelname&hotelcode=" + $('#hotelcode').val(),
                success: function(data) {
                    if (data.length > 0) {
                        $('#hotelname').html(data);
                        $.ajax({
                            url: "php/ajax.php",
                            type: "post",
                            data: "mode=roomcapacity",
                            success: function(data) {
                                $('#roomcapacity').empty();
                                data = jQuery.parseJSON(data);
                                if (data.length == 0)return;
                                for (var i = 0; i < data.length; i++)
                                    $('<option value="' + data[i].value + '">' + data[i].name + '</option>').appendTo("#roomcapacity");
                                $('#roomcapacity-wr').show();
                                $('#roomcapacity').focus();
                            }
                        });
                    }
                    else
                        $('#hotelname').html('NO FOUND');
                }
            })
        }
    });

    $('#roomcapacity').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=roomtype&roomcapacity=" + $("#roomcapacity").val(),
                success: function(data) {
                    $('#roomtype').empty();
                    data = jQuery.parseJSON(data);
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo("#roomtype");
                    $('#roomtype-wr').show();
                    $('#roomtype').focus();
                }
            });
        }
    });

    $('#roomtype').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=service&roomtype=" + $('#roomtype').val(),
                success: function(data) {
                    $('#service').empty();
                    data = jQuery.parseJSON(data);
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo("#service");
                    $('#service-wr').show();
                    $('#service').focus();
                }
            });
        }
    });

    $('#service').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=datestart&service=" + $('#service').val(),
                success: function(data) {
                    $('#datestart').empty();
                    data = jQuery.parseJSON(data);
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo("#datestart");
                    $('#date-wr').show();
                    $('#datestart-wr').show().find('#datestart').focus();
                }
            });
        }
    });

    $('#datestart').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=dateend&datestart=" + $('#datestart').val(),
                success: function(data) {
                    $('#dateend').empty();
                    data = jQuery.parseJSON(data);
                    for (var i = 0; i < data.length; i++)
                        $('<option value="' + data[i] + '">' + data[i] + '</option>').appendTo("#dateend");
                    $('#dateend-wr').show().find('#dateend').focus();
                    UpdateDaysCount();
                }
            });
        }
    });
    $('#datestart').change(function(){
        $('#datestart').keypress();
    });

    $('#dateend').keypress(function(event) {
        if (event.which == 13) {
            $.ajax({
                url: "php/ajax.php",
                type: "post",
                data: "mode=price&dateend=" + $('#dateend').val(),
                success: function(data) {
                    $('#price').html(data + " EUR");
                    $('#price-wr').show();
                    $('#remark-wr').show().find("#remark").focus();
                    UpdateDaysCount();
                }
            });
        }
    });

    $('#remark').keypress(function(event) {
        if (event.which == 13) {
            $('#result-wr').show();
            $('#result').html(GenerateResult());
        }
    });
});
