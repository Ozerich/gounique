<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/flights">flugverwaltung</a></li>
            <li><span>flug <?=$flight->carrier . '-' . $flight->flug_num?></span></li>
        </ul>
    </div>
</div>

<div id="flight_page" class="content">

    <div class="new-flight-day">
        <input type="hidden" id="flight_id" name="flight_id" value="<?=$flight->id?>"/>

        <div class="datum-block-wr">
            <fieldset class="datum-block">
                <legend>CRS Daten</legend>
                <div class="param">
                    <label for="period_start">Erster Flug</label>
                    <input type="text" name="period_start" id="period_start" maxlength="8"/>
                </div>
                <div class="param">
                    <label for="period_finish">Letzter Flug</label>
                    <input type="text" name="period_finish" id="period_finish" maxlength="8"/>
                </div>
                <div class="weekdays">
                    <div class="weekday"><label for="weekday_1">Mo.</label><input type="checkbox" id="weekday_1"
                                                                                  name="weekday[1]"/></div>
                    <div class="weekday"><label for="weekday_2">Di.</label><input type="checkbox" id="weekday_2"
                                                                                  name="weekday[2]"/></div>
                    <div class="weekday"><label for="weekday_3">Mi.</label><input type="checkbox" id="weekday_3"
                                                                                  name="weekday[3]"/></div>
                    <div class="weekday"><label for="weekday_4">Do.</label><input type="checkbox" id="weekday_4"
                                                                                  name="weekday[4]"/></div>
                    <div class="weekday"><label for="weekday_5">Fr.</label><input type="checkbox" id="weekday_5"
                                                                                  name="weekday[5]"/></div>
                    <div class="weekday"><label for="weekday_6">Sa.</label><input type="checkbox" id="weekday_6"
                                                                                  name="weekday[6]"/></div>
                    <div class="weekday"><label for="weekday_7">So.</label><input type="checkbox" id="weekday_7"
                                                                                  name="weekday[7]"/></div>
                    <div class="weekday"><label for="weekday_7">Alle</label><input type="checkbox" id="weekday_all"/>
                    </div>
                </div>
                <div class="param">
                    <label for="departure_time">Abflug</label>
                    <input type="text" name="departure_time" class="time-input" id="departure_time" maxlength="5"/>
                </div>
                <div class="param">
                    <label for="arrival_time">Ankunft</label>
                    <input type="text" name="arrival_time" class="time-input" id="arrival_time" maxlength="5"/>
                </div>
            </fieldset>
            <div class="buttons">
                <input type="submit" name="save-submit" id="save-flight-period" value="Hinzufügen">
                <input type="submit" name="delete-submit" id="delete-flight-period" value="Löschen">
            </div>
        </div>
        <fieldset class="price-block">
            <legend>Preise u. Informationen</legend>
            <div class="main-info">
                <div class="param">
                    <label for="konti">Konti</label>
                    <input type="text" name="konti" id="konti" maxlength="5"/>
                </div>
                <div class="param">
                    <label for="release">Release</label>
                    <input type="text" name="release" id="release" maxlength="5"/>
                </div>
                <div class="param">
                    <label for="max_dauer">Max.Dauer</label>
                    <input type="text" name="max_dauer" id="max_dauer" maxlength="5"/>
                </div>
            </div>
            <div class="price-list">
                <div class="price-params">
                    <div class="param">
                        <label for="price_dauer">Dauer</label>
                        <input type="text" id="price_dauer" maxlength="3"/>
                    </div>

                    <div class="param">
                        <label for="price_value">Vollzahler</label>
                        <input type="text" id="price_value" maxlength="3"/>
                    </div>
                    <button id="price_add">Add</button>
                    <button id="price_delete">X</button>
                </div>
                <select id="price_list" multiple>
                </select>
            </div>
            <div class="price-discounts">
                <? foreach ($flight->classes as $ind => $class): ?>
                <div class="param">
                    <label>Klasse <?=chr(ord('A') + $ind)?></a> (<?=$class->from . '-' . $class->to?>):</label>
                    <input name="class[<?=$class->id?>]" maxlength="3" type="text"/>
                </div>
                <? endforeach; ?>

            </div>
        </fieldset>
    </div>

    <div id="flight_days_wr"><?=$flight_days?></div>
</div>

