function BindPaymentEvents(block) {
    $('#payments-table').find('.delete-payment').click(function () {
        var block = $(this).parents('tr');
        var payment_id = $(block).find('.payment_id').val();

        $(this).hide();

        $.ajax({
            url:'control/delete_payment/' + $('#payments_type').val() + '/' + $('#payments_formular_id').val() + '/' + payment_id,
            type:'post',
            success:function (data) {
                $('#payments-page .payment-content').empty().html(data);
                BindPaymentEvents();
            }
        });

        return false;
    });

    $('#check_versand').click(function () {
        $(this).attr('disabled', 'disabled');
        $.ajax({
            url:'control/versand/' + $('#payments_formular_id').val(),
            type:'post',
            data:'value=' + ($(this).is(':checked') ? 1 : 0),
            success:function () {
                $('#check_versand').removeAttr('disabled');
            }
        });
    });
    return false;
}

function BindSelectLineEvent() {
    $('#controlpayments-list tbody tr').click(function () {
        if ($(this).hasClass('current'))
            $('#show-payments').click();
        else {
            $('#controlpayments-list tr').removeClass('current');
            $(this).addClass('current');
            $('#show-payments').show();
        }
    });
}

$(document).ready(function () {
    BindSelectLineEvent();

    $('#dark-overlay').click(function () {

        if (!$(this).hasClass('finished'))
            return false;

        $('#lastpayment_amount').val($('#payment-amount').val());
        $('#lastpayment_date').val($('#payment-date').val());
        $('#lastpayment_remark').val($('#payment-remark').val());
        $('#lastpayment_type').val($('#payment-type option:selected').val());

        $('#controlpayments-list tr').removeClass('current');
        $.ajax({
            url:'control/search_formulars/' + $('#payments_type').val(),
            type:'post',
            data:$('#last_searchquery').val(),
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
        $('#show-payments').hide();
        $(this).fadeOut();
        $(this).removeClass('finished');
        $('#overlay-window').hide();
    });

    $('#show-payments').click(function () {
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
        $('#dark-overlay').css({'width':maskWidth, 'height':maskHeight});
        $('#dark-overlay').fadeIn(1000);
        $('#dark-overlay').fadeTo("slow", 0.8, function () {
            $(this).addClass('finished')
        });

        $.ajax({
            url:'control/payments/' + $('#payments_type').val() + '/' + $('#controlpayments-list tr.current .formular_id').val(),
            success:function (data) {
                $('#overlay-window').html(data).show().center();
                $('#new-payment #payment-date').setdatepicker();

                var formular_id = $('#payments_formular_id').val();

                $('#payment-amount').val($('#lastpayment_amount').val());
                $('#payment-date').val($('#lastpayment_date').val());
                $('#payment-remark').val($('#lastpayment_remark').val());
                $('#payment-type option[value=' + $('#lastpayment_type').val() + ']').attr('selected', 'selected');

                $('#payments-page .closepopup-button').click(function () {
                    $('#dark-overlay').click();
                    return false;
                });

                BindPaymentEvents();
                $('#new-payment #add-payment').click(function () {

                    if ($('#new-payment #payment-date').val() == "" || $('#new-payment #payment-amount').val() == "")
                        return false;
                    $('#new-payment').find('input, textarea').attr('disabled', 'disabled');
                    $.ajax({
                        url:'control/add_payment/' + $('#payments_type').val() + '/' + formular_id,
                        type:'post',
                        data:'date=' + $('#new-payment #payment-date').val() +
                            '&amount=' + $('#new-payment #payment-amount').val() +
                            '&remark=' + $('#new-payment #payment-remark').val() +
                            '&type=' + $('#new-payment #payment-type option:selected').val(),
                        success:function (data) {
                            $('#dark-overlay').click();
                            //$('#payments-page .payment-content').empty().html(data);
                            //BindPaymentEvents();
                            $('#new-payment').find('input, textarea').val('').removeAttr('disabled');
                        }
                    });
                    $('#dark-overlay').click();
                    $('#lastpayment_amount, #lastpayment_date, #lastpayment_remark, #lastpayment_type').val('');
                    return false;
                });
            }
        });

        return false;
    });

    $('.num-search #v_num, .num-search #r_num').keyup(function () {
        var val = $(this).val();
        var search_field = $(this).attr('id');
        var search_str = 'search_field=' + search_field + '&search_string=' + val;
        $('#last_searchquery').val(search_str);
        $.ajax({
            url:'control/search_formulars/' + $('#payments_type').val(),
            type:'post',
            data:search_str,
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
    });

    $('.date-search #datesearch-start').click(function () {
        $(this).addClass('loading');
        var button = $(this);
        var search_field = $(this).attr('id');
        var search_str = 'search_field=' + $('#datesearch-type option:selected').val() + '&von=' + $('#search-von').val() + "&bis=" + $('#search-bis').val();
        $('#last_searchquery').val(search_str);
        $.ajax({
            url:'control/search_formulars/' + $('#payments_type').val(),
            type:'post',
            data:search_str,
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
                $(button).removeClass('loading');
            }
        });
    });

    $('.date-search input[type=text]').setdatepicker();


});