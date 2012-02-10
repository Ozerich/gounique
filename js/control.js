function BindDeletePaymentEvents(block) {
    $('#payments-table').find('.delete-payment').click(function () {
        var block = $(this).parents('tr');
        var payment_id = $(block).find('.payment_id').val();

        $(this).hide();

        $.ajax({
            url:'control/delete_payment/' + $('#payments_formular_id').val() + '/' + payment_id,
            type:'post',
            success:function (data) {
                $('#payments-page .payment-content').empty().html(data);
                BindDeletePaymentEvents();
            }
        });

        return false;
    })
}

function BindSelectLineEvent() {
    $('#controlpayments-list tr').click(function () {
        $('#controlpayments-list tr').removeClass('current');
        $(this).addClass('current');
        $('#show-payments').show();
    });
}

$(document).ready(function () {
    BindSelectLineEvent();

    $('#show-payments').click(function () {
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        $('#dark-overlay').css({'width':maskWidth, 'height':maskHeight});
        $('#dark-overlay').fadeIn(1000);
        $('#dark-overlay').fadeTo("slow", 0.8);

        $.ajax({
            url:'control/payments/' + $('#controlpayments-list tr.current .formular_id').val(),
            success:function (data) {
                $('#overlay-window').html(data).show().center();
                $('#new-payment #payment-date').setdatepicker();

                var formular_id = $('#payments_formular_id').val();

                BindDeletePaymentEvents();
                $('#new-payment #add-payment').click(function () {

                    $('#new-payment').find('input, textarea').attr('disabled', 'disabled');
                    $.ajax({
                        url:'control/add_payment/' + formular_id,
                        type:'post',
                        data:'date=' + $('#new-payment #payment-date').val() +
                            '&amount=' + $('#new-payment #payment-amount').val() +
                            '&remark=' + $('#new-payment #payment-remark').val(),
                        success:function (data) {
                            $('#payments-page .payment-content').empty().html(data);
                            BindDeletePaymentEvents();
                            $('#new-payment').find('input, textarea').val('').removeAttr('disabled');
                        }
                    });

                    return false;
                });
            }
        });

        return false;
    });

    $('.num-search #v_num, .num-search #r_num').keyup(function () {
        var val = $(this).val();
        var search_field = $(this).attr('id');
        $.ajax({
            url:'control/search_formulars/',
            type:'post',
            data:'search_field=' + search_field + '&search_string=' + val,
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
    });

    $('.date-search input[type=text]').setdatepicker();

    $('.date-search .search-button').click(function () {

        $(this).addClass('loading');
        var block = $(this).parents('.date-item');
        var button = $(this);

        $.ajax({
            url:'control/search_formulars/',
            type:'post',
            data:'search_field=' + $(this).attr('for') + '&von=' + $(block).find('.von').val() + "&bis=" + $(block).find('.bis').val(),
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                $(button).removeClass('loading');
                BindSelectLineEvent();
            }
        });
        return false;
    });

});