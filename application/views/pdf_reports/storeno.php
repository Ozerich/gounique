<div class="header">
    <div class="info">
        <?=$formular->kunde->plain_text?>
    </div>
</div>
<div class="content">
    <h1>STORNORECHNUNG</h1>

    <h2><?=$formular->kunde->type == "agenturen" ? 'Reisebüro' : 'Kunde'?></h2>

    <table class="top-block">
        <tr>
            <td class="left-paramname">Vorgangsnummer:</td>
            <td class="left-paramvalue"><?=$formular->v_num?></td>
            <td class="right-paramname">Datum:</td>
            <td class="right-paramvalue"><?=$formular->created_date->format("d. M. Y")?></td>
        </tr>
        <tr>
            <td class="left-paramname">Rechnungsnummer:</td>
            <td class="left-paramvalue">-</td>
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
        <? if ($formular->type != 'nurflug'): ?>
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
        <? endif; ?>

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
                <td class="paramvalue"><?=number_format($formular->original->brutto, 2, ',','.')?> &euro;</td>
            </tr>
            <tr>
                <td class="paramname">Stornogebühr <?=$formular->original->storno_percent ?
                    ' lt. AGB´s '.$formular->original->storno_percent.'%' : ''?></td>
                <td class="paramvalue"><?=number_format($formular->brutto, 2, ',','.')?> &euro;</td>
            </tr>
            <tr>
                <td class="paramname"><?=$formular->kunde->provision?>% Provision auf Storno</td>
                <td class="paramvalue"><?=$formular->price['provision']?> &euro;</td>
            </tr>
            <? if (!$formular->kunde->ausland): ?>
            <tr class="green">
                <td class="paramname">MWST auf Prov 19%</td>
                <td class="paramvalue"><?=$formular->price['mwst']?> &euro;</td>
            </tr>
            <? endif; ?>
            <tr>
                <td class="paramname">Gesamtprovision</td>
                <td class="paramvalue"><?=num($formular->provision_amount)?> &euro;</td>
            </tr>
        </table>
    </div>

    <div class="bottom-text">
        <p>Achtung! Reise wurde am <?=$formular->created_date->format('d.m.Y')?>
            durch <?=$formular->kunde->type == "agenturen" ? 'Reisebüro' : 'Kunde'?> storniert.
            <? if ($formular->kunde->type == "agenturen") echo 'Ihre neue Provision entnehmen Sie bitte';?>
            obengenannten Aufstellungen.</p>
        Mit freundlichen Grüßen, <br/>
        Ihr Unique World Team
    </div>


</div>