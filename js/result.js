$(document).ready(function() {
    $('#comment').focus();

    $('#result-buttons button').keypress(function(event) {
        if (event.keyCode == KEY_LEFT) {
            if ($(this).index('button:visible') == 0)
                $('#result-buttons button:visible:last').focus();
            else
                $(this).prev().focus();
        }
        else if (event.keyCode == KEY_RIGHT)
            if ($(this).index('button:visible') == $('#result-buttons button:visible').size() - 1)
                $('#result-buttons button:visible:first').focus();
            else
                $(this).next().focus();
        else if (event.keyCode == KEY_ESC) {
            $('#abreisedatum').focus();
        }
    });

    $('#comment').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $(".person:first #sex").focus();
            return false;
        }
        else if (event.keyCode == KEY_ESC) {
            $('#edit-button').focus();
        }
    });

    $('.person #sex').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            $(this).parent().parent().find('#person_name').focus();
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            if ($(this).parent().parent().index('.person') == 0)
                $('#comment').focus();
            else
                $(this).parent().parent().prev().find('#person_name').focus();
            return false;
        }
    });

    $('.person #person_name').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            if ($(this).val() != "")
                $(this).parent().parent().next('.person').find('#sex').focus();
            return false;
        }
        if (event.keyCode == KEY_ESC) {
            $(this).parent().parent().find('#sex').focus();
            return false;
        }
    });

    $('.person:last').find('#person_name').keypress(function(event) {
        if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
            if ($(this).val() != "") {
                $('#address').focus();
            }
            return false;
        }
    });
    $('#address').keypress(
        function(event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $('#anzahlung').focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $('.person:last #person_name').focus();
                return false;
            }
        });
    $('#anzahlung').keypress(
        function(event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $('#abreisedatum').focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $('#address').focus();
                return false;
            }
        }).keyup(
        function() {
            $(this).change();
        }).change(function() {
            var val = $(this).val() != "" ? parseInt($(this).val()) : 0;
            $("#anzahlungsum").html((parseFloat($("#netto").text()) / 100 * val).toFixed(2));
        });

    old_val = $('#abreisedatum').val();
    $('#abreisedatum').keypress(
        function(event) {
            if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB) {
                $('#next-button').focus();
                return false;
            }
            else if (event.keyCode == KEY_ESC) {
                $('#anzahlung').focus();
                return false;
            }
        }).datepicker({
            onClose: function() {
                $("abreisedatum").focus();
            },
            onSelect: function() {
                $('#next-button').focus();
            }
        }).
        datepicker("option", "showAnim", "blind").
        datepicker("option", "dateFormat", 'ddmmyy');
    $('#abreisedatum').val(old_val);

    $('#back-button').click(function(event){
       document.location = "index.php?step=start&vorgan=" + $('#vorgan').val();
        return false;
    });

    $('#anzahlung').change();
});