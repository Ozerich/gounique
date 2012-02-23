<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="agenturen">agenturen</a></li>
            <li><span>agenture № <?=$agency->id?></span></li>
        </ul>
    </div>
</div>


<div id="new-agenturen-page" class="kundenverwaltung-new content">
<? echo form_open("agenturen/" . $agency->id) ?>

<div class="new-block">
<div class="input-block">

<div class="param">
    <label for="name">Agenturen Name</label>
    <input type="text" name="name" id="name" value="<?=$agency->name?>"/>
</div>
<div class="top-blocks">
    <div class="block">
        <div class="param">
            <label for="kette">Kette</label>
            <select id="kette" name="kette">
                <option value="0" <?=$agency->kette_id == 0 ? 'selected' : ''?>>No Kette</option>
                <? foreach (Kette::all() as $kette): ?>
                <option <?=$agency->kette_id == $kette->id ? 'selected' : ''?>
                    value="<?=$kette->id?>"><?=$kette->name?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="param">
            <label for="provision-level">Provision</label>
            <select id="provision-level" name="provision_level">
                <option value="0" <?=$agency->provision_level == 0 ? 'selected' : ''?>>0% No provision</option>
                <? foreach (ProvisionLevel::all() as $provision_level): ?>
                <option <?=$agency->provision_level == $provision_level->id ? 'selected' : ''?>
                    value="<?=$provision_level->id?>"><?=$provision_level->plain_text?></option>
                <? endforeach; ?>
            </select>
        </div>

        <div class="param">
            <label for="agenturtyp">Agenturtyp</label>
            <select id="agenturtyp" name="agenturtyp">
                <option value="1" <?=$agency->agenturtyp == 1 ? 'selected' : ''?>>Reisebüro</option>
                <option value="2" <?=$agency->agenturtyp == 2 ? 'selected' : ''?>>Fluganbieter</option>
                <option value="3" <?=$agency->agenturtyp == 3 ? 'selected' : ''?>>Schiff/Hotelanbieter</option>
                <option value="4" <?=$agency->agenturtyp == 4 ? 'selected' : ''?>>Transfer-Anbieter</option>
            </select>
        </div>
        <div class="param">
            <label for="inkasso">Inkasso</label>
            <select id="inkasso" name="inkasso">
                <option value="1" <?=$agency->inkasso == 1 ? 'selected' : ''?>>Agenturinkasso</option>
                <option value="2" <?=$agency->inkasso == 2 ? 'selected' : ''?>>Kundeninkasso</option>
            </select>
        </div>
    </div>

    <div class="block">
        <div class="param">
            <label for="zahlungsart">Zahlungsart</label>
            <select name="zahlungsart" id="zahlungsart">
                <option value="1" <?=$agency->zahlungsart == 1 ? 'selected' : ''?>>Überweisung</option>
                <option value="2" <?=$agency->zahlungsart == 2 ? 'selected' : ''?>>Abbucher</option>
            </select>
        </div>

        <div class="param">
            <label for="place">Airport/City</label>
            <select name="place" id="place">
                <option value="1" <?=$agency->place == 1 ? 'selected' : ''?>>Airport</option>
                <option value="2" <?=$agency->place == 2 ? 'selected' : ''?>>City</option>
            </select>
        </div>


        <div class="param">
            <label for="ausland">Ausland</label>
            <input type="checkbox" name="ausland" id="ausland" <?=$agency->ausland ? 'checked' : ''?>/>
        </div>

        <div class="param">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="1" <?=$agency->active == 1 ? 'selected' : ''?>>Active</option>
                <option value="0" <?=$agency->active == 0 ? 'selected' : ''?>>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="contact-block" id="kontaktdaten">
    <h2 class="block-header closed">Kontaktdaten</h2>

    <div class="contact-content">
        <div class="block">

            <div class="param">
                <label for="vorname">Vorname</label>
                <input type="text" id="vorname" name="vorname" value="<?=$agency->person_name?>"/>
            </div>

            <div class="param">
                <label for="nachname">Nachname</label>
                <input type="text" id="nachname" name="nachname" value="<?=$agency->person_surname?>"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="land">Land</label>
                <input type="text" id="land" name="land" value="<?=$agency->land?>" maxlength="20"/>
            </div>

            <div class="param">
                <label for="ort">Ort</label>
                <input type="text" id="ort" name="ort" value="<?=$agency->ort?>" maxlength="30"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="plz">PLZ</label>
                <input type="text" id="plz" name="plz" value="<?=$agency->plz?>" maxlength="6"/>
            </div>

            <div class="param">
                <label for="strasse">Strasse</label>
                <input type="text" id="strasse" name="strasse" value="<?=$agency->strasse?>" maxlength="200"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?=$agency->phone?>" maxlength="15"/>
            </div>

            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" id="fax" name="fax" value="<?=$agency->fax?>" maxlength="15"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" value="<?=$agency->mobile?>" maxlength="15"/>
            </div>

            <div class="param">
                <label for="website">Homepage</label>
                <input type="text" id="website" name="website" value="<?=$agency->website?>" maxlength="30"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="email">E-Mail</label>
                <input type="text" id="email" name="email" value="<?=$agency->email?>" maxlength="30"/>
            </div>

            <div class="param">
                <label for="email2">E-Mail</label>
                <input type="text" id="email2" name="email2" value="<?=$agency->email2?>" maxlength="30"/>
            </div>


        </div>
    </div>
</div>

<div class="contact-block">
    <h2 class="block-header closed">Bankverbindung</h2>

    <div class="contact-content">
        <div class="block">

            <div class="param">
                <label for="bank-name">Bank</label>
                <input type="text" id="bank-name" name="bank_name" value="<?=$agency->bank_name?>"
                       maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-sitz">Sitz</label>
                <input type="text" id="bank-sitz" name="bank_sitz" value="<?=$agency->bank_sitz?>"
                       maxlength="30"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="bank-blz">BLZ</label>
                <input type="text" id="bank-blz" name="bank_blz" value="<?=$agency->bank_blz?>" maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-konto">Konto Nr.</label>
                <input type="text" id="bank-konto" name="bank_konto" value="<?=$agency->bank_konto?>"
                       maxlength="30"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="bank-swift">SWIFT/BIC</label>
                <input type="text" id="bank-swift" name="bank_swift" value="<?=$agency->bank_swift?>"
                       maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-iban">IBAN Nr.</label>
                <input type="text" id="bank-iban" name="bank_iban" value="<?=$agency->bank_iban?>"
                       maxlength="30"/>
            </div>
        </div>
    </div>
</div>
<br class="clear">

</div>

<div class="buttons">
    <a href="agenturen" id="cancel-button" class="button-link">Abbrechen</a>
    <input type="submit" id="submit-button" name="add_submit" value="Save"/>
</div>
</form>

<br class="clear"/>
</div>
