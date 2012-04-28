<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">produkt</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>hotel <?=$hotel->code?></span></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
<h3 class="hotel-name"><?=$hotel->name?></h3>
<?=form_open("product/hotel/edit/" . $hotel->id)?>

<ul id="tabs">
    <li class="active"><span for="crs-page">CRS Daten</span></li>
    <li><span for="klassen-page">Childs & Extras</span></li>
    <li><span for="bonus-page">Bonuses</span></li>
    <li><span for="kontakt-page">Kontaktdaten</span></li>
    <li><a href="product/hotel/rooms/<?=$hotel->id?>">Pricedaten</a></li>
</ul>

<div class="page" id="crs-page">
    <div class="hotelname-wr">

        <div class="param hotelcode">
            <label for="code">Hotelcode</label>
            <input name="code" class="high-letters" type="text" value="<?=$hotel->code?>" id="code" maxlength="8"/>
        </div>

        <div class="param hotelcat">
            <label for="category">Kategorie</label>
            <input id="category" type="text" name="stars" maxlength="3" value="<?=$hotel->stars?>"/>
        </div>

        <div class="param hotelname">
            <label for="name">Hotelname</label>
            <input name="name" type="text" maxlength="255" id="name" value="<?=$hotel->name?>"/>
        </div>

        <br class="clear"/>

    </div>

    <div class="place-wr">

        <div class="param tlc">
            <label for="tlc">Hotel TLC</label>
            <input name="tlc" type="text" maxlength="3" id="tlc" value="<?=$hotel->tlc?>"/>
        </div>

        <div class="param land">
            <label for="land">Hotel Land</label>
            <input type="text" name="land" maxlength="255" value="<?=$hotel->land?>"/>
        </div>

        <div class="param zeilgebiet">
            <label for="zeilgebiet">Hotel Zielgebiet</label>
            <input type="text" id="zeilgebiet" name="zielgebiet" maxlength="255" value="<?=$hotel->zielgebiet?>"/>
        </div>

        <div class="param ort">
            <label for="ort">Hotel Ort</label>
            <input type="text" id="ort" name="ort" maxlength="255" value="<?=$hotel->ort?>"/>
        </div>

        <br class="clear"/>
    </div>

    <div class="param radios">
        <div class="left">
            <label for="flugbindung">Flugbindung</label>

            <div class="buttonset">
                <input type="radio" value="1" id="flug-on" name="flugbindung" <?=$hotel->flugbindung ? 'checked' : ''?>><label for="flug-on">On</label>
                <input type="radio" value="0" id="flug-off" name="flugbindung" <?=!$hotel->flugbindung ? 'checked' : ''?>/><label
                for="flug-off">Off</label>
            </div>
        </div>
        <div class="right">
            <label for="crs">CRS Status</label>

            <div class="buttonset">
                <input type="radio" value="1" id="crs-on" name="crs" <?=$hotel->active ? 'checked' : ''?>/><label for="crs-on">On</label>
                <input type="radio" value="0" id="crs-off" name="crs" <?=!$hotel->active ? 'checked' : ''?>/><label for="crs-off">Off</label>
            </div>
        </div>
        <br class="clear"/>
    </div>
</div>

<div class="page" id="klassen-page" style="display: none">
<div class="child-block">

    <div class="child-cat">
        <div class="child-preview">
            <span>Teen</span>
            <input type="checkbox" name="teenblock_active" <?if ($hotel->teenblock_active) echo 'checked'?>/>
        </div>
        <div class="child-content" <?if ($hotel->teenblock_active) echo 'style="display:block"'?>>
            <table>
                <thead>
                <th class="active">&nbsp;</th>
                <th class="age">von</th>
                <th class="age">bis</th>
                </thead>
                <tbody>

                <? foreach ($hotel->teens as $ind => $teen): ?>

                <tr>
                    <td class="active"><input type="checkbox"
                                              name="teen-active[<?=$ind?>]" <?if ($teen->active) echo 'checked';?>></td>
                    <input type="hidden" name="teen_id[<?=$ind?>]" value="<?=$teen->id?>"/>
                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$teen->von?>" <?if (!$teen->active) echo 'disabled'?>/>
                        <input type="hidden" value="<?=$teen->von?>" name="teen-von[<?=$ind?>]"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$teen->bis?>" <?if (!$teen->active) echo 'disabled'?>/>
                        <input type="hidden" value="<?=$teen->bis?>" name="teen-bis[<?=$ind?>]"/>
                    </td>
                </tr>

                    <? endforeach; ?>

                <tr class="example">
                    <td class="active"><input type="checkbox" for-name="teen-active" checked></td>
                    <td class="age">
                        <input type="text" maxlength="2" value="12"/>
                        <input type="hidden" value="12" for-name="teen-von"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2" value="18"/>
                        <input type="hidden" value="18" for-name="teen-bis"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="child-new">New</button>
        </div>
    </div>
    <div class="child-cat">
        <div class="child-preview">
            <span>Kind / Child</span>
            <input type="checkbox" name="childblock_active" <?if ($hotel->childblock_active) echo 'checked'?>/>
        </div>
        <div class="child-content" <?if ($hotel->childblock_active) echo 'style="display:block"'?>>
            <table>
                <thead>
                <th class="active">&nbsp;</th>
                <th class="age">von</th>
                <th class="age">bis</th>
                </thead>
                <tbody>

                <? foreach ($hotel->childs as $ind => $child): ?>

                <tr>
                    <td class="active"><input type="checkbox"
                                              name="child-active[<?=$ind?>]" <?if ($child->active) echo 'checked';?>>
                    </td>
                    <input type="hidden" name="child_id[<?=$ind?>]" value="<?=$child->id?>"/>
                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$child->von?>" <?if (!$child->active) echo 'disabled'?>/>
                        <input type="hidden" value="<?=$child->von?>" name="child-von[<?=$ind?>]"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$child->bis?>"  <?if (!$child->active) echo 'disabled'?>/>
                        <input type="hidden" value="<?=$child->bis?>" name="child-bis[<?=$ind?>]"/>
                    </td>
                </tr>

                    <? endforeach; ?>

                <tr class="example">
                    <td class="active"><input type="checkbox" for-name="child-active" checked></td>
                    <td class="age">
                        <input type="text" maxlength="2" value="2"/>
                        <input type="hidden" value="2" for-name="child-von"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2" value="12"/>
                        <input type="hidden" value="12" for-name="child-bis"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="child-new">New</button>
        </div>
    </div>
    <div class="child-cat">
        <div class="child-preview">
            <span>Baby / Infant</span>
            <input type="checkbox" name="infantblock_active" <?if ($hotel->infantblock_active) echo 'checked'?>/>
        </div>
        <div class="child-content" <?if ($hotel->infantblock_active) echo 'style="display:block"'?>>
            <table>
                <thead>
                <th class="active">&nbsp;</th>
                <th class="age">von</th>
                <th class="age">bis</th>
                </thead>
                <tbody>

                <? foreach ($hotel->infants as $ind => $infant): ?>

                <tr>
                    <td class="active"><input type="checkbox"
                                              name="infant-active[<?=$ind?>]" <?if ($infant->active) echo 'checked';?>>
                    </td>
                    <input type="hidden" name="infant_id[<?=$ind?>]" value="<?=$infant->id?>"/>

                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$infant->von?>"  <?if (!$infant->active) echo 'disabled'?> />
                        <input type="hidden" value="<?=$infant->von?>" name="infant-von[<?=$ind?>]"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2"
                               value="<?=$infant->bis?>" <?if (!$infant->active) echo 'disabled'?> />
                        <input type="hidden" value="<?=$infant->bis?>" name="infant-bis[<?=$ind?>]"/>
                    </td>
                </tr>

                    <? endforeach; ?>

                <tr class="example">
                    <td class="active"><input type="checkbox" for-name="infant-active" checked></td>
                    <td class="age">
                        <input type="text" maxlength="2" value="0"/>
                        <input type="hidden" value="0" for-name="infant-von"/>
                    </td>
                    <td class="age">
                        <input type="text" maxlength="2" value="2"/>
                        <input type="hidden" value="2" for-name="infant-bis"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <button class="child-new">New</button>
        </div>
    </div>


    <br class="clear"/>
</div>
<div class="minimum-block">
    <span class="block-header">Minimums:</span>

    <div class="minimum-list">
        <span class="empty">No minumum</span>

        <? foreach ($hotel->minimums as $ind => $minimum): ?>

        <div class="minimum-item">

            <div class="period-param param">
                <label for="von">Period von</label>
                <input type="text" class="minimum-von" name="minimum_von[<?=$ind?>]"
                       value="<?=$minimum->von ? $minimum->von->format('dmY') : ''?>"
                       maxlength="8"/>
                <label for="bis">bis</label>
                <input type="text" class="minimum-bis" name="minimum_bis[<?=$ind?>]"
                       value="<?=$minimum->bis ? $minimum->bis->format('dmY') : ''?>"
                       maxlength="8"/>
                <a href="#" class="delete-icon minimum-delete"></a>
            </div>
            <div class="period-param param">
                <label for="nachte_max">Nachte:</label>
                <input type="text" id="nachte_max" name="minimum_nights[<?=$ind?>]" value="<?=$minimum->nights?>"
                       class="minimum-nights"/>
            </div>

        </div>

        <? endforeach; ?>

        <div class="minimum-item example" style="display:none">

            <div class="period-param param">
                <label for="von">Period von</label>
                <input type="text" class="minimum-von" maxlength="8"/>
                <label for="bis">bis</label>
                <input type="text" class="minimum-bis" maxlength="8"/>
                <a href="#" class="delete-icon minimum-delete"></a>
            </div>
            <div class="period-param param">
                <label for="nachte_max">Nachte:</label>
                <input type="text" id="nachte_max" class="minimum-nights"/>
            </div>

        </div>
    </div>
    <button id="new-minimum">Neueu minimum</button>
    <br class="clear"/>
</div>
<div class="holiday-block">
    <div class="param">
        <div class="left">
            <label for="xmas_dinner">X-Mas Dinner &euro;</label>
            <input name="xmas_dinner" type="text" value="<?=$hotel->xmas_dinner?>" id="xmas_dinner"/>
        </div>
        <div class="right">
            <label for="newyear_dinner">New Year Dinner &euro;</label>
            <input type="text" name="newyear_dinner" value="<?=$hotel->newyear_dinner?>" id="newyear_dinner"/>
        </div>
        <br class="clear"/>
    </div>

</div>
<div class="extras-block">
    <div class="param">
        <label for="kontityp">Konti. Typ</label>
        <select name="kontityp" id="kontityp">
            <option value="0" <?if ($hotel->konti_typ == 0) echo 'selected';?>>Tageskontingent</option>
            <option value="1" <?if ($hotel->konti_typ == 1) echo 'selected';?>>Basispreis</option>
        </select>
    </div>
    <div class="param">
        <label for="incoming">Agentur Bin.</label>
        <select name="incoming" id="incoming">
            <? foreach (Incoming::all() as $kunde): ?>
            <option <?if ($hotel->incoming == $kunde->id) echo 'selected';?>
                value="<?=$kunde->id?>"><?=$kunde->name?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="param radios">
        <div class="left">
            <label for="optionsbuchung">Optionsbuchung</label>

            <div class="buttonset">
                <input type="radio" value="1" id="optionsbuchung-on"
                       name="optionsbuchung" <?if ($hotel->optionsbuchung) echo 'checked'?>/><label
                for="optionsbuchung-on">On</label>
                <input type="radio" value="0" id="optionsbuchung-off"
                       name="optionsbuchung" <?if (!$hotel->optionsbuchung) echo 'checked'?>/><label
                for="optionsbuchung-off">Off</label>
            </div>
        </div>
        <div class="right">
            <label for="rq_buchung">RQ Buchung</label>

            <div class="buttonset">
                <input type="radio" value="1" id="rq_buchung-on"
                       name="rq_buchung" <?if ($hotel->rq_buchung) echo 'checked'?>/><label
                for="rq_buchung-on">On</label>
                <input type="radio" value="0" id="rq_buchung-off"
                       name="rq_buchung" <?if (!$hotel->rq_buchung) echo 'checked'?>/><label
                for="rq_buchung-off">Off</label>
            </div>
        </div>
        <br class="clear"/>
    </div>
</div>
</div>


<div class="page" id="bonus-page" style="display:none">
<div class="bonus-list">
<span class="empty"></span>

<div class="bonus-list">
</div>

<button id="bonusnew-open">Neueu bonus</button>
<br class="clear"/>

<? foreach ($hotel->bonuses as $ind => $bonus): ?>
<div class="bonus-item">

    <div class="bonus-preview">
        <p><?=$bonus->text?></p>

        <div class="preview-buttons">
            <button class="bonus-edit">Edit</button>
            <button class="bonus-delete">Delete</button>
            <br class="clear"/>
        </div>
        <br class="clear"/>
    </div>

    <div class="bonus-content" style="display:none">

        <div class="period-param param">
            <label for="von">Period von</label>
            <input type="text" name="bonus_von[<?=$ind?>]"
                   value="<?=($bonus->period_start ? $bonus->period_start->format('dmY') : '')?>"
                   class="bonus-von" maxlength="8"/>
            <label for="bis">bis</label>
            <input type="text" name="bonus_bis[<?=$ind?>]"
                   value="<?=($bonus->period_finish ? $bonus->period_finish->format('dmY') : '')?>"
                   class="bonus-bis" maxlength="8"/>
        </div>

        <div class="bonus-blocks">

            <div id="bonus_1_block" class="bonus-block  <?=$bonus->type == 'night_bonus' ? 'active' : ''?>">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype" value="night_bonus"
                        <?=$bonus->type == 'night_bonus' ? 'checked' : ''?>/><label>Bonus</label>
                </div>

                <div class="param">
                    <label>Nachte</label>
                    <input type="text" name="from_nights[<?=$ind?>]" value="<?=$bonus->night_1?>" maxlength="2"
                           id="from"/> =
                    <input type="text" value="<?=$bonus->night_2?>"
                           name="to_nights[<?=$ind?>]"
                           maxlength="2" id="to"/>
                </div>
            </div>

            <div id="bonus_2_block" class="bonus-block <?=$bonus->type == 'earlybird_days' ? 'active' : ''?>">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype"
                           value="earlybird_days" <?=$bonus->type == 'earlybird_days' ? 'checked' : ''?>/><label>EB-Promo</label>
                </div>

                <div class="param">
                    <label>Days before</label>
                    <input type="text" name="days_before[<?=$ind?>]" value="<?=$bonus->days_before?>" id="days"
                           maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" name="discount1[<?=$ind?>]" id="percent" value="<?=$bonus->discount_1?>"
                           maxlength="2"/>
                </div>
            </div>

            <div id="bonus_3_block" class="bonus-block <?=$bonus->type == 'earlybird_date' ? 'active' : ''?>">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype"
                           value="earlybird_date" <?=$bonus->type == 'earlybird_date' ? 'checked' : ''?>/><label>EarlyBird</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" name="booking_till[<?=$ind?>]"
                           value="<?=$bonus->booking_till ? $bonus->booking_till->format('dmY') : ''?>"
                           class="booking_till" maxlength="8"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" name="discount2[<?=$ind?>]" id="discount2" value="<?=$bonus->discount_2?>"
                           maxlength="2"/>
                </div>
            </div>

            <div id="bonus_4_block" class="bonus-block <?=$bonus->type == 'long_stay' ? 'active' : ''?>">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype"
                           value="long_stay" <?=$bonus->type == 'long_stay' ? 'checked' : ''?>/><label>Longstay</label>
                </div>

                <div class="param">
                    <label>Days count</label>
                    <input type="text" name="days_count[<?=$ind?>]" value="<?=$bonus->days_count?>" id="days_count"
                           maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" id="discount3" name="discount3[<?=$ind?>]" value="<?=$bonus->discount_3?>"
                           maxlength="2"/>
                </div>
            </div>

            <div id="bonus_5_block" class="bonus-block <?=$bonus->type == 'turbo_bonus' ? 'active' : ''?>">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype"
                           value="turbo_bonus" <?=$bonus->type == 'turbo_bonus' ? 'checked' : ''?>/><label>Turbo
                    bonus</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" name="booking_till_2[<?=$ind?>]"
                           value="<?=$bonus->booking_till_2 ? $bonus->booking_till_2->format('dmY') : ''?>"
                           class="booking_till_2" maxlength="8"/>
                </div>
                <div class="param">
                    <label>Discount &euro;</label>
                    <input type="text" id="discount4" name="discount4[<?=$ind?>]" value="<?=$bonus->discount_4?>"
                           maxlength="2"/>
                </div>
            </div>

            <br class="clear"/>
        </div>

        <div class="buttons">
            <button class="bonusadd-cancel">Cancel</button>
            <button class="bonusadd-submit">Add</button>
            <br class="clear"/>
        </div>

        <br class="clear"/>
    </div>
</div>
    <? endforeach; ?>

<div class="bonus-item example" style="display:none">

    <div class="bonus-preview">
        <p></p>

        <div class="preview-buttons">
            <button class="bonus-edit">Edit</button>
            <button class="bonus-delete">Delete</button>
            <br class="clear"/>
        </div>
        <br class="clear"/>
    </div>

    <div class="bonus-content" style="display:none">

        <div class="period-param param">
            <label for="von">Period von</label>
            <input type="text" for-name="bonus_von" class="bonus-von" maxlength="8"/>
            <label for="bis">bis</label>
            <input type="text" for-name="bonus_bis" class="bonus-bis" maxlength="8"/>
        </div>

        <div class="bonus-blocks">

            <div id="bonus_1_block" class="bonus-block active">
                <div class="radio">
                    <input type="radio" for-name="bonus_type" class="bonustype" value="night_bonus"
                           checked/><label>Bonus</label>
                </div>

                <div class="param">
                    <label>Nachte</label>
                    <input type="text" for-name="from_nights" maxlength="2" id="from"/> = <input type="text"
                                                                                                 for-name="to_nights"
                                                                                                 maxlength="2"
                                                                                                 id="to"/>
                </div>
            </div>

            <div id="bonus_2_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" for-name="bonustype" class="bonustype"
                           value="earlybird_days"/><label>EB-Promo</label>
                </div>

                <div class="param">
                    <label>Days before</label>
                    <input type="text" for-name="days_before" id="days" maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" for-name="discount1" id="percent" maxlength="2"/>
                </div>
            </div>

            <div id="bonus_3_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" for-name="bonustype" class="bonustype"
                           value="earlybird_date"/><label>EarlyBird</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" for-name="booking_till" class="booking_till" maxlength="8"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" for-name="discount2" id="discount2" maxlength="2"/>
                </div>
            </div>

            <div id="bonus_4_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" for-name="bonustype" class="bonustype"
                           value="long_stay"/><label>Longstay</label>
                </div>

                <div class="param">
                    <label>Days count</label>
                    <input type="text" for-name="days_count" id="days_count" maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" id="discount3" for-name="discount3" maxlength="2"/>
                </div>
            </div>

            <div id="bonus_5_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" for-name="bonustype" class="bonustype"
                           value="turbo_bonus"/><label>Turbo bonus</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" for-name="booking_till_2" class="booking_till_2" maxlength="8"/>
                </div>
                <div class="param">
                    <label>Discount &euro;</label>
                    <input type="text" for-name="discount4" id="discount4" maxlength="2"/>
                </div>
            </div>

            <br class="clear"/>
        </div>

        <div class="buttons">
            <button class="bonusadd-cancel">Cancel</button>
            <button class="bonusadd-submit">Add</button>
            <br class="clear"/>
        </div>

        <br class="clear"/>
    </div>
</div>

</div>

</div>

<div class="page" id="kontakt-page" style="display:none">
    <div class="param">
        <label for="vorname">Vorname</label>
        <input type="text" name="kontakt_vorname" value="<?=$hotel->kontakt_vorname?>" id="vorname"/>
    </div>
    <div class="param">
        <label for="nachname">Nachname</label>
        <input type="text" name="kontakt_nachname" value="<?=$hotel->kontakt_nachname?>" id="nachname"/>
    </div>
    <div class="param">
        <label for="strasse">Strasse</label>
        <input type="text" name="kontakt_strasse" value="<?=$hotel->kontakt_strasse?>" id="strasse"/>
    </div>
    <div class="param">
        <label for="postleitzahl">Postleitzahl</label>
        <input type="text" name="kontakt_postleitzahl" value="<?=$hotel->kontakt_postleitzahl?>" id="postleitzahl"/>
    </div>
    <div class="param">
        <label for="ort">Ort</label>
        <input type="text" name="kontakt_ort" value="<?=$hotel->kontakt_ort?>" id="ort"/>
    </div>
    <div class="param">
        <label for="land">Land</label>
        <input type="text" name="kontakt_land" value="<?=$hotel->kontakt_land?>" id="land"/>
    </div>
    <div class="param">
        <label for="phone">Tel. Nr.</label>
        <input type="text" name="kontakt_phone" value="<?=$hotel->kontakt_phone?>" id="phone"/>
    </div>
    <div class="param">
        <label for="fax">Fax Nr.</label>
        <input type="text" name="kontakt_fax" value="<?=$hotel->kontakt_fax?>" id="fax"/>
    </div>
    <div class="param">
        <label for="email">E-Mail</label>
        <input type="text" name="kontakt_email" value="<?=$hotel->kontakt_email?>" id="email"/>
    </div>
    <div class="param">
        <label for="homepage">Homepage</label>
        <input type="text" name="kontakt_homepage" value="<?=$hotel->kontakt_homepage?>" id="homepage"/>
    </div>

</div>

<div class="submit">

    <input type="submit" name="zimmer_create" value="Apply">
</div>
<br class="clear"/>
</form>
</div>