<div class="top-blocks">
    <div id="anzahlung-block" class="paymentsinfo-block">
        <? if ($formular->is_sofort): ?>
        <div class="sofort">SOFORT</div>
        <? else: ?>
        <div class="param">
            <span class="param-name">Anzahlungdatum: </span>
            <span><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.y') : ''?></span>
        </div>
        <div class="param">
            <span class="param-name">Anzahlung Amount: </span>
            <span><?=num($formular->prepayment_amount)?></span>
        </div>
        <div class="param">
            <span class="param-name">Anzahlung Status: </span>
            <span><?=num($formular->anzahlung_status)?></span>
        </div>
        <? endif; ?>
    </div>
    <div id="restzahlung-block" class="paymentsinfo-block">
        <div class="param">
            <span class="param-name"><?=$formular->is_sofort ? 'Totalzahlung' : 'Restzahlungdatum'?> </span>
            <span><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.y') : ''?></span>
        </div>
        <div class="param">
            <span class="param-name"><?=$formular->is_sofort ? 'Totalzahlung' : 'Restzahlung'?> Amount: </span>
            <span><?=num($formular->finalpayment_amount)?></span>
        </div>
        <div class="param">
            <span class="param-name"><?=$formular->is_sofort ? 'Totalzahlung' : 'Restzahlung'?> Status: </span>
            <span><?=num($formular->restzahlung_status)?></span>
        </div>

        <? if(!$formular->is_storno): ?>
        <p class="versandfreigabe">Versandfreigabe</p>
        <div class="param">
            <span class="param-name">Versended</span>
            <input type="checkbox" id="check_versand" <?=$formular->is_versand ? 'checked' : ''?>/>
        </div>
        <? if ($formular->is_versand): ?>
            <div class="param">
                <span class="param-name">Versended date</span>
                <span><?=$formular->versanded_date->format('d.M.y')?></span>
            </div>
            <div class="param">
                <span class="param-name">Versended By</span>
                <span><?=$formular->versanded_user->fullname?></span>
            </div>
            <? endif; ?>
        <? endif; ?>

    </div>
    <? if($formular->kunde->type == 'agenturen' && $formular->status != "storno"):?>
        <div class="netto-wr"><input type="checkbox" id="is-netto" <?=$formular->payment_netto ? 'checked' : ''?>/><span class="netto-label">Netto</span></div>
        <? endif; ?>
    <br class="clear"/>
</div>


<table id="payments-table" class="product-list">
    <thead>
    <tr>
        <th>Pay. Date</th>
        <th>Amount</th>
        <th>Anzahlung Diff</th>
        <th>Restzahlung Diff</th>
        <th>Type</th>
        <th>Remark</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>

    <?
    $total = 0;
    $anzahlung = round($formular->prepayment_amount, 2);
    $restzahlung = round($formular->finalpayment_amount, 2);

    $anzahlung_diff = $restzahlung_diff = 0;
    $netto_payment = 0;
    foreach ($formular->payments as $payment):

        if($payment->added_by == 0)
            $netto_payment = $payment->amount;

        $total += $payment->amount;

        if ($anzahlung - $total + $netto_payment < 0)
            $anzahlung_diff = 0;
        else
            $anzahlung_diff = '-' . round($anzahlung - $total + $netto_payment, 2);
        if ($anzahlung - $total >= 0)
            $restzahlung_diff = '-' . round($restzahlung - $netto_payment, 2);
        else {
            $my_restzahlung = round($total - $anzahlung, 2);
            if ($restzahlung - $my_restzahlung < 0)
                $restzahlung_diff = '+' . round($my_restzahlung - $restzahlung, 2);
            else
                $restzahlung_diff = '-' . round($restzahlung - $my_restzahlung, 2);
        }
        ?>
    <tr class="<?$payment->added_by == 0 ? 'netto' : ''?>">
        <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
        <input type="hidden" class="payment_type" value="<?=$payment->type?>"/>
        <td class="date"><?=$payment->payment_date->format('d.M.y');?></td>
        <td class="amount"><?=num($payment->amount)?></td>
        <td><?=num($anzahlung_diff)?></td>
        <td><?=num($restzahlung_diff)?></td>
        <td class="type"><?=$payment->added_by ? $payment->plain_type : 'Provision'?></td>
        <td class="remark"><?=$payment->remark?></td>
        <td>
            <?if ($payment->added_by != 0 && $formular->status != "storno"): ?>
            <a href="#" class="delete-icon delete-payment"></a>
            <? endif; ?>
        </td>
    </tr>
        <? endforeach; ?>
    <tr class="total">
        <td>&nbsp;</td>
        <td class="total-amount"><?=@number_format($total, 2, ',', '.')?> &euro;</td>
        <td>&nbsp;</td>
        <td class="total-amount"><?=@number_format(($formular->brutto - $total) > 0 ? '-' . ($formular->brutto - $total) : '+' . ($total - $formular->brutto), 2, ',', '.')?> &euro;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>

</table>