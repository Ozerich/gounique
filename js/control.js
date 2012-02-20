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

    $('#is-netto').click(function () {
        $(this).attr('disabled', 'disabled');
        var check = $(this);
        $.ajax({
            url:'control/toggle_netto/' + $('#payments_formular_id').val(),
            success:function (data) {
                $(check).removeAttr('disabled');
                $('#payments-page .payment-content').empty().html(data);
                BindPaymentEvents();
            }
        });
    });

}

function UpdateInvoicePaymentsList(block) {
    $(block).find('.delete-payment').click(function () {
        var payment_id = $(this).parents('tr').find('.payment_id').val();
        var payments_block = $(this).parents('.payments-block');
        $.ajax({
            url:'control/delete_payment/invoice/' + $('#invoice_formular_id').val() + '/' + payment_id,
            type:'post',
            data:'invoice_id=' + $(payments_block).find('.invoice_id').val()
                + '&invoice_type=' + $(this).parents('.incoming-block').find('.block-type').val(),
            success:function (data) {
                data = jQuery.parseJSON(data);
                $(payments_block).find('.payments-list tbody').empty().html(data.payments);
                $(payments_block).prev().find('.invoice-status').html(data.invoice_status);
                $('#statistik').empty().html(data.stats);
                UpdateInvoicePaymentsList($(payments_block));
            }
        });
        return false;
    });
}

function UpdateInvoiceList(invoice_block) {

    UpdateInvoicePaymentsList(invoice_block);

    $(invoice_block).find('.delete-invoice').click(function () {
        var delete_button = $(this);

        $("#invoice-delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            buttons:{
                "Delete":function () {
                    var invoice_id = $(delete_button).parents('tr').find('.invoice_id').val();
                    var block = $(delete_button).parents('.incoming-block');
                    $.ajax({
                        url:'control/delete_invoice/' + invoice_id,
                        success:function (data) {
                            data = jQuery.parseJSON(data);
                            $(block).find('.invoices').empty().html(data.invoices);
                            $('#statistik').empty().html(data.stats);
                            UpdateInvoiceList(block);
                            $(block).find('.incoming-type').change();
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel:function () {
                    $(this).dialog("close");
                    cancel = true;
                }
            }
        });

        return false;
    });


    $(invoice_block).find('.newpayment-open').click(function () {
        var payment_block = $(this).parents('.payments-block').find('.newpayment-wr').toggle();
        $(this).html($(payment_block).is(':visible') ? 'Close Zahlung' : 'Zahlung');
        return false;
    });

    $(invoice_block).find('.addpayment-submit').click(function () {
        var block = $(this).parents('.newpayment-wr');
        var error = false;
        $(block).find('input[type=text]').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('error');
                error = true;
            }
            else
                $(this).removeClass('error');
        });
        if (error)
            return false;
        var invoice_type = $(this).parents('.incoming-block').find('.block-type').val();
        var payments_block = $(this).parents('.payments-block');
        $.ajax({
            url:'control/add_payment/invoice/' + $('#invoice_formular_id').val(),
            type:'post',
            data:'invoice_id=' + $(this).parents('.payments-block').find('.invoice_id').val() + '&amount=' + $(block).find('.payment-amount').val() + '&type=' + $(block).find('.payment-type option:selected').val() +
                '&date=' + $(block).find('.payment-date').val() + '&remark=' + $(block).find('.payment-remark').val() +
                '&invoice_type=' + invoice_type,
            success:function (data) {
                data = jQuery.parseJSON(data);
                $(payments_block).find('.newpayment-open').click();
                $(payments_block).find('.payments-list tbody').empty().html(data.payments);
                $(payments_block).prev().click().find('.invoice-status').html(data.invoice_status);
                $('#statistik').empty().html(data.stats);
                $(payments_block).find('input[type=text], textarea, select').val('');
                UpdateInvoicePaymentsList($(payments_block));
            }
        });
        return false;
    });

    $(invoice_block).find('.newpayment-wr .payment-date').setdatepicker();
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

    $('#invoice-list tbody tr').click(function () {
            if ($(this).hasClass('current')) {
                var formular_id = $(this).find('.formular_id').val();
                document.location = 'control/invoice/' + formular_id;
            }
            else {
                $('#invoice-list tr').removeClass('current');
                $(this).addClass('current');
            }
        }
    );


}

function OpenOverlay() {
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
    $('#dark-overlay').css({'width':maskWidth, 'height':maskHeight});
    $('#dark-overlay').fadeIn(1000);
    $('#dark-overlay').fadeTo("slow", 0.8, function () {
        $(this).addClass('finished')
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

        //$('#controlpayments-list tr').removeClass('current');
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
        OpenOverlay();

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

    $('#clear_filter').click(function () {
        $('.hotellist-top input').val('');
        $.ajax({
            url:'control/search_formulars/incoming',
            success:function (data) {
                $('#controlpayments-list tbody').empty().html(data);
                BindSelectLineEvent();
            }
        });
        return false;
    });

    $('.date-search #datesearch-start').click(function () {

        $('.date-search input[type=text]:visible').each(function () {
            if ($(this).val() == "")
                $(this).addClass('error');
            else
                $(this).removeClass('error');
        });

        if ($('.date-search input[type=text]:visible.error').size())return false;

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

    $('.date-search #search-von, .date-search #search-bis').setdatepicker();

    $('.incoming-block .new-invoice').click(function () {
        var new_block = $(this).parents('.incoming-block').find('.newinvoice-block');
        if ($(new_block).is(':visible'))
            $(this).html('Rechnung');
        else
            $(this).html('Close');

        $(new_block).toggle();

        return false;
    });

    $('.incoming-block .incoming-type').change(
        function () {
            var incoming_id = $(this).val();
            var block = $(this).parents('.incoming-block');
            $(block).find('.invoice-list').hide();
            $(block).find('.invoice-list[for=' + incoming_id + ']').show();
        }).change();

    $('.incoming-block .newinvoice-block .invoice-date').setdatepicker();

    $('.incoming-block .add-invoice').click(function () {

        var block = $(this).parents('.incoming-block');

        var error = false;
        $(block).find('.newinvoice-block input[type=text]').each(function () {
            if ($(this).val() == '') {
                $(this).addClass('error');
                error = true;
            }
            else
                $(this).removeClass('error');
        });

        if (!error) {
            var button = $(this);
            $(this).attr('disabled', 'disabled');
            var type = $(block).find('.block-type').val();
            $.ajax({
                url:'control/add_invoice/' + $('#invoice_formular_id').val() + "/" +
                    (type == "other" ? '' : $(block).find('.incoming-type option:selected').val()),
                type:'post',
                data:'date=' + $(block).find('.invoice-date').val() + '&amount=' + $(block).find('#invoice-amount').val() +
                    '&remark=' + $(block).find('#invoice-remark').val() + '&type=' + type + '&number=' + $(block).find('.invoice-num').val(),
                success:function (data) {
                    $(block).find('input[type=text],textarea').val('');
                    $(button).removeAttr('disabled');
                    $(block).find('.new-invoice').click();
                    data = jQuery.parseJSON(data);
                    $(block).find('.invoices').empty().html(data.invoices);
                    $('#statistik').empty().html(data.stats);
                    $(block).find('.incoming-type').change();
                    UpdateInvoiceList(block);
                }
            });
        }
    });

    UpdateInvoiceList($('.invoice-list'));
});