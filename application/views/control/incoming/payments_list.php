<div class="top-blocks">
    <div id="anzahlung-block" class="paymentsinfo-block">
        <? if ($formular->is_sofort): ?>
        <div class="sofort">SOFORT</div>
        <? else: ?>
        <div class="param">
            <span class="param-name">Anzahlungdatum: </span>
            <span><?=$formular->prepayment_date ? $formular->prepayment_date->format('d.M.Y') : ''?></span>
        </div>
        <div class="param">
            <span class="param-name">Anzahlung Amount: </span>
            <span><?=$formular->prepayment_amount?></span>
        </div>
        <div class="param">
            <span class="param-name">Anzahlung Status: </span>
            <span><?=$formular->anzahlung_status?></span>
        </div>
        <? endif; ?>
    </div>
    <div id="restzahlung-block" class="paymentsinfo-block">
        <div class="param">
            <span class="param-name">Restzahlungdatum: </span>
            <span><?=$formular->finalpayment_date ? $formular->finalpayment_date->format('d.M.Y') : ''?></span>
        </div>
        <div class="param">
            <span class="param-name">Restzahlung Amount: </span>
            <span><?=$formular->finalpayment_amount?></span>
        </div>
        <div class="param">
            <span class="param-name">Restzahlung Status: </span>
            <span><?=$formular->restzahlung_status?></span>
        </div>
        <? if($formular->is_freigabe): ?>
        <p class="versandfreigabe">Versandfreigabe</p>
        <div class="param">
            <span class="param-name">Versended</span>
            <input type="checkbox" id="check_versand" <?=$formular->is_versand ? 'checked' : ''?>/>
        </div>
            <? if($formular->is_versand): ?>
            <div class="param">
                <span class="param-name">Versended date</span>
                <span><?=$formular->versanded_date->format('d.M.Y')?></span>
            </div>
            <div class="param">
                <span class="param-name">Versended By</span>
                <span><?=$formular->versanded_user->fullname?></span>
            </div>
            <? endif; ?>
        <? endif; ?>
    </div>
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
    $anzahlung = $formular->prepayment_amount;
    $restzahlung = $formular->finalpayment_amount;
    $anzahlung_diff = $restzahlung_diff = 0;
    foreach ($formular->payments as $payment):
        $total += $payment->amount;

        if ($anzahlung - $total < 0)
            $anzahlung_diff = 0;
        else
            $anzahlung_diff = '-' . ($anzahlung - $total);

        if ($anzahlung - $total >= 0)
            $restzahlung_diff = '-' . $restzahlung;
        else {
            $my_restzahlung = $total - $anzahlung;
            if ($restzahlung - $my_restzahlung < 0)
                $restzahlung_diff = '+' . ($my_restzahlung - $restzahlung);
            else
                $restzahlung_diff = '-' . ($restzahlung - $my_restzahlung);
        }
        ?>
    <tr>
        <input type="hidden" class="payment_id" value="<?=$payment->id?>"/>
        <td><?=$payment->payment_date->format('d.M.Y');?></td>
        <td><?=$payment->amount?></td>
        <td><?=$anzahlung_diff?></td>
        <td><?=$restzahlung_diff?></td>
        <td><?=$payment->plain_type?></td>
        <td><?=$payment->remark?></td>
        <td><a href="#" class="delete-icon delete-payment"></a></td>
    </tr>
        <? endforeach; ?>
    <tr>
        <td>&nbsp;</td>
        <td class="total-amount"><?=$total?> &euro;</td>
        <td>&nbsp;</td>
        <td class="total-amount"><?=$restzahlung_diff?> &euro;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>

</table>