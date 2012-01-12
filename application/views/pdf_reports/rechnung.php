<div class="header">
    <div class="info">
        <?=$formular->kunde->plain_text?>
    </div>
</div>
<div class="content">
    <h1>BUCHUNGSBESÄTIGUNG</h1>

    <table class="top-block">
        <tr>
            <td class="left-paramname">Vorgangsnummer:</td>
            <td class="left-paramvalue"><?=$formular->v_num?></td>
            <td class="right-paramname">Datum:</td>
            <td class="right-paramvalue"><?=$formular->rechnung_date->format("d. M. Y")?></td>
        </tr>
        <tr>
            <td class="left-paramname">Rechnungsnummer:</td>
            <td class="left-paramvalue"><?=$formular->r_num?></td>
            <td class="right-paramname">Sachbearbeiter:</td>
            <td class="right-paramvalue"><?=$formular->sachbearbeiter?></td>
        </tr>
        <tr>
            <td class="left-paramname">Agenturnummer:</td>
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
                    <td class="num"><?=($ind + 1)?></td>
                    <td class="sex"><?=$person->sex?></td>
                    <td class="person-name"><?=$person->name . "/" . $person->surname?></td>
                </tr>
                <? endforeach; ?>
            </table>
        </div>

        <div class="block">
            <h3>Reisezeitraum:</h3>
            <table class="reisezeitraum-table">
                <tr>
                    <td><?=$formular->departure_date->format('d. M. y')?></td>
                    <td class="center">bis</td>
                    <td><?=($formular->arrival_date) ? $formular->arrival_date->format('d. M. y') : ''?></td>
                </tr>
            </table>
        </div>

        <div class="block">
            <h3>Leistung:</h3>
            <table class="liestung-table">
                <? foreach ($formular->hotels_and_manuels as $ind => $item): ?>
                <tr>
                    <td class="num"><?=($ind + 1)?></td>
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

    <div class="anzahlung-block">
        <p>Anzahlung sofort nach Erhalt die Rechnung: <?=$formular->price['anzahlung_value']?> &euro;</p>

        <p>Restzahlung f&auml;llig am: <?=$formular->finalpayment_date->format('d-M-y')?>
            &nbsp;&nbsp;<?=($formular->price['brutto'] - $formular->price['anzahlung_value'])?> &euro;</p>
    </div>

    <div class="price-table">
        <table>
            <tr>
                <td class="paramname">Preis Brutto/p.Person</td>
                <td class="paramvalue"><?=$formular->price['person']?></td>
            </tr>
            <tr class="bold underline">
                <td class="paramname">Gesamtpreis</td>
                <td class="paramvalue"><?=$formular->price['brutto']?></td>
            </tr>
            <? if ($formular->kunde->type == 'agenturen'): ?>
            <tr class="green">
                <td class="paramname">Provision <?=$formular->provision?>%</td>
                <td class="paramvalue"><?=$formular->price['provision']?></td>
            </tr>
            <tr class="green">
                <td class="paramname">MWST auf Prov 19%</td>
                <td class="paramvalue"><?=$formular->price['mwst']?></td>
            </tr>
            <tr class="green">
                <td class="paramname">Total Provision:</td>
                <td class="paramvalue"><?=$formular->price['total_provision']?></td>
            </tr>
            <tr class="empty">
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr class="bold">
                <td class="paramname">Endpreise Netto</td>
                <td class="paramvalue"><?=$formular->price['netto']?></td>
            </tr>
            <? endif?>
        </table>
    </div>
</div>