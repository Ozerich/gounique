<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="<?=$kunde->type?>"><?=$kunde->type?></a></li>
            <li><span><?=$kunde->type?> <?=$kunde->k_num?></span></li>
        </ul>
    </div>
</div>


<div id="edit-agenturen-page" class="kundenverwaltung-new content">

    <? echo form_open("kundenverwaltung/verwalten/" . $kunde->id) ?>

    <div class="new-block">

        <div class="param">
            <label for="k_num">Kundennummer:</label>
            <input type="text" name="k_num" id="k_num" value="<?=$kunde->k_num?>" />
        </div>

        <div class="param">
            <label for="name">Firmenname</label>
            <input type="text" name="name" value="<?=$kunde->name?>"/>
        </div>

        <div class="param">
            <label for="address">Adresse</label>
            <input type="text" name="address" value="<?=$kunde->address?>"/>
        </div>

        <div class="param">
            <label for="plz">PLZ / Ort</label>
            <input type="text" class="plz" name="plz" maxlength="5" value="<?=$kunde->plz?>"/> /
            <input type="text" class="ort" name="ort" value="<?=$kunde->ort?>"/>
        </div>

        <div class="param">
            <label for="website">Web-Seite</label>
            <input type="text" name="website" value="<?=$kunde->website?>"/>
        </div>

        <div class="param">
            <label>Ansprechpartner</label>
            <input type="radio" name="sex" value="herr" <? if ($kunde->sex == "herr") echo 'checked' ?>/>Herr&nbsp;
            <input type="radio" name="sex" value="frau" <? if ($kunde->sex == "frau") echo 'checked' ?>/>Frau
        </div>

        <div class="param">
            <label for="contactperson">Contact person:</label>
            <input type="text" name="person_name" value="<?=$kunde->person_name?>"/>
        </div>

        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email" value="<?=$kunde->email?>"/>
        </div>

        <div class="param">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" value="<?=$kunde->phone?>"/>
        </div>

        <div class="param">
            <label for="fax">Fax</label>
            <input type="text" name="fax" value="<?=$kunde->fax?>"/>
        </div>

        <div class="param" id="provision-wr">
            <label for="provision">Provision Prozent</label>
            <input type="text" name="provision" value="<?=$kunde->provision?>"/>
        </div>

        <div class="param">
            <label for="about">Kommentar</label>
            <textarea name="about"><?=$kunde->about?></textarea>
        </div>

    </div>

    <div class="buttons">
        <a href="agenturen" class="button-link">Abbrechen</a>
        <input type="submit" name="edit_submit" class="" value="Apply"/>
    </div>


    </form>

    <br class="clear"/>
</div>
