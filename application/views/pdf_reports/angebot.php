<div id="page">
    <div id="header">
        <br/><br/><br/><br/><br/><br/><br/><br/>

        <div class="address">
            <?
            if ($formular->agency->type == "agency")
                echo $formular->agency->contactperson . ' ' . $formular->agency->surname . ' - ' . $formular->agency->sex . '<br/>' .
                     'e-mail: <a href="mailto:' . $formular->agency->email . '">' . $formular->agency->email . '</a><br/>' .
                     'phone: ' . $formular->agency->phone . '<br/>' .
                     'fax: ' . $formular->agency->fax . '<br/>' .
                     'www: <a href="' . $formular->agency->website . '">' . $formular->agency->website . '</a><br/>';
            else echo $formular->agency->name . ' ' . $formular->agency->surname . ' - ' . $formular->agency->sex . ' (' . $formular->agency->contactperson . ')<br/>' .
                      'e-mail: <a href="mailto:' . $formular->agency->email . '">' . $formular->agency->email . '</a><br/>' .
                      'phone: ' . $formular->agency->phone . '<br/>' .
                      'fax: ' . $formular->agency->fax . '<br/>';
            ?>
        </div>
    </div>
    <div id="content">
        <h1>REISEANGEBOT</h1>

        <div class="vorgansnummer-wr">
            <div class="left">
                <div class="header">Vorgangsnummer <?=$formular->v_num?></div>
                <br/>

                <div class="nummer"><strong>Abreisedatum: <?=$formular->abreisedatum?></strong></div>
            </div>
            <div class="right">
                <div>Datum: <?=mdate("%d.%m.%Y", time());?></div>
                <div>Sachbearbeiter: <?=$user->name." ".$user->surname?></div>
            </div>
        </div>
        <div class="mainblock">
            <div class="persons">
                <span class="header">Reiseteilnehmer:</span>
                <? foreach ($formular->person_list as $ind => $person): ?>
                <div class="person">
                    <div class="num"><?=($ind + 1)?></div>
                    <? if ($person['name'] != ""): ?>
                    <div class="sex"><?=$person['sex']?></div>
                    <div class="name"><?=$person['name']?></div>
                    <? endif; ?>
                </div>
                <? endforeach; ?>
                <br class="clear"/>
            </div>
            <div class="tours">
                <span class="header">Leistung:</span>
                <? foreach ($formular->hotel_list as $ind => $hotel): ?>
                <div class="tour">
                    <div class="date"> <?=$hotel['date_start']?> - <?=$hotel['date_end']?></div>
                    <div class="content">  <?=$hotel['days_count']?>tN HOTEL: <?=$hotel['name']?> /
                        <?=$hotel['room_capacity']?> / <?=$hotel['room_type']?> / <?=$hotel['room_service']?> /
                        TRANSFER <?=$hotel['transfer']?> / <?=$hotel['comment']?>
                    </div>
                </div>
                <? endforeach; ?>
                <? foreach ($formular->manuel_list as $ind => $manuel): ?>
                <div class="tour">
                    <div class="date"> <?=$manuel['date_start']?> - <?=$manuel['date_end']?></div>
                    <div class="content"><?=$manuel['text']?></div>
                </div>
                <? endforeach; ?>
            </div>
            <? if ($formular->flight_plan != ""): ?>
            <div class="flugplan">
                <span class="header">Flugplan:</span>

                <div class="content">
                    <pre><?=$formular->flight_plan?></pre>
                </div>
            </div>
            <? endif; ?>
        </div>
        <div class="undertable">
            <?if ($formular->anzahlung != 0): ?>
            <?=$price['anzahlung'];?>% Anzahlung (<?=$price['anzahlung_value']?> &euro;) nach Erhalt der Rechnung.
            <?if ($price['anzahlung'] != 100) echo 'Restzahlung bis $zahlungsdatum (' . $price['brutto'] . ' - ' . $price['anzahlung_value'] . '&euro;)';?>
            <? endif; ?>
        </div>
        <div class="commentblock">
            <pre>
                <?=$formular->comment?>
            </pre>
        </div>
        <div class="priceblock">
            <div class="price-item">Preis p.P. brutto: <?=$price['person']?> &euro;</div>
            <div class="price-item">Gesamtpreis brutto: <?=$price['brutto']?> &euro;</div>
            <? if ($formular->agency->type == 'agency'): ?>
            <div class="price-item">$provision % Provision: <?=$price['provision']?> &euro;</div>
            <div class="price-item">19 % Mwst: <?=$price['percent']?> &euro;</div>
            <? endif; ?>
            <div class="price-item"><b>Gesamtpreis netto: <?=$price['netto']?> &euro;</b></div>
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