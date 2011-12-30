$(document).ready(function() {

    $("#stage").buttonset();

    $('#final-buttons button').keypress(function(event) {
        if (event.keyCode == KEY_LEFT) {
            if ($(this).index('button:visible') == 0)
                $('#final-buttons button:visible:last').focus();
            else
                $(this).prev().focus();
        }
        else if (event.keyCode == KEY_RIGHT)
            if ($(this).index('button:visible') == $('#final-buttons button:visible').size() - 1)
                $('#final-buttons button:visible:first').focus();
            else
                $(this).next().focus();
        else if (event.keyCode == KEY_ESC) {
            $('#edit-button').click();
        }
    });

    $('#addmail-button').click(
        function(event) {
            $('.mail:first').clone().appendTo('.mail-wr').show();
            $('.mail:last span:first').html("Mail " + ($('.mail').size() - 1));
            $('.mail:last input').attr("name", "email[" + ($('.mail').size() - 1) + "]");
            $('.mail:last input').focus();

            $('.mail input').keypress(function(event) {
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
            $('.mail:last input').keypress(function(event) {
                if (event.keyCode == KEY_ENTER || event.keyCode == KEY_TAB)
                    $('#addmail-button').focus();
            });
            return false;
        }).click();

    $('#edit-button').click(function() {
        document.location = "formular/result/" + $('input[name=formular_id]').val();
        return false;
    });

    $('#druck-button').click(function() {
        window.location = "pdf/" + $('.vorgan_value').html() + "_" + $("#stage input:checked").val() + ".pdf";
        return false;
    });

    $('#stage input').change(function() {
        $.ajax({
            url: "ajax.php?mode=stage",
            type: "post",
            data: "vorgan=" + $('.vorgan_value').html() + "&stage=" + $('#stage input:checked').val()
        });
    });

    $('#makerechnung-button').click(function(){
        document.location = "formular/rechnung/" + $('input[name=formular_id]').val();
        return false;
    });

    $('#makestoreno-button').click(function(){
        document.location = "formular/storeno/" + $('input[name=formular_id]').val();
        return false;
    });

});