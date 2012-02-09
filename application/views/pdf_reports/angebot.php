<div class="header">
    <div class="info">
        <?=$formular->kunde->plain_text?>
    </div>
</div>
<div class="content">
    <h1><?=$formular->status == "angebot" ? 'ANGEBOT' : 'BUCHUNG'?></h1>

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
            <div class="block-header">Reiseteilnehmer:</div>
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
            <div class="block-header">Reisezeitraum:</div>
            <table class="reisezeitraum-table">
                <tr>
                    <td><?=($formular->departure_date) ? $formular->departure_date->format('d. F. Y') : ''?></td>
                    <td class="center">bis</td>
                    <td><?=($formular->arrival_date) ? $formular->arrival_date->format('d. F. Y') : ''?></td>
                </tr>
            </table>
        </div>

        <div class="block">
            <div class="block-header">Reiseteilnehmer:</div>
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
            <div class="block-header">Flugplan:</div>

            <div class="flight-plan">
                <pre><?=$formular->flight_text?></pre>
            </div>
        </div>
        <? endif; ?>
    </div>

    <div class="price-table">
        <table>
            <tr>
                <td class="paramname">Preis Brutto/p.Person</td>
                <td class="paramvalue"><?=$formular->price['person']?> &euro;</td>
            </tr>
            <tr class="bold underline">
                <td class="paramname">Gesamtpreis</td>
                <td class="paramvalue"><?=$formular->price['brutto']?> &euro;</td>
            </tr>
            <? if ($formular->kunde->type == 'agenturen'): ?>
            <tr class="green">
                <td class="paramname">Provision <?=$formular->provision?>%</td>
                <td class="paramvalue"><?=$formular->price['provision']?> &euro;</td>
            </tr>

            <? if (!$formular->kunde->ausland): ?>
                <tr class="green">
                    <td class="paramname">MWST auf Prov 19%</td>
                    <td class="paramvalue"><?=$formular->price['mwst']?> &euro;</td>
                </tr>
            <? endif; ?>


            <tr class="empty">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="bold">
                <td class="paramname">Endpreise Netto</td>
                <td class="paramvalue"><?=$formular->price['netto']?> &euro;</td>
            </tr>
            <? endif?>
        </table>
    </div>

    <div class="signature">
        <div class="text">Bei Buchungswunsch bitte unterschrieben zurückfaxen:</div>
        <div class="text signature-space">
            <div class="param-name">Name:</div>
            <div class="line"></div>
        </div>
        <div class="text">
            <div class="param-name">Unterschrift:</div>
            <div class="line"></div>
        </div>
    </div>

</div>