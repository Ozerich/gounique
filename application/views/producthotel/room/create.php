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
    <?=form_open("product/hotels/room/create")?>
    <div class="param">
        <label for="code">Zimmercode</label>
        <input name="code" class="high-letters" type="text" id="code" maxlength="4"/>
    </div>
    <div class="param">
        <label for="name">Zimmername</label>
        <input name="name" type="text" class="high-letters" id="name"/>
    </div>
    <div class="param">
        <div class="left">
            <label for="min_pax">Min Pax</label>
            <input type="text" class="only-digits" name="min_pax" id="min_pax" maxlength="1"/>
        </div>
        <div class="right">
            <label for="max_pax">Max Pax</label>
            <input type="text" class="only-digits" name="max_pax" id="max_pax" maxlength="1"/>
        </div>
        <br class="clear"/>
    </div>
    <div class="param">
        <div class="left">
            <label for="min_erw">Min Erw</label>
            <input type="text" class="only-digits" name="min_erw" id="min_erw" maxlength="1"/>
        </div>
        <div class="right">
            <label for="max_erw">Max Erw</label>
            <input type="text" class="only-digits" name="max_erw" id="max_erw" maxlength="1">
        </div>
        <br class="clear"/>
    </div>
    <div class="param">
        <label for="capacity">Human style</label>
        <select name="capacity" id="capacity">
            <option value="EZ">EZ</option>
            <option value="DZ0">DZ0</option>
            <option value="DZ1">DZ1</option>
            <option value="DZ2">DZ2</option>
            <option value="DZ3">DZ3</option>
            <option value="DZ + Extra Bad">DZ + Extra Bad</option>
        </select>
    </div>
    <div class="submit">
        <input type="submit" name="zimmer_create" value="Apply">
    </div>
    <br class="clear"/>
    </form>
</div>