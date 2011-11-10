$(document).ready(function() {
    $('#agency-all').dataTable({
    });

    $('#add_agency-button').click(function() {
        document.location = "agency.php?add";
        return false;
    });

    $("#cancel-button").click(function() {
        document.location = "agency.php";
        return false;
    });

    $("#type").buttonset().change(function() {
        if ($("#radio1").is(":checked"))
            $("#provision-wr").show();
        else
            $("#provision-wr").hide();
    });

    $('#agency-all .view-button').click(function() {
        document.location = "agency.php?id=" + $(this).parent().parent().find(".id").text();
        return false;
    });

    $('.delete-button').click(function() {
        document.location = "agency.php?delete&id=" + $(this).parent().parent().find(".id").text();
        return false;
    });

    $('.edit-button').click(function() {
        var input = $(this).parent().find("input, textarea");
        var span = $(this).parent().find("span");
        var button = $(this);
        if ($(this).html() == "Edit") {
            $(span).hide();
            $(input).show().val($(this).parent().find("span").html()).focus();
            $(button).html("Apply");
        }
        else {
            $(input).prop("disabled", true);
            $.ajax({
                url: "agency.php?edit&id=" + $("#agency_id").val(),
                type: "post",
                data: "param=" + $(span).attr("id") + "&value=" + $(input).val(),
                success: function(data) {
                    $(input).prop("disabled", false).hide();
                    $(span).html(data).show();
                    $(button).html("Edit");
                }
            });
        }
    });

    $('.view-param input').keypress(function(event) {
        if (event.keyCode == KEY_ENTER) {
            $(this).parent().find('button').click();
            return false;
        }
    });

    $('#agency-formulars').dataTable();

    $('#agency-formulars .view-button').click(function() {
        document.location = "formular.php?step=final&vorgan=" + $(this).parents("tr").find(".v_num").html();
        return false;
    });

    $('#add_formular-button').click(function() {
        document.location = "formular.php?k_num=" + $('#agency_id').val();
        return false;
    });
});

