function open_comment(evnt) {
    evnt.preventDefault();

    var line = $(evnt.target).parents('tr');

    $('.finance-new-comment').hide();
    $(line).find('.finance-new-comment').show();

    return false;
}

function close_comment(evnt) {
    $('.finance-new-comment').hide();
}

function save_comment(evnt, type) {
    var line = $(evnt.target).parents('tr');
    $(line).find('.comment-baloon pre').html($(line).find('.finance-new-comment-text').val());

    $.post('control/update_comment/' + type + '/' + $(line).find('.formular_id').val(), 'text=' + $(line).find('.finance-new-comment-text').val());
    $('.finance-new-comment').hide();
}

function show_comment_baloon(evnt){
    var line = $(evnt.target).parents('tr');
    $(line).find('.comment-baloon').show();
}

function hide_comment_baloon(evnt){
    var line = $(evnt.target).parents('tr');
    $(line).find('.comment-baloon').hide();
}

function edit_flight_invoice(evnt, invoice_id) {

    //  $('#inv-newsubmit').hide();
    $('#inv-editsubmit').show();

    var row = $(evnt.target).parents('tr');

    var date = str_replace('.', ' ', $(row).find('.date').html());
    date = new Date(date);

    $('.new-flightinvoice #inv-number').val($(row).find('.number').html());
    $('.new-flightinvoice #inv-remark').val($(row).find('.remark').html());
    $('.new-flightinvoice #inv-amount').val(PriceToInput($(row).find('.amount').html()));
    $('.new-flightinvoice #inv-date').val(DateToInput(date));
    $('.new-flightinvoice #inv-type option[value=' + $(row).find('.type').val() + ']').attr('selected', 'selected');
    $('#editinvoice_id').val(invoice_id);

    evnt.stopPropagation();
    return false;
}


function BindPaymentEvents(block) {
    $('#payments-table').find('.delete-payment').click(function () {
        var block = $(this).parents('tr');
        var payment_id = $(block).find('.payment_id').val();
        var delete_button = $(this);
        $("#payment-delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            stack:true,
            buttons:{
                "Delete":function () {
                    $(delete_button).hide();
                    $.ajax({
                        url:'control/delete_payment/' + $('#payments_type').val() + '/' + $('#payments_formular_id').val() + '/' + payment_id,
                        type:'post',
                        success:function (data) {
                            $('#payments-page .payment-content').empty().html(data);
                            BindPaymentEvents();
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

    $('#payments-table tr').not('.total, .netto').click(function () {
        $('#save-payment').show();
        var date = str_replace('.', ' ', $(this).find('.date').html());
        date = new Date(date);
        $('#savepayment-id').val($(this).find('.payment_id').val());
        $('#new-payment #payment-date').val(DateToInput(date));
        $('#new-payment #payment-amount').val(PriceToInput($(this).find('.amount').html()));
        $('#new-payment #payment-remark').val($(this).find('.remark').html());
        $('#new-payment #payment-type').val($(this).find('.payment_type').val());
        $('#new-payment #payment_id').val($(this).find('payment_id').val());
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

    $(block).find('.payment-line').click(function () {
        var new_block = $(this).parents('.incoming-block').find('.newpayment-wr');
        $(new_block).parents('.incoming-block').find('.newpayment-open').html('Close Zahlung');
        $(new_block).show().find('.save-payment').show();
        $(new_block).find('.save-payment-id').val($(this).find('.payment_id').val());
        $(new_block).find('.payment-date').val(DateToInput($(this).find('.date').html()));
        $(new_block).find('.payment-amount').val(PriceToInput($(this).find('.amount').html()));
        $(new_block).find('.payment-remark').val($(this).find('.remark').html());

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

    $(invoice_block).find('.invoice-line').click(function () {
        var new_block = $(this).parents('.incoming-block').find('.newinvoice-block');
        $(new_block).parents('.incoming-block').find('.new-invoice').html('Close');
        $(new_block).show().find('.save-invoice').show();
        $(new_block).find('.save-invoice-id').val($(this).find('.invoice_id').val());
        $(new_block).find('.invoice-num').val($(this).find('.number').html());
        $(new_block).find('.invoice-date').val(DateToInput($(this).find('.date').html()));
        $(new_block).find('.invoice-amount').val(PriceToInput($(this).find('.amount').html()));
        $(new_block).find('.invoice-remark').val($(this).find('.remark').html());
    });


    $(invoice_block).find('.newpayment-open').click(function () {
        var payment_block = $(this).parents('.payments-block').find('.newpayment-wr').toggle().reset().find('.save-payment').hide();
        $(this).html($(payment_block).is(':visible') ? 'Close Zahlung' : 'Zahlung');
        return false;
    });

    $(invoice_block).find('.save-payment').click(function () {
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
            url:'control/update_payment/invoice/' + $(block).find('.save-payment-id').val(),
            type:'post',
            data:'invoice_id=' + $(this).parents('.payments-block').find('.invoice_id').val() + '&amount=' + $(block).find('.payment-amount').val() + '&type=' + $(block).find('.payment-type option:selected').val() +
                '&date=' + $(block).find('.payment-date').val() + '&remark=' + $(block).find('.payment-remark').val() +
                '&invoice_type=' + invoice_type,
            success:function (data) {
                data = jQuery.parseJSON(data);
                $(payments_block).find('.newpayment-open').click();
                $(payments_block).find('.payments-list tbody').empty().html(data.payments);
                $(payments_block).prev().find('.invoice-status').html(data.invoice_status);
                $('#statistik').empty().html(data.stats);
                $(payments_block).find('input[type=text], textarea, select').val('');
                UpdateInvoicePaymentsList($(payments_block));
            }
        });

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
                $(payments_block).prev().find('.invoice-status').html(data.invoice_status);
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
    $('#controlpayments-list tbody tr').not('.total, .comment').find('td').not('.no-popup').click(function () {
        var line = $(this).parents('tr');
        if ($(line).hasClass('current')) {
            if ($(line).hasClass('no-open'))
                return false;
            $('#show-payments').click();
        }
        else {
            $('#controlpayments-list tr').removeClass('current');
            $('#controlpayments-list tr.comment').hide();
            $(line).addClass('current');
            if ($(line).next().hasClass('comment'))
                $(line).next().show();
            $('#show-payments').show();
        }
    });

    $('#invoice-list tbody tr').not('.total').find('td').not('.no-popup').click(function () {
            var line = $(this).parents('tr');
            if ($(line).hasClass('current')) {
                var formular_id = $(line).find('.formular_id').val();
                document.location = 'control/invoice/' + formular_id;
            }
            else {
                $('#invoice-list tr').removeClass('current');
                $(line).addClass('current');
            }
        }
    );


    $('#flight-list tbody tr').not('.total').find('td').not('.no-popup').click(function () {
            var line = $(this).parents('tr');
            if ($(line).hasClass('current')) {
                var formular_id = $(line).find('.formular_id').val();
                document.location = 'control/flights/' + formular_id;
            }
            else {
                $('#flight-list tr').removeClass('current');
                $(line).addClass('current');
            }
        }
    );


}

function UpdateFlightInvoiceEvents() {
    $('.set_datepicker').setdatepicker();
    $('#flightinvoice-list > table > tbody > tr').not('.total, .flightpayments').click(function () {
            $('#flightinvoice-list tr.flightpayments').hide();
            if ($(this).hasClass('current')) {
                $(this).removeClass('current');
            }
            else {
                $('#flightinvoice-list tr').removeClass('current');
                $(this).addClass('current');
                $(this).next().show();
            }
        }
    );

    $('.flightpayments-list tr').not('.total').click(function () {
        $('.newpayment-wr, #save-payment').show();
        $('.newpayment-wr #amount').val(PriceToInput($(this).find('.amount').html()));
        $('.newpayment-wr #remark').val($(this).find('.remark').html());
        var date = str_replace('.', ' ', $(this).find('.date').html());
        $('.newpayment-wr .payment-date').val(DateToInput(new Date(date)));
        $('.newpayment-wr #type option[value=' + $(this).find('.payment_type').val() + ']').attr('selected', 'selected');

        $('#save_payment_id').val($(this).find('.payment_id').val());
        return false;
    });

    $('.newpayment-wr #save-payment').click(function () {
        var block = $(this).parents('.new-flightpayment-wr');
        if ($(block).find('input').check_empty() == false)
            return false;

        $.ajax({
            data:$(block).find('form').serialize(),
            type:'post',
            url:'control/update_flightpayment/' + $('#invoice_formular_id').val() + '/' + $('#save_payment_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
                $('.newpayment-wr #save-payment').hide();
            }
        });

        $(block).find('.newpayment-wr').hide().reset();
        $(this).hide();
        $(block).find('.open-flightpayment').show();

        return false;
    });

    $('#flightinvoice-list .delete-flightpayment').click(function () {

        var payment_id = $(this).parents('tr').find('.payment_id').val();
        var block = $(this).parents('.new-flightpayment-wr');

        $("#invoicepayment-delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            buttons:{
                "Delete":function () {
                    $.ajax({
                        data:"payment_id=" + payment_id,
                        type:'post',
                        url:'control/delete_flightpayment/' + $('#invoice_formular_id').val(),
                        success:function (data) {
                            $('#flightinvoice-list').empty().html(data);
                            UpdateFlightInvoiceEvents();
                        }
                    });

                    $(block).find('.newpayment-wr').hide();
                    $(block).find('.open-flightpayment').show();
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

    $('#flightinvoice-list').find('.delete-flightinvoice').click(function () {
        var invoice_id = $(this).parents('tr').find('.invoice_id').val();
        var block = $(this).parents('.new-flightpayment-wr');

        $("#invoice-delete-confirm").dialog({
            resizable:false,
            height:140,
            modal:true,
            buttons:{
                "Delete":function () {
                    $.ajax({
                        data:"invoice_id=" + invoice_id,
                        type:'post',
                        url:'control/delete_flightinvoice/' + $('#invoice_formular_id').val(),
                        success:function (data) {
                            $('#flightinvoice-list').empty().html(data);
                            UpdateFlightInvoiceEvents();
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

    $('.open-flightpayment').click(function () {
        $(this).hide();
        $(this).parents('.new-flightpayment-wr').find('.newpayment-wr').show();
        return false;
    });

    $('.add_flightpayment-submit').click(function () {
        var block = $(this).parents('.new-flightpayment-wr');
        if ($(block).find('input[type=text]').check_empty() == false)
            return false;

        $.ajax({
            data:$(block).find('form').serialize(),
            type:'post',
            url:'control/add_flightpayment/' + $('#invoice_formular_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
            }
        });

        $(block).find('.newpayment-wr').hide();
        $(block).find('.open-flightpayment').show();

        return false;
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

                $('#new-payment #save-payment').click(function () {

                    if ($('#new-payment #payment-date').val() == "" || $('#new-payment #payment-amount').val() == "")
                        return false;

                    $('#new-payment').find('input, textarea').attr('disabled', 'disabled');
                    $.ajax({
                        url:'control/update_payment/' + $('#payments_type').val() + '/' + $('#new-payment #savepayment-id').val(),
                        type:'post',
                        data:'date=' + $('#new-payment #payment-date').val() +
                            '&amount=' + $('#new-payment #payment-amount').val() +
                            '&remark=' + $('#new-payment #payment-remark').val() +
                            '&type=' + $('#new-payment #payment-type option:selected').val(),
                        success:function (data) {
                            $('#payments-page .payment-content').html(data);
                            BindPaymentEvents();
                            $('#new-payment #save-payment').hide();
                            $('#new-payment').find('input, textarea').val('').removeAttr('disabled');
                        }
                    });
                    return false;
                });

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

        if ($('.date-search input[type=text]:visible.error').size())return false;

        $(this).addClass('loading');
        var button = $(this);
        var search_field = $(this).attr('id');
        var search_str = 'search_field=' + $('#datesearch-type option:selected').val() + '&von=' + $('#search-von').val() + "&bis=" + $('#search-bis').val();
        if ($('#ag_num').val())
            search_str += '&ag_num=' + $('#ag_num').val();
        if ($('#person').val())
            search_str += '&person=' + $('#person').val();

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
        if ($(new_block).is(':visible')) {
            $(this).html('Rechnung');
            $(new_block).find('.save-invoice').hide();
        }
        else
            $(this).html('Close');

        $(new_block).reset().toggle();

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

    $('.incoming-block .save-invoice').click(function () {
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

        var data = 'date=' + $(block).find('.invoice-date').val() + '&amount=' + $(block).find('.invoice-amount').val() +
            '&remark=' + $(block).find('.invoice-remark').val() + '&type=' + $(block).find('.block-type').val() + '&number=' + $(block).find('.invoice-num').val();
        var button = $(this);
        if (!error) {
            $(button).attr('disabled', 'disabled');
            $.ajax({
                url:'control/update_invoice/' + $(block).find('.save-invoice-id').val(),
                type:'post',
                data:data,
                success:function (data) {
                    $(block).find('input[type=text],textarea').val('');
                    $(block).find('.new-invoice').click();
                    data = jQuery.parseJSON(data);
                    $(block).find('.invoices').empty().html(data.invoices);
                    $('#statistik').empty().html(data.stats);
                    $(block).find('.incoming-type').change();
                    UpdateInvoiceList(block);
                },
                complete:function () {
                    $(button).removeAttr('disabled');
                }
            });
        }
        return false;
    });

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
                url:'control/add_invoice/' + $('#invoice_formular_id').val() +
                    (type == "other" ? '' : "/" + $(block).find('.incoming-type option:selected').val()),
                type:'post',
                data:'date=' + $(block).find('.invoice-date').val() + '&amount=' + $(block).find('.invoice-amount').val() +
                    '&remark=' + $(block).find('.invoice-remark').val() + '&type=' + $(block).find('.block-type').val() + '&number=' + $(block).find('.invoice-num').val(),
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

    $('#control-page #ag_num').liveSearch({
        url:'kundenverwaltung/livesearch/',
        width:400
    });

    $('#open-outgoing').click(function () {
        $('#close-outgoing').show();
        $('#main-menu').hide();
        $('#outgoing').fadeIn("slow");
        return false;
    });

    $('#close-outgoing').click(function () {
        $('#outgoing').fadeOut(function () {
            $('#main-menu').show();
        });
        return false;
    });


    $('#inv-newsubmit').click(function () {
        if ($('.new-flightinvoice input[type=text]').check_empty() == false)
            return false;
        $('.new-flightinvoice .loading').show();
        $(this).hide();
        $.ajax({
            data:$('.new-flightinvoice form').serialize(),
            type:'post',
            url:'control/add_flightinvoice/' + $('#invoice_formular_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
                $('.new-flightinvoice').reset();
            },
            complete:function () {
                $('.new-flightinvoice .loading').hide();
                $('.new-flightinvoice #inv-newsubmit').show();
            }
        });
        return false;
    });

    $('#inv-editsubmit').click(function () {
        if ($('.new-flightinvoice input').check_empty() == false)
            return false;
        $('.new-flightinvoice #inv-newsubmit').hide();
        $.ajax({
            data:$('.new-flightinvoice form').serialize(),
            type:'post',
            url:'control/update_flightinvoice/' + $('#invoice_formular_id').val() + '/' + $('#editinvoice_id').val(),
            success:function (data) {
                $('#flightinvoice-list').empty().html(data);
                UpdateFlightInvoiceEvents();
                $('.new-flightinvoice').reset();
                $('#inv-editsubmit').hide();
            },
            complete:function () {
                $('.new-flightinvoice .loading').hide();
                $('.new-flightinvoice #inv-newsubmit').show();
            }
        });
        return false;
    });

    UpdateFlightInvoiceEvents();


});