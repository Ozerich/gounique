<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="agenturen">agenturen</a></li>
            <li><span>neu agenturen</span></li>
        </ul>
    </div>
</div>


<div id="new-agenturen-page" class="kundenverwaltung-new content">
<? echo form_open("agenturen/new") ?>

<div class="new-block">
<div class="input-block">

<div class="param">
    <label for="name">Agenturen Name</label>
    <input type="text" name="name" id="name"/>
</div>

<div class="block">
    <div class="param">
        <label for="kette">Kette</label>
        <select id="kette" name="kette">
            <option value="0">No Kette</option>
            <? foreach (Kette::all() as $kette): ?>
            <option value="<?=$kette->id?>"><?=$kette->name?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="param">
        <label for="provision-level">Provision</label>
        <select id="provision-level" name="provision_level">
            <option value="0">0% No provision</option>
            <? foreach (ProvisionLevel::all() as $provision_level): ?>
            <option value="<?=$provision_level->id?>"><?=$provision_level->plain_text?></option>
            <? endforeach; ?>
        </select>
    </div>

    <div class="param">
        <label for="agenturtyp">Agenturtyp</label>
        <select id="agenturtyp" name="agenturtyp">
            <option value="1">Reisebüro</option>
            <option value="2">Fluganbieter</option>
            <option value="3">Schiff/Hotelanbieter</option>
            <option value="4">Transfer-Anbieter</option>
        </select>
    </div>
    <div class="param">
        <label for="inkasso">Inkasso</label>
        <select id="inkasso" name="inkasso">
            <option value="1">Agenturinkasso</option>
            <option value="2">Kundeninkasso</option>
        </select>
    </div>
</div>

<div class="block">
    <div class="param">
        <label for="zahlungsart">Zahlungsart</label>
        <select name="zahlungsart" id="zahlungsart">
            <option value="1">Überweisung</option>
            <option value="2">Abbucher</option>
        </select>
    </div>
    <div class="param">
        <label for="place">Airport/City</label>
        <select name="place" id="place">
            <option value="1">Airport</option>
            <option value="2">City</option>
        </select>
    </div>


    <div class="param">
        <label for="ausland">Ausland</label>
        <input type="checkbox" name="ausland" id="ausland"/>
    </div>

    <div class="param">
        <label for="status">Status</label>
        <select name="status" id="status">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

</div>

<div class="contact-block" id="kontaktdaten">
    <h2 class="block-header closed">Kontaktdaten</h2>

    <div class="contact-content">
        <div class="block">

            <div class="param">
                <label for="vorname">Vorname</label>
                <input type="text" id="vorname" name="vorname"/>
            </div>

            <div class="param">
                <label for="nachname">Nachname</label>
                <input type="text" id="nachname" name="nachname"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="land">Land</label>
                <input type="text" id="land" name="land" maxlength="20"/>
            </div>

            <div class="param">
                <label for="ort">Ort</label>
                <input type="text" id="ort" name="ort" maxlength="30"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="plz">PLZ</label>
                <input type="text" id="plz" name="plz" maxlength="6"/>
            </div>

            <div class="param">
                <label for="strasse">Strasse</label>
                <input type="text" id="strasse" name="strasse" maxlength="60"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" maxlength="15"/>
            </div>

            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" id="fax" name="fax" maxlength="15"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" maxlength="15"/>
            </div>

            <div class="param">
                <label for="website">Homepage</label>
                <input type="text" id="website" name="website" maxlength="30"/>
            </div>

        </div>

        <div class="block">

            <div class="param">
                <label for="email">E-Mail</label>
                <input type="text" id="email" name="email" maxlength="30"/>
            </div>

            <div class="param">
                <label for="email2">E-Mail 2</label>
                <input type="text" id="email2" name="email2" maxlength="30"/>
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
                <input type="text" id="bank-name" name="bank_name" maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-sitz">Sitz</label>
                <input type="text" id="bank-sitz" name="bank_sitz" maxlength="30"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="bank-blz">BLZ</label>
                <input type="text" id="bank-blz" name="bank_blz" maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-konto">Konto Nr.</label>
                <input type="text" id="bank-konto" name="bank_konto" maxlength="30"/>
            </div>
        </div>

        <div class="block">

            <div class="param">
                <label for="bank-swift">SWIFT/BIC</label>
                <input type="text" id="bank-swift" name="bank_swift" maxlength="30"/>
            </div>

            <div class="param">
                <label for="bank-iban">IBAN Nr.</label>
                <input type="text" id="bank-iban" name="bank_iban" maxlength="30"/>
            </div>
        </div>
    </div>
</div>
<br class="clear"/>
</div>

<div class="buttons">
    <a href="incoming" id="cancel-button" class="button-link">Abbrechen</a>
    <input type="submit" id="submit-button" name="add_submit" value="Add"/>
</div>
</form>

<br class="clear"/>
</div>
