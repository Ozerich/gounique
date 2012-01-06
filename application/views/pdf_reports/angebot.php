<div id="page">
    <div id="header">
        <br/><br/><br/><br/><br/><br/><br/><br/>

        <div class="address">
            <?=$formular->kunde->plain_text?>
        </div>
    </div>
    <div id="content">
        <h1>REISEANGEBOT</h1>

        <div class="vorgansnummer-wr">
            <div class="left">
                <div class="header">Vorgangsnummer: <?=$formular->v_num?></div>
                <br/>

                <div class="nummer"><strong>Abreisedatum: <?=$formular->prepayment_date->format('d.m.Y')?></strong></div>
            </div>
            <div class="right">
                <div>Datum: <?=mdate("%d.%m.%Y", time());?></div>
                <div>Sachbearbeiter:<?=$user->name . " " . $user->surname?></div>
            </div>
        </div>
        <div class="mainblock">
            <div class="persons">
                <span class="header">Reiseteilnehmer:</span>
                <? foreach ($formular->persons as $ind => $person): ?>
                <div class="person">
                    <div class="num"><?=($ind + 1)?></div>
                    <? if ($person->person_name != ""): ?>
                    <div class="sex"><?=FormularPerson::$sex_map[$person->sex]?></div>
                    <div class="name"><?=$person->person_name?></div>
                    <? endif; ?>
                </div>
                <? endforeach; ?>
                <br class="clear"/>
            </div>
            <div class="tours">
                <span class="header">Leistung:</span>
                <? foreach ($formular->hotels as $ind => $hotel): ?>
                <div class="tour">
                    <div class="date"> <?=$hotel->date_start->format('d.m.Y')?> - <?=$hotel->date_end->format('d.m.Y')?></div>
                    <div class="content"><?=$hotel->nodate_text;?></div>
                </div>
                <? endforeach; ?>
                <? foreach ($formular->manuels as $ind => $manuel): ?>
                <div class="tour">
                    <div class="date"> <?=$manuel->date_start->format('d.m.Y')?> - <?=$manuel->date_end->format('d.m.Y')?></div>
                    <div class="content"><?=$manuel->nodate_text?></div>
                </div>
                <? endforeach; ?>
            </div>
            <? if ($formular->flight_text != ""): ?>
            <div class="flugplan">
                <span class="header">Flugplan:</span>

                <div class="content">
                    <pre><?=$formular->flight_text?></pre>
                </div>
            </div>
            <? endif; ?>
        </div>
        <div class="undertable">
            <?if ($formular->prepayment): ?>
            <?=$formular->price['anzahlung']?>% Anzahlung (<?=$formular->price['anzahlung_value']?> &euro;) nach Erhalt der Rechnung.
            <?if ($formular->price['anzahlung'] != 100) echo 'Restzahlung bis $zahlungsdatum (' . $formular->price['brutto'] . ' - ' . $formular->price['anzahlung_value'] . '&euro;)';?>
            <? endif; ?>
        </div>
        <div class="commentblock">
            <pre>
                <?=$formular->comment?>
            </pre>
        </div>
        <div class="priceblock">
            <div class="price-item">Preis p.P. brutto: <?=$formular->price['person']?> &euro;</div>
            <div class="price-item">Gesamtpreis brutto: <?=$formular->price['brutto']?> &euro;</div>
            <? if ($formular->kunde->type == 'kunde'): ?>
            <div class="price-item"><?=$formular->provision?> % Provision: <?=$formular->price['provision']?> &euro;</div>
            <div class="price-item">19 % Mwst: <?=$formular->price['mwst']?> &euro;</div>
            <? endif; ?>
            <div class="price-item"><b>Gesamtpreis netto: <?=$formular->price['netto']?> &euro;</b></div>
        </div>
        <div class="bottomblock">
            <div class="signature">
                <span>Bei Buchungswunsch bitte unterschrieben zurückfaxen:</span>

                <div class="line"></div>
            </div>
            <p>Mit freundlichen Grüßen</p>
            <span><?=$user->name . " " . $user->surname?> <br/>Unique World GmbH</span>
        </div>
    </div>
    <div id="footer"></div>
</div>