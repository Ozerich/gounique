<table class="product-list" id="flight-invoices">
    <caption>Flight Invoices for <b><?=$formular->r_num?></b></caption>
    <thead>
    <th>№</th>
    <th>Inv. Number</th>
    <th>Inv. Date</th>
    <th>Inv. Amount</th>
    <th>Paid</th>
    <th>Status</th>
    <th>Inv. Type</th>
    <th>Remark<th>
    <th>&nbsp;</th>
    </thead>
    <tbody>
    <? if (!$invoices): ?>
    <tr class="empty">
        <td colspan="10">No invoices</td>
    </tr>
        <? else:
        $total_amount = $total_paid = $total_status = 0;
        foreach ($invoices as $ind => $invoice):
            $total_amount += $invoice->amount;
            $total_paid += $invoice->paid_amount;
            $total_status += $invoice->status;
            ?>
        <tr>
            <input type="hidden" class="invoice_id" value="<?=$invoice->id?>"/>
            <input type="hidden" class="type" value="<?=$invoice->type?>"/>
            <td><?=($ind + 1)?></td>
            <td class="number"><?=$invoice->number?></td>
            <td class="date"><?=$invoice->date->format('d.M.y')?></td>
            <td class="amount"><?=num($invoice->amount)?></td>
            <td><?=num($invoice->paid_amount)?></td>
            <td><?=$invoice->status >= 0 ? "OK" : $invoice->status . ' &euro;'?></td>
            <td><?=$invoice->plain_type?></td>
            <td class="remark"><?=$invoice->remark?></td>
            <td class="actions"><a href="#" onclick="return edit_flight_invoice(event, '<?=$invoice->id?>')" class="edit_16"></a>&nbsp;<a href="#" class="delete-flightinvoice delete-icon"></a></td>
        </tr>
        <tr class="flightpayments" style="display:none"><td colspan="10">
            <?=$payments[$ind]?>
        </td></tr>
            <? endforeach; ?>
    <tr class="total">
        <td colspan="3">&nbsp;</td>
        <td><?=num($total_amount)?></td>
        <td><?=num($total_paid)?></td>
        <td><?=num($total_status)?></td>
        <td colspan="10">&nbsp;</td>
    </tr>
        <? endif; ?>
    </tbody>
</table>