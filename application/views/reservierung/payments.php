<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><span><?=$formular->kunde->plain_type;?> <?=$formular->kunde->k_num?></span></li>
            </li>
            <li><a href="reservierung/final/<?=$formular->id?>">formular <?=$formular->v_num?></a></li>
            <li><span>payments</span></li>
        </ul>
    </div>
</div>

<div id="payment-page" class="reservierung-page content">
    <div class="formular-header">
        <div class="left-block">
            <div class="param">
                <span class="param-name">Kundennummer:</span>
                <a href="#"><?=$formular->kunde->k_num?></a>
            </div>

            <div class="param">
                <span class="param-name">Typ:</span>
                <span class="param-value" id="formulartype-value"><?=$formular->type?></span>
            </div>

            <div class="param">
                <span class="param-name">Vorgangsnummer:</span>
                <span class="param-value" id="vorgangsnummer-value"><?=$formular->v_num?></span>
            </div>

        </div>

        <div class="right-block">

            <div class="param">
                <span class="param-name">Status:</span>
                <span class="param-value"><?=$formular->plain_status?></span>
            </div>

            <? if ($formular->status == "rechnung" || $formular->status == "freigabe"): ?>
            <div class="param">
                <span class="param-name">Rechnungsnummer:</span>
                <span class="param-value"><?=$formular->r_num?></span>
            </div>
            <? endif; ?>

        </div>
        <br class="clear"/>

    </div>
    <table class="payments-list">
        <caption>Payments for formular</caption>
        <thead>
        <th>Num</th>
        <th>Date</th>
        <th>User</th>
        <th>Money</th>
        </thead>
        <tbody>
        <? if (!$formular->payments): ?>
        <tr>
            <td colspan="4" class="nopayments">No payments for this formular</td>
        </tr>
            <? else: ?>
            <? foreach ($formular->payments as $ind => $payment): ?>
            <tr>
                <td class="num"><?=($ind + 1)?></td>
                <td class="date"><?=$payment->datetime->format("d.M.Y h:m")?></td>
                <td class="user"><?=$payment->user->fullname?></td>
                <td class="value"><?=$payment->value?> &euro;</td>
            </tr>
                <? endforeach; ?>
        <tr>
            <td colspan="3" class="total-amount">Total amount</td>
            <td class="total-amount-value"><?=$formular->paid_amount?> &euro;</td>
        </tr>
            <? endif; ?>
        </tbody>
    </table>
    <? if ($formular->status == "rechnung"): ?>
    <?= form_open("reservierung/payments/" . $formular->id)
    ; ?>
    <div class="newpayment-block">
        <label for="payment-value">Amount: </label>
        <input type="text" maxlength="4" size="4" name="payment_value" id="payment-value"/>
        <input type="submit" value="Add" class="button-link"/>
        <br class="clear"/>
    </div>
    </form>

    <? endif; ?>

    <a href="reservierung/final/<?=$formular->id?>" class="button-link">Back</a>
</div>