$(document).ready(function() {
    $('#edit-button').focus();

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
    });
});