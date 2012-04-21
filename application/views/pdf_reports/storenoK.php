<div class="header">
    <div class="info">
        <?=$formular->kunde->plain_text?>
    </div>
</div>
<div class="content">
    <h1>STORNORECHNUNG</h1>

    <h2>Kundenkopie</h2>

    <table class="top-block">
        <tr>
            <td class="left-paramname">Vorgangsnummer:</td>
            <td class="left-paramvalue"><?=$formular->v_num?></td>
            <td class="right-paramname">Datum:</td>
            <td class="right-paramvalue"><?=$formular->created_date->format("d. M. Y")?></td>
        </tr>
        <tr>
            <td class="left-paramname">Stornorechnungsnummer:</td>
            <td class="left-paramvalue"><?=$formular->r_num?></td>
            <td class="right-paramname">Sachbearbeiter:</td>
            <td class="right-paramvalue"><?=$formular->sachbearbeiter->fullname?></td>
        </tr>
        <tr>
            <td class="left-paramname">Kundennummer:</td>
            <td class="left-paramvalue"><?=$formular->kunde->k_num?></td>
            <td class="right-paramname" colspan="2"></td>
        </tr>
    </table>

    <div class="main-block">

        <div class="block first">
            <h3>Reiseteilnehmer:</h3>
            <table class="reiseteilnehmer-table">
                <? foreach ($formular->persons as $ind => $person): ?>
                <tr>
                    <td class="sex"><?=$person->plain_sex?></td>
                    <td class="person-name"><?=$person->name . "/" . $person->surname?></td>
                </tr>
                <? endforeach; ?>
            </table>
        </div>

        <div class="block">
            <h3>Reisezeitraum:</h3>
            <table class="reisezeitraum-table">
                <tr>
                    <td><?=($formular->departure_date) ? $formular->departure_date->format('d. F. Y') : ''?></td>
                    <td class="center">bis</td>
                    <td><?=($formular->arrival_date) ? $formular->arrival_date->format('d. F. Y') : ''?></td>
                </tr>
            </table>
        </div>

        <div class="block">
            <h3>Leistung:</h3>
            <table class="liestung-table">
                <? foreach ($formular->hotels_and_manuels as $ind => $item): ?>
                <tr>
                    <td class="text"><?=$item->pdf_text?></td>
                </tr>
                <? endforeach; ?>
            </table>
        </div>

        <?if ($formular->flight_text != ""): ?>
        <div class="block">
            <h3>Flugplan:</h3>

            <div class="flight-plan">
                <pre><?=$formular->flight_text?></pre>
            </div>
        </div>
        <? endif; ?>
    </div>

    <div class="storeno-price-table">
        <table>
            <tr>
                <td class="paramname">Gesamtreisepreis:</td>
                <td class="paramvalue"><?=num($formular->original->brutto)?> &euro;</td>
            </tr>
            <tr>
                <td class="paramname">
                    Stornogebühr <?=$formular->original->storno_percent ? $formular->original->storno_percent . '%' : ''?></td>
                <td class="paramvalue"><?=num($formular->original->brutto - $formular->brutto);?> &euro;</td>
            </tr>
            <tr>
                <td class="paramname">Ihre Zahlung</td>
                <td class="paramvalue"><?=num($formular->paid_amount);?> &euro;</td>
            </tr>
            <tr>
                <td class="paramname">Saldo</td>
                <td class="paramvalue"><?=num($formular->paid_amount - $formular->brutto);?> &euro;</td>
            </tr>
        </table>
    </div>

    <div class="bottom-text">
        <p>Achtung! Reise wurde am <?=$formular->created_date->format('d.m.Y')?> durch Kunde storniert.</p>

        <? if (($formular->paid_amount - $formular->brutto) < 0): ?>
        <p>Bitte überweisen Sie den Betrag in Höhe von <?=num($formular->brutto - $formular->paid_amount)?> &euro;
            auf unser Geschäftskonto:<br/></p>
        <div class="param"><b>Commerzbank AG</b></div>
        <div class="param"><b>Kto.: 420 131 500</b></div>
        <div class="param"><b>BLZ: 200 400 00</b></div>
        <div class="param"><b>Verwendungszweck: <?=$formular->r_num?></b> (Bitte unbedingt angeben!)</div>
        <? elseif (($formular->paid_amount - $formular->brutto) > 0): ?>
        Bitte teilen Sie uns Ihre Bankverbindung zweck Rücküberweisung mit.
        <? endif; ?>

        <p>Mit freundlichen Grüßen, <br/>
        Ihr Unique World Team</p>
    </div>


</div>