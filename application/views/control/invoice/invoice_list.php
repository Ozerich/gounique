<? foreach ($incoming_invoices as $item): ?>
<table class="invoice-list product-list" for="<?=isset($item['incoming']) ? $item['incoming']->id : ''?>"
       style="display:<?=$type == "other" ? 'table' : 'none'?>">
    <thead>
    <th>№</th>
    <th>Inv. Amount</th>
    <th>Inv. Date</th>
    <th>Inv. Number</th>
    <th>&nbsp;</th>
    </thead>
    <tbody>
        <? if(!$item['invoices']): ?>
            <tr class="empty"><td colspan="5">No Rechnung</td></tr>
        <? else:
    $total = 0;
        foreach ($item['invoices'] as $ind => $invoice):
            $total += $invoice->amount;
            ?>
        <tr class="invoice-line">
            <input type="hidden" class="invoice_id" value="<?=$invoice->id?>"/>
            <td><?=($ind + 1)?></td>
            <td><?=$invoice->amount?></td>
            <td><?=$invoice->date->format('d.M.Y')?></td>
            <td><?=$invoice->number?></td>
            <td><a href="#" class="delete-invoice delete-icon"></a></td>
        </tr>
        <tr class="payments-block">
            <input type="hidden" value="<?=$invoice->id?>" class="invoice_id"/>
            <td colspan="10">
                <table class="product-list payments-list">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?=$item['payments'][$ind]?>
                    </tbody>

                </table>
                <a href="#" class="newpayment-open">Zahlung</a>

                <div class="newpayment-wr" style="display:none">
                    <div class="param">
                        <label for="payment-date">Payment date:</label>
                        <input type="text" class="payment-date" maxlength="8"/>
                    </div>
                    <div class="param">
                        <label for="payment-amount">Amount &euro;</label>
                        <input type="text" class="payment-amount" maxlength="8"/>
                    </div>
                    <div class="param">
                        <label for="payment-type">Payment type:</label>
                        <select class="payment-type">
                            <option value="uberweisung">Uberweisung</option>
                            <option value="kreditkart">Kreditkart</option>
                            <option value="lastschrift">Lastschrift</option>
                            <option value="bar">Bar</option>
                        </select>
                    </div>
                    <div class="remark-param">
                        <label for="payment-remark">Remark:</label>
                        <textarea class="payment-remark"></textarea>
                    </div>
                    <button class="addpayment-submit">Add Payment</button>
                </div>
            </td>
        </tr>
            <? endforeach; ?>
        <? endif; ?>
    </tbody>
</table>
<? endforeach; ?>
