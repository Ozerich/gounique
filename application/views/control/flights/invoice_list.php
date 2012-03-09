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
    <th>Added</th>
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
            <td><?=($ind + 1)?></td>
            <td><?=$invoice->number?></td>
            <td><?=$invoice->date->format('d.M.Y')?></td>
            <td><?=num($invoice->amount)?></td>
            <td><?=num($invoice->paid_amount)?></td>
            <td><?=$invoice->status >= 0 ? "OK" : $invoice->status . ' &euro;'?></td>
            <td><?=$invoice->plain_type?></td>
            <td><?=$invoice->created_user->fullname?> <?=$invoice->created_date->format('d.M.Y')?></td>
            <td><a href="#" class="delete-flightinvoice delete-icon"></a></td>
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