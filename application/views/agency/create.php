<div class="agency-item">
    <? echo form_open("agency/create") ?>
        <div class="param">
            <label for="type">Typ</label>
            <div id="type">
                <input type="radio" id="radio1" name="stage" value="1" checked/><label for="radio1">Agentur</label>
                <input type="radio" id="radio2" name="stage" value="2"/><label for="radio2">Kunde</label>
            </div>
            <br class="clear"/>
        </div>
        <div id="agentur-block">
            <div class="param">
                <label for="name">Firmenname</label>
                <input type="text" name="a_name"/>
            </div>
            <div class="param">
                <label for="address">Adresse</label>
                <input type="text" name="a_address"/>
            </div>
            <div class="param">
                <label for="plz">PLZ / Ort</label>
                <input type="text" class="plz" name="a_plz" maxlength="5"/> /
                <input type="text" class="ort" name="a_ort"/>
            </div>
            <div class="param">
                <label for="website">Web-Seite</label>
                <input type="text" name="a_website"/>
            </div>
            <div class="param">
                <label>Ansprechpartner</label>
                <input type="radio" name="a_sex" value="herr" checked/>Herr&nbsp;
                <input type="radio" name="a_sex" value="frau"/>Frau
            </div>
          
            <div class="param">
                <label for="const">Vorname</label>
                <input type="text" name="a_contactperson"/>
            </div>
            <div class="param">
                <label for="const">Nachname</label>
                <input type="text" name="a_surname"/>
            </div>
            <div class="param">
                <label for="email">E-Mail Adresse</label>
                <input type="text" name="a_email"/>
            </div>
            <div class="param">
                <label for="phone">Telefon</label>
                <input type="text" name="a_phone"/>
            </div>
            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" name="a_fax"/>
            </div>
            <div class="param" id="provision-wr">
                <label for="provision">Provision Prozent</label>
                <input type="text" name="a_provision"/>
            </div>
            <div class="param">
                <label for="comment">Comment</label>
                <textarea name="a_comment"></textarea>
            </div>
        </div>
        <div id="kunden-block">
            <div class="param">
                <label>Anrede</label>
                <input type="radio" name="k_sex" value="herr" checked/>Herr&nbsp;
                <input type="radio" name="k_sex" value="frau"/>Frau
            </div>
            <div class="param">
                <label for="contactperson">Titel</label>
                <input type="text" name="k_contactperson"/>
            </div>
            <div class="param">
                <label for="name">Name</label>
                <input type="text" name="k_name"/>
            </div>
            <div class="param">
                <label for="surname">Vorname</label>
                <input type="text" name="k_surname"/>
            </div>
            <div class="param">
                <label for="address">Strasse, Hausnummer</label>
                <input type="text" name="k_address"/>
            </div>
            <div class="param">
                <label for="plz">PLZ / Ort</label>
                <input type="text" class="plz" name="k_plz" maxlength="5"/> /
                <input type="text" class="ort" name="k_ort"/>
            </div>
            <div class="param">
                <label for="phone">Telefon</label>
                <input type="text" name="k_phone"/>
            </div>
            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" name="k_fax"/>
            </div>
            <div class="param">
                <label for="email">E-Mail Adresse</label>
                <input type="text" name="k_email"/>
            </div>
            <div class="param">
                <label for="comment">Comment</label>
                <textarea name="k_comment"></textarea>
            </div>
        </div>
        <input type="hidden" name="type" value="agency"/>

        <div class="buttons">
            <button id="cancel-button" tabindex="2" class="btn btn-small btn-grey">Cancel</button>
            <input type="submit" name="add_submit" class="btn btn-small btn-blue" value="Apply"/>
        </div>
    </form>
</div>
