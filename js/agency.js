$(document).ready(function() {
    $('#agency-all').dataTable({   "aoColumns": [
        { "bSearchable": false },
        null,
        { "bSearchable": false },
        { "bSearchable": false },
        { "bSearchable": false },
        { "bSortable": false,"bSearchable": false }
    ] });

    $('#agency-formulars').dataTable({   "aoColumns": [
        null,
        null,
        { "bSearchable": false },
        { "bSearchable": false, "bSearchable": false }
    ] });



    $('#add_agency-button').click(function() {
        document.location = "agency.php?add";
        return false;
    });

    $("#cancel-button").click(function() {
        document.location = "agency.php";
        return false;
    });

    $("#type").buttonset().change(function() {
        if ($("#radio1").is(":checked")) {
            $("#agentur-block").show();
            $("#kunden-block").hide();
            $("input[name=type]").val("agency");
        }
        else {
            $("#agentur-block").hide();
            $("#kunden-block").show();
            $("input[name=type]").val("person");
        }
    });

    $('#agency-all .edit-button').click(function() {
        document.location = "agency.php?edit&id=" + $(this).parent().parent().attr("agency_id");
        return false;
    });

    $('.agency-item input, .agency-item textarea').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            var input = $(this).attr("name") == "comment" ? $('input[type=submit]').focus() : $(this).next('input, textarea');
            if ($(input).size() == 0)
                input = $(this).parents('.param').next().find('input,textarea').first();
            $(input).focus();
            return false;
        }
        else if (event.keyCode == KEY_ESC) {
            var input = $(this).prev('input, textarea');
            if ($(input).size() == 0)
                input = $(this).parents('.param').prev().find('input,textarea').last();
            $(input).focus();
            return false;
        }
    });


    $('.view-param input').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            $(this).parent().find('button').click();
            return false;
        }
    });

    $('#agency-formulars .view-button').click(function() {
        document.location = "formular.php?step=final&vorgan=" + $(this).parents("tr").find(".v_num").html();
        return false;
    });

    $('#add_formular-button').click(function() {
        document.location = "formular.php?k_num=" + $('#agency_id').val();
        return false;
    });
});

