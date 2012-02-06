<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotel">hotelverwaltung</a></li>
            <li><span>hotel <?=$hotel->code?></span></li>
        </ul>
    </div>
</div>

<div id="hotelcreate-page" class="content product-create">
<?=form_open("product/hotel/edit/" . $hotel->id)?>

<ul id="tabs">
    <li class="active"><span for="crs-page">CRS Daten</span></li>
    <li><span for="klassen-page">Childs & Extras</span></li>
    <li><span for="bonus-page">Bonuses</span></li>
    <li><span for="kontakt-page">Kontaktdaten</span></li>
    <li><a href="product/hotel/rooms/<?=$hotel->id?>">Zimmerdaten</a></li>
</ul>

<div class="page" id="crs-page">
    <div class="param">
        <label for="code">Hotelcode</label>
        <input name="code" class="high-letters" type="text" value="<?=$hotel->code?>" id="code" maxlength="10"/>
    </div>

    <div class="param">
        <label for="name">Hotelname</label>
        <input name="name" type="text" id="name" value="<?=$hotel->name?>"/>
    </div>

    <div class="param">
        <label for="category">Kategorie</label>
        <input name="stars" type="text" id="category" value="<?=$hotel->stars?>"/>
    </div>

    <div class="param">
        <label for="tlc">Hotel TLC</label>
        <input name="tlc" type="text" id="tlc" value="<?=$hotel->tlc?>"/>
    </div>

    <div class="param">
        <label for="zielgibiet">Zielgebiet</label>
        <input name="zielgibiet" type="text" id="zielgibiet" value="<?=$hotel->zielgebiet?>"/>
    </div>

    <div class="param">
        <label for="ort">Hotel Ort</label>
        <input name="ort" type="text" id="ort" value="<?=$hotel->ort?>"/>
    </div>

    <div class="param">
        <label for="land">Hotel Land</label>
        <input name="land" type="text" id="land" value="<?=$hotel->land?>"/>
    </div>

    <div class="param radios">
        <div class="left">
            <label for="flugbindung">Flugbindung</label>

            <div class="buttonset">
                <input type="radio" value="1" id="flug-on"
                       name="flugbindung" <?if ($hotel->flugbindung) echo 'checked';?>/><label for="flug-on">On</label>
                <input type="radio" value="0" id="flug-off"
                       name="flugbindung" <?if (!$hotel->flugbindung) echo 'checked';?>/><label
                for="flug-off">Off</label>
            </div>
        </div>
        <div class="right">
            <label for="crs">CRS Status</label>

            <div class="buttonset">
                <input type="radio" value="1" id="crs-on" name="crs" <?if ($hotel->active) echo 'checked';?>/><label
                for="crs-on">On</label>
                <input type="radio" value="0" id="crs-off" name="crs" <?if (!$hotel->active) echo 'checked';?>/><label
                for="crs-off">Off</label>
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
                       value="<?=$minimum->von->format('dmY')?>"
                       maxlength="8"/>
                <label for="bis">bis</label>
                <input type="text" class="minimum-bis" name="minimum_bis[<?=$ind?>]"
                       value="<?=$minimum->bis->format('dmY')?>"
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
            <? foreach (Kunde::find('all', array('conditions' => array("type = 'incoming'"))) as $kunde): ?>
            <option <?if ($hotel->incoming == $kunde->id) echo 'selected';?>
                value="<?=$kunde->id?>"><?=$kunde->k_num . " " . $kunde->name?></option>
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
<span class="empty">No bonuses</span>

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
            <input type="text" name="bonus_von[<?=$ind?>]" value="<?=$bonus->period_start->format('dmY')?>"
                   class="bonus-von" maxlength="8"/>
            <label for="bis">bis</label>
            <input type="text" name="bonus_bis[<?=$ind?>]" value="<?=$bonus->period_finish->format('dmY')?>"
                   class="bonus-bis" maxlength="8"/>
        </div>

        <div class="bonus-blocks">

            <div id="bonus_1_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype" value="night_bonus"
                           <?=$bonus->type == 'night_bonus' ? 'checked' : ''?>/><label>Nachte
                    bonus</label>
                </div>

                <div class="param">
                    <label>Nachte</label>
                    <input type="text" name="from_nights[<?=$ind?>]"  value="<?=$bonus->night_1?>" maxlength="2" id="from"/> =
                    <input type="text" value="<?=$bonus->night_2?>"
                           name="to_nights[<?=$ind?>]"
                           maxlength="2" id="to"/>
                </div>
            </div>

            <div id="bonus_2_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype" value="earlybird_days" <?=$bonus->type == 'earlybird_days' ? 'checked' : ''?>/><label>EarlyBird(days)</label>
                </div>

                <div class="param">
                    <label>Days before</label>
                    <input type="text" name="days_before[<?=$ind?>]"  value="<?=$bonus->days_before?>" id="days" maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" name="discount1[<?=$ind?>]" id="percent"  value="<?=$bonus->discount_1?>" maxlength="2"/>
                </div>
            </div>

            <div id="bonus_3_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype" value="earlybird_date" <?=$bonus->type == 'earlybird_date' ? 'checked' : ''?>/><label>EarlyBird(date)</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" name="booking_till[<?=$ind?>]"  value="<?=$bonus->booking_till ? $bonus->booking_till->format('dmY') : ''?>" id="booking_till" maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" name="discount2[<?=$ind?>]" id="discount2"  value="<?=$bonus->discount_2?>" maxlength="2"/>
                </div>
            </div>

            <div id="bonus_4_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" name="bonustype[<?=$ind?>]" class="bonustype"
                           value="long_stay" <?=$bonus->type == 'long_stay' ? 'checked' : ''?>/><label>Longstay</label>
                </div>

                <div class="param">
                    <label>Days count</label>
                    <input type="text" name="days_count[<?=$ind?>]"  value="<?=$bonus->days_count?>" id="days_count" maxlength="2"/>
                </div>
                <div class="param">
                    <label>Discount %</label>
                    <input type="text" id="discount3" name="discount3[<?=$ind?>]"  value="<?=$bonus->discount_3?>" maxlength="2"/>
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

            <div id="bonus_1_block" class="bonus-block">
                <div class="radio">
                    <input type="radio" for-name="bonus_type" class="bonustype" value="night_bonus"
                           checked/><label>Nachte bonus</label>
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
                    <input type="radio" for-name="bonustype" class="bonustype" value="earlybird_days"/><label>EarlyBird(days)</label>
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
                    <input type="radio" for-name="bonustype" class="bonustype" value="earlybird_date"/><label>EarlyBird(date)</label>
                </div>

                <div class="param">
                    <label>Booking till</label>
                    <input type="text" for-name="booking_till" id="booking_till" maxlength="2"/>
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