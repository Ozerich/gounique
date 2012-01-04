<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="kundenverwaltung">kundenverwaltung</a></li>
            <li><a href="agenturen">agenturen</a></li>
            <li><span>agenturen <?=$client->k_num?></span></li>
        </ul>
    </div>
</div>


<div id="edit-agenturen-page" class="kundenverwaltung-new content">

    <? echo form_open("kundenverwaltung/vervalten/".$client->id) ?>

    <div class="new-block">

        <div class="param">
            <label for="name">Firmenname</label>
            <input type="text" name="name" value="<?=$client->name?>"/>
        </div>

        <div class="param">
            <label for="address">Adresse</label>
            <input type="text" name="address" value="<?=$client->address?>"/>
        </div>

        <div class="param">
            <label for="plz">PLZ / Ort</label>
            <input type="text" class="plz" name="plz" maxlength="5"  value="<?=$client->plz?>"/> /
            <input type="text" class="ort" name="ort"  value="<?=$client->ort?>"/>
        </div>

        <div class="param">
            <label for="website">Web-Seite</label>
            <input type="text" name="website"  value="<?=$client->website?>"/>
        </div>

        <div class="param">
            <label>Ansprechpartner</label>
            <input type="radio" name="sex" value="herr" <? if($client->sex == "herr") echo 'checked' ?>/>Herr&nbsp;
            <input type="radio" name="sex" value="frau" <? if($client->sex == "frau") echo 'checked' ?>/>Frau
        </div>

        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email"  value="<?=$client->email?>"/>
        </div>

        <div class="param">
            <label for="contactperson">Contact person:</label>
            <input type="text" name="person_name"  value="<?=$client->person_name?>"/>
        </div>

        <div class="param">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" value="<?=$client->phone?>"/>
        </div>

        <div class="param">
            <label for="fax">Fax</label>
            <input type="text" name="fax"  value="<?=$client->fax?>"/>
        </div>

        <div class="param" id="provision-wr">
            <label for="provision">Provision Prozent</label>
            <input type="text" name="provision"  value="<?=$client->provision?>"/>
        </div>

        <div class="param">
            <label for="about">Comment</label>
            <textarea name="about"><?=$client->about?></textarea>
        </div>

    </div>

    <div class="buttons">
        <a href="agenturen" class="button-link">Cancel</a>
        <input type="submit" name="edit_submit" class="" value="Apply"/>
    </div>


    </form>

    <br class="clear"/>
</div>
