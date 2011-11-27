<div class="agency-item">
    <? echo form_open("agency/edit", "", array("agency_id" => $agency->id)); ?>
        <div class="agency-params">
            <? if($agency->type ==  'agency'): ?>
            <div class="param">
                <label for="name">Firmenname</label>
                <input type="text" name="name" value="<?=$agency->name?>"/>
            </div>
            <div class="param">
                <label for="address">Adresse</label>
                <input type="text" name="address" value="<?=$agency->address?>"/>
            </div>
            <div class="param">
                <label for="plz">PLZ / Ort</label>
                <input type="text" class="plz" name="plz" maxlength="5" value="<?=$agency->plz?>"/> /
                <input type="text" class="ort" name="ort" value="<?=$agency->ort?>"/>
            </div>
            <div class="param">
                <label for="website">Web-Seite</label>
                <input type="text" name="website" value="<?=$agency->website?>"/>
            </div>
            <div class="param">
                <label>Ansprechpartner</label>
                <input type="radio" name="sex" value="herr" <?if($agency->sex == 'herr') echo 'checked' ?>/>Herr&nbsp;
                <input type="radio" name="sex" value="frau" <?if($agency->sex == 'frau') echo 'checked' ?>/>Frau
            </div>
            <div class="param">
                <label for="const">Vorname</label>
                <input type="text" name="contactperson" value="<?=$agency->contactperson?>"/>
            </div>
            <div class="param">
                <label for="const">Nachname</label>
                <input type="text" name="surname" value="<?=$agency->surname?>" />
            </div>
            <div class="param">
                <label for="email">E-Mail Adresse</label>
                <input type="text" name="email" value="<?=$agency->email?>"/>
            </div>
            <div class="param">
                <label for="phone">Telefon</label>
                <input type="text" name="phone" value="<?=$agency->phone?>"/>
            </div>
            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" name="fax" value="<?=$agency->fax?>"/>
            </div>
            <div class="param" id="provision-wr">
                <label for="provision">Provision Prozent</label>
                <input type="text" name="provision" value="<?=$agency->provision?>"/>
            </div>
            <div class="param">
                <label for="comment">Comment</label>
                <textarea name="comment"><?=$agency->comment?></textarea>
            </div>
            <? else: ?>
            <div class="param">
                <label>Sex</label>
                <input type="radio" name="sex" value="herr" <?if($agency->sex == 'herr') echo 'checked' ?>/>Herr&nbsp;
                <input type="radio" name="sex" value="frau" <?if($agency->sex == 'frau') echo 'checked' ?>/>Frau
            </div>
            <div class="param">
                <label for="contactperson">Titel</label>
                <input type="text" name="contactperson" value="<?=$agency->contactperson?>"/>
            </div>
            <div class="param">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?=$agency->name?>"/>
            </div>
            <div class="param">
                <label for="surname">Vorname</label>
                <input type="text" name="surname" value="<?=$agency->surname?>"/>
            </div>
            <div class="param">
                <label for="address">Strasse, Hausnummer</label>
                <input type="text" name="address" value="<?=$agency->address?>"/>
            </div>
            <div class="param">
                <label for="plz">PLZ / Ort</label>
                <input type="text" class="plz" name="plz" maxlength="5" value="<?=$agency->plz?>"/> /
                <input type="text" class="ort" name="ort" value="<?=$agency->ort?>"/>
            </div>
            <div class="param">
                <label for="phone">Telefon</label>
                <input type="text" name="phone" value="<?=$agency->phone?>"/>
            </div>
            <div class="param">
                <label for="fax">Fax</label>
                <input type="text" name="fax" value="<?=$agency->fax?>"/>
            </div>
            <div class="param">
                <label for="email">E-Mail Adresse</label>
                <input type="text" name="email" value="<?=$agency->email?>"/>
            </div>
            <div class="param">
                <label for="comment">Comment</label>
                <textarea name="comment"><?=$agency->comment?></textarea>
            </div>
            <? endif ?>
        </div>
        <div class="buttons">
            <button id="cancel-button" tabindex="2" class="btn btn-small btn-grey">Cancel</button>
            <input type="submit" name="edit_submit" class="btn btn-small btn-blue" value="Apply"/>
        </div>
    </form>
</div>