<div class="kunde-item">
    <? echo form_open("kunde/edit", "", array("kunde_id" => $kunde->id)); ?>
    <div class="kunde-params">
        <? if ($kunde->type == 'kunde'): ?>
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
            <input type="radio" name="sex" value="herr" <?if ($kunde->sex == 'man') echo 'checked' ?>/>Herr&nbsp;
            <input type="radio" name="sex" value="frau" <?if ($kunde->sex == 'woman') echo 'checked' ?>/>Frau
        </div>
        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email" value="<?=$kunde->email?>"/>
        </div>
        <div class="param">
            <label for="contactperson">Contact person:</label>
            <input type="text" name="person_name" value="<?=$kunde->person_name?>"/>
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
            <label for="about">Comment</label>
            <textarea name="about"><?=$kunde->about?></textarea>
        </div>
        <? else: ?>
        <div class="param">
            <label>Sex</label>
            <input type="radio" name="sex" value="herr" <?if ($kunde->sex == 'man') echo 'checked' ?>/>Herr&nbsp;
            <input type="radio" name="sex" value="frau" <?if ($kunde->sex == 'woman') echo 'checked' ?>/>Frau
        </div>
        <div class="param">
            <label for="contactperson">Titel</label>
            <input type="text" name="name" value="<?=$kunde->name?>"/>
        </div>
        <div class="param">
            <label for="name">Name</label>
            <input type="text" name="person_name" value="<?=$kunde->person_name?>"/>
        </div>
        <div class="param">
            <label for="surname">Vorname</label>
            <input type="text" name="person_surname" value="<?=$kunde->person_surname?>"/>
        </div>
        <div class="param">
            <label for="address">Strasse, Hausnummer</label>
            <input type="text" name="address" value="<?=$kunde->address?>"/>
        </div>
        <div class="param">
            <label for="plz">PLZ / Ort</label>
            <input type="text" class="plz" name="plz" maxlength="5" value="<?=$kunde->plz?>"/> /
            <input type="text" class="ort" name="ort" value="<?=$kunde->ort?>"/>
        </div>
        <div class="param">
            <label for="phone">Telefon</label>
            <input type="text" name="phone" value="<?=$kunde->phone?>"/>
        </div>
        <div class="param">
            <label for="fax">Fax</label>
            <input type="text" name="fax" value="<?=$kunde->fax?>"/>
        </div>
        <div class="param">
            <label for="email">E-Mail Adresse</label>
            <input type="text" name="email" value="<?=$kunde->email?>"/>
        </div>
        <div class="param">
            <label for="about">Comment</label>
            <textarea name="about"><?=$kunde->about?></textarea>
        </div>
        <? endif ?>
    </div>
    <div class="buttons">
        <button id="cancel-button" tabindex="2" class="btn btn-small btn-grey">Cancel</button>
        <input type="submit" name="edit_submit" class="btn btn-small btn-blue" value="Apply"/>
    </div>
    </form>
</div>