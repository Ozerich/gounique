<div id="page-header-wr">
    <div id="page-header">
        <a href="dashboard" class="home-link"><img src="img/header-logo.jpg"/></a>
        <ul class="page-path">
            <li><a href="product">product</a></li>
            <li><a href="product/hotels/main">hotelverwaltung</a></li>
            <li><a href="product/hotels/room">zimmerdaten</a></li>
        </ul>
    </div>
</div>

<div id="zimmercreate-page" class="content product-create">
    <?=form_open("product/hotels/room/edit/".$room->id)?>
    <div class="param">
        <label for="code">Zimmercode</label>
        <input name="code" type="text" id="code" class="high-letters" maxlength="4" value="<?=$room->code?>"/>
    </div>
    <div class="param">
        <label for="name">Zimmername</label>
        <input name="name" type="text" id="name" value="<?=$room->name?>"/>
    </div>
    <div class="param">
        <div class="left">
            <label for="min_pax">Min Pax</label>
            <input type="text" name="min_pax" class="only-digits" id="min_pax" maxlength="1" value="<?=$room->min_pax?>"/>
        </div>
        <div class="right">
            <label for="max_pax">Max Pax</label>
            <input type="text" name="max_pax" class="only-digits" id="max_pax" maxlength="1" value="<?=$room->max_pax?>"/>
        </div>
        <br class="clear"/>
    </div>
    <div class="param">
        <div class="left">
            <label for="min_erw">Min Erw</label>
            <input type="text" name="min_erw" class="only-digits" id="min_erw" maxlength="1" value="<?=$room->min_erw?>"/>
        </div>
        <div class="right">
            <label for="max_erw">Max Erw</label>
            <input type="text" name="max_erw" class="only-digits" id="max_erw" maxlength="1" value="<?=$room->max_erw?>">
        </div>
        <br class="clear"/>
    </div>
    <div class="param">
        <label for="capacity">Human style</label>
        <select name="capacity" id="capacity">
            <option value="EZ" <?if($room->capacity == "EZ") echo 'selected="selected"'?>>EZ</option>
            <option value="DZ0" <?if($room->capacity == "DZ0") echo 'selected="selected"'?>>DZ0</option>
            <option value="DZ1" <?if($room->capacity == "DZ1") echo 'selected="selected"'?>>DZ1</option>
            <option value="DZ2" <?if($room->capacity == "DZ2") echo 'selected="selected"'?>>DZ2</option>
            <option value="DZ3" <?if($room->capacity == "DZ3") echo 'selected="selected"'?>>DZ3</option>
            <option value="DZ + Extra Bad" <?if($room->capacity == "DZ + Extra Bad") echo 'selected="selected"'?>>DZ + Extra Bad</option>
        </select>
    </div>
    <div class="submit">
        <input type="submit" name="zimmer_edit" value="Apply">
    </div>
    <br class="clear"/>
    </form>
</div>